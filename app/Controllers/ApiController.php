<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Product;
use App\Models\User;
class ApiController extends Controller
{
    private $productModel;
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userModel = new User();
    }
    public function cartCount()
    {
        $cart = $_SESSION['cart'] ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        $this->json(['cart_count' => $count]);
    }
    public function toggleWishlist()
    {
        if (!$this->request->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login to use wishlist'], 401);
        }
        $productId = $this->request->post('product_id');
        $userId = $this->getCurrentUserId();
        if (!$productId) {
            $this->json(['success' => false, 'message' => 'Product ID is required'], 400);
        }
        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        try {
            $existingItem = $this->userModel->query(
                "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?",
                [$userId, $productId]
            );
            if (!empty($existingItem)) {
                $this->userModel->query(
                    "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?",
                    [$userId, $productId]
                );
                $message = 'Removed from wishlist';
                $inWishlist = false;
            } else {
                $this->userModel->query(
                    "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)",
                    [$userId, $productId]
                );
                $message = 'Added to wishlist';
                $inWishlist = true;
            }
            $this->json([
                'success' => true,
                'message' => $message,
                'in_wishlist' => $inWishlist
            ]);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Failed to update wishlist'], 500);
        }
    }
    public function searchProducts()
    {
        $query = $this->request->get('q', '');
        if (strlen($query) < 2) {
            $this->json(['products' => []]);
        }
        $products = $this->productModel->search($query, 10, 0);
        $results = array_map(function($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'sale_price' => $product['sale_price'],
                'image' => $product['primary_image'],
                'url' => '/product/' . $product['slug']
            ];
        }, $products);
        $this->json(['products' => $results]);
    }
    public function productQuickView()
    {
        $productId = $this->request->get('id');
        if (!$productId) {
            $this->json(['success' => false, 'message' => 'Product ID is required'], 400);
        }
        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $images = $this->productModel->getImages($productId);
        $relatedProducts = $this->productModel->getRelated($productId, $product['category_id'], 4);
        $this->json([
            'success' => true,
            'product' => $product,
            'images' => $images,
            'related_products' => $relatedProducts
        ]);
    }
    public function updateOrderStatus()
    {
        if (!$this->request->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }
        if (!$this->isAdmin()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $orderId = $this->request->post('order_id');
        $status = $this->request->post('status');
        if (!$orderId || !$status) {
            $this->json(['success' => false, 'message' => 'Order ID and status are required'], 400);
        }
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
        if (!in_array($status, $validStatuses)) {
            $this->json(['success' => false, 'message' => 'Invalid status'], 400);
        }
        try {
            $orderModel = new \App\Models\Order();
            $success = $orderModel->updateStatus($orderId, $status);
            if ($success) {
                $this->json([
                    'success' => true,
                    'message' => 'Order status updated successfully'
                ]);
            } else {
                $this->json(['success' => false, 'message' => 'Failed to update order status'], 500);
            }
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Failed to update order status'], 500);
        }
    }
    public function dashboardStats()
    {
        if (!$this->isAdmin()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        try {
            $orderModel = new \App\Models\Order();
            $categoryModel = new \App\Models\Category();
            $startOfMonth = date('Y-m-01');
            $endOfMonth = date('Y-m-t');
            $monthlyStats = $orderModel->getStats($startOfMonth, $endOfMonth);
            $prevMonthStart = date('Y-m-01', strtotime('-1 month'));
            $prevMonthEnd = date('Y-m-t', strtotime('-1 month'));
            $prevMonthStats = $orderModel->getStats($prevMonthStart, $prevMonthEnd);
            $revenueGrowth = $prevMonthStats['total_revenue'] > 0 
                ? (($monthlyStats['total_revenue'] - $prevMonthStats['total_revenue']) / $prevMonthStats['total_revenue']) * 100 
                : 0;
            $orderGrowth = $prevMonthStats['total_orders'] > 0 
                ? (($monthlyStats['total_orders'] - $prevMonthStats['total_orders']) / $prevMonthStats['total_orders']) * 100 
                : 0;
            $this->json([
                'success' => true,
                'stats' => [
                    'monthly_revenue' => $monthlyStats['total_revenue'],
                    'monthly_orders' => $monthlyStats['total_orders'],
                    'revenue_growth' => round($revenueGrowth, 1),
                    'order_growth' => round($orderGrowth, 1),
                    'total_products' => $this->productModel->count(['status' => 'active']),
                    'total_categories' => $categoryModel->count(['status' => 'active']),
                    'total_users' => $this->userModel->count(['role' => 'user'])
                ]
            ]);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Failed to fetch statistics'], 500);
        }
    }
    public function checkProductAvailability()
    {
        $productId = $this->request->get('product_id');
        $quantity = (int) $this->request->get('quantity', 1);
        if (!$productId) {
            $this->json(['success' => false, 'message' => 'Product ID is required'], 400);
        }
        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $isAvailable = $this->productModel->isInStock($productId, $quantity);
        $this->json([
            'success' => true,
            'available' => $isAvailable,
            'stock_quantity' => $product['stock_quantity'],
            'stock_status' => $product['stock_status']
        ]);
    }
}