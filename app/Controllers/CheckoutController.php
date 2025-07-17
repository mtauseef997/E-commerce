<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
class CheckoutController extends Controller
{
    private $productModel;
    private $orderModel;
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->requireAuth();
    }
    public function index()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            $this->setFlash('error', 'Your cart is empty.');
            $this->redirect('/cart');
        }
        $cartItems = [];
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = $this->productModel->find($productId);
            if ($product && $this->productModel->isInStock($productId, $item['quantity'])) {
                $price = $product['sale_price'] ?: $product['price'];
                $itemTotal = $price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $itemTotal
                ];
                $subtotal += $itemTotal;
            } else {
                unset($cart[$productId]);
                $this->setCart($cart);
                $this->setFlash('error', 'Some items were removed from your cart due to stock unavailability.');
            }
        }
        if (empty($cartItems)) {
            $this->setFlash('error', 'Your cart is empty or all items are out of stock.');
            $this->redirect('/cart');
        }
        $taxRate = 0.08;
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal > 100 ? 0 : 10;
        $total = $subtotal + $taxAmount + $shippingAmount;
        $user = $this->getCurrentUser();
        $addresses = $this->userModel->getAddresses($user['id']);
        $this->render('checkout/index', [
            'title' => 'Checkout',
            'cart_items' => $cartItems,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total' => $total,
            'user' => $user,
            'addresses' => $addresses,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function process()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/checkout');
        }
        $this->validateCsrf();
        $cart = $this->getCart();
        if (empty($cart)) {
            $this->setFlash('error', 'Your cart is empty.');
            $this->redirect('/cart');
        }
        $userId = $this->getCurrentUserId();
        $billingAddress = [
            'first_name' => $this->request->post('billing_first_name'),
            'last_name' => $this->request->post('billing_last_name'),
            'company' => $this->request->post('billing_company'),
            'address_line_1' => $this->request->post('billing_address_1'),
            'address_line_2' => $this->request->post('billing_address_2'),
            'city' => $this->request->post('billing_city'),
            'state' => $this->request->post('billing_state'),
            'postal_code' => $this->request->post('billing_postal_code'),
            'country' => $this->request->post('billing_country'),
            'phone' => $this->request->post('billing_phone')
        ];
        $shippingAddress = $billingAddress;
        if ($this->request->post('different_shipping')) {
            $shippingAddress = [
                'first_name' => $this->request->post('shipping_first_name'),
                'last_name' => $this->request->post('shipping_last_name'),
                'company' => $this->request->post('shipping_company'),
                'address_line_1' => $this->request->post('shipping_address_1'),
                'address_line_2' => $this->request->post('shipping_address_2'),
                'city' => $this->request->post('shipping_city'),
                'state' => $this->request->post('shipping_state'),
                'postal_code' => $this->request->post('shipping_postal_code'),
                'country' => $this->request->post('shipping_country'),
                'phone' => $this->request->post('shipping_phone')
            ];
        }
        $paymentMethod = $this->request->post('payment_method');
        $notes = $this->request->post('notes');
        $errors = $this->request->validate([
            'billing_first_name' => 'required',
            'billing_last_name' => 'required',
            'billing_address_1' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_postal_code' => 'required',
            'billing_country' => 'required',
            'payment_method' => 'required'
        ]);
        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $field => $fieldErrors) {
                $errorMessages = array_merge($errorMessages, $fieldErrors);
            }
            $this->setFlash('error', implode('<br>', $errorMessages));
            $this->redirect('/checkout');
        }
        $orderItems = [];
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = $this->productModel->find($productId);
            if (!$product || !$this->productModel->isInStock($productId, $item['quantity'])) {
                $this->setFlash('error', 'Some items in your cart are no longer available.');
                $this->redirect('/checkout');
            }
            $price = $product['sale_price'] ?: $product['price'];
            $itemTotal = $price * $item['quantity'];
            $orderItems[] = [
                'product_id' => $productId,
                'product_name' => $product['name'],
                'product_sku' => $product['sku'],
                'quantity' => $item['quantity'],
                'price' => $price,
                'total' => $itemTotal
            ];
            $subtotal += $itemTotal;
        }
        $taxRate = 0.08;
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal > 100 ? 0 : 10;
        $total = $subtotal + $taxAmount + $shippingAmount;
        $orderData = [
            'user_id' => $userId,
            'status' => 'pending',
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'discount_amount' => 0,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'billing_address' => json_encode($billingAddress),
            'shipping_address' => json_encode($shippingAddress),
            'notes' => $notes
        ];
        try {
            $orderId = $this->orderModel->createOrder($orderData, $orderItems);
            $this->setCart([]);
            $this->redirect('/checkout/success?order=' . $orderId);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Failed to process order. Please try again.');
            $this->redirect('/checkout');
        }
    }
    public function success()
    {
        $orderId = $this->request->get('order');
        if (!$orderId) {
            $this->redirect('/');
        }
        $order = $this->orderModel->getOrderWithItems($orderId);
        if (!$order || $order['user_id'] != $this->getCurrentUserId()) {
            $this->redirect('/');
        }
        $this->render('checkout/success', [
            'title' => 'Order Successful',
            'order' => $order
        ]);
    }
    private function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }
    private function setCart($cart)
    {
        $_SESSION['cart'] = $cart;
    }
}