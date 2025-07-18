<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class CartController extends Controller
{
    private $productModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = [];
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $productId => $item) {
                $product = $this->productModel->find($productId);
                if ($product) {
                    $images = $this->productModel->getImages($productId);
                    $primaryImage = !empty($images) ? $images[0]['image_path'] : null;
                    $price = $product['sale_price'] ?: $product['price'];
                    $itemTotal = $price * $item['quantity'];
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $price,
                        'total' => $itemTotal,
                        'image' => $primaryImage
                    ];
                    $total += $itemTotal;
                }
            }
        }
        $this->render('cart/index', [
            'title' => 'Shopping Cart',
            'cart_items' => $cartItems,
            'cart_total' => $total,
            'cart_count' => $this->getCartCount(),
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function add()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/cart');
        }

        // Debug logging
        error_log('CartController::add called');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('Is AJAX: ' . ($this->request->isAjax() ? 'yes' : 'no'));

        $productId = (int) $this->request->post('product_id');
        $quantity = (int) $this->request->post('quantity', 1);
        if ($quantity <= 0) {
            $quantity = 1;
        }
        $product = $this->productModel->find($productId);
        if (!$product || $product['status'] !== 'active') {
            if ($this->request->isAjax()) {
                $this->json(['success' => false, 'message' => 'Product not found']);
            }
            $this->setFlash('error', 'Product not found.');
            $this->redirect('/products');
        }
        if (!$this->productModel->isInStock($productId, $quantity)) {
            if ($this->request->isAjax()) {
                $this->json(['success' => false, 'message' => 'Product is out of stock']);
            }
            $this->setFlash('error', 'Product is out of stock.');
            $this->redirect('/product/' . $product['slug']);
        }
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if (!$this->productModel->isInStock($productId, $newQuantity)) {
                if ($this->request->isAjax()) {
                    $this->json(['success' => false, 'message' => 'Not enough stock available']);
                }
                $this->setFlash('error', 'Not enough stock available.');
                $this->redirect('/cart');
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
                'added_at' => time()
            ];
        }
        $this->setCart($cart);
        if ($this->request->isAjax()) {
            $this->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $this->getCartCount()
            ]);
        }
        $this->setFlash('success', 'Product added to cart successfully.');
        $this->redirect('/cart');
    }
    public function update()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/cart');
        }
        $productId = (int) $this->request->post('product_id');
        $quantity = (int) $this->request->post('quantity');
        if ($quantity <= 0) {
            return $this->remove();
        }
        $product = $this->productModel->find($productId);
        if (!$product) {
            if ($this->request->isAjax()) {
                $this->json(['success' => false, 'message' => 'Product not found']);
            }
            $this->setFlash('error', 'Product not found.');
            $this->redirect('/cart');
        }
        if (!$this->productModel->isInStock($productId, $quantity)) {
            if ($this->request->isAjax()) {
                $this->json(['success' => false, 'message' => 'Not enough stock available']);
            }
            $this->setFlash('error', 'Not enough stock available.');
            $this->redirect('/cart');
        }
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $this->setCart($cart);
            if ($this->request->isAjax()) {
                $price = $product['sale_price'] ?: $product['price'];
                $itemTotal = $price * $quantity;
                $cartTotal = $this->getCartTotal();
                $this->json([
                    'success' => true,
                    'message' => 'Cart updated',
                    'item_total' => $itemTotal,
                    'cart_total' => $cartTotal,
                    'cart_count' => $this->getCartCount()
                ]);
            }
            $this->setFlash('success', 'Cart updated successfully.');
        }
        $this->redirect('/cart');
    }
    public function remove()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/cart');
        }
        $productId = (int) $this->request->post('product_id');
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->setCart($cart);
            if ($this->request->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Item removed from cart',
                    'cart_total' => $this->getCartTotal(),
                    'cart_count' => $this->getCartCount()
                ]);
            }
            $this->setFlash('success', 'Item removed from cart.');
        }
        $this->redirect('/cart');
    }
    public function clear()
    {
        $this->setCart([]);
        if ($this->request->isAjax()) {
            $this->json([
                'success' => true,
                'message' => 'Cart cleared',
                'cart_count' => 0
            ]);
        }
        $this->setFlash('success', 'Cart cleared successfully.');
        $this->redirect('/cart');
    }
    private function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }
    private function setCart($cart)
    {
        $_SESSION['cart'] = $cart;
    }
    protected function getCartCount()
    {
        $cart = $this->getCart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    private function getCartTotal()
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $productId => $item) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $price = $product['sale_price'] ?: $product['price'];
                $total += $price * $item['quantity'];
            }
        }
        return $total;
    }
}
