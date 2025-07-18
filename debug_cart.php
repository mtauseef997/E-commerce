<?php
session_start();

// Simple debug script to test cart functionality
header('Content-Type: application/json');

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['error' => 'Only POST requests allowed', 'method' => $_SERVER['REQUEST_METHOD']]);
        exit;
    }
    
    // Check if it's an AJAX request
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    
    // Get POST data
    $productId = (int) ($_POST['product_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 1);
    
    // Debug info
    $debug = [
        'success' => true,
        'message' => 'Debug cart add endpoint',
        'data' => [
            'is_ajax' => $isAjax,
            'product_id' => $productId,
            'quantity' => $quantity,
            'post_data' => $_POST,
            'headers' => getallheaders(),
            'session_id' => session_id(),
            'current_cart' => $_SESSION['cart'] ?? []
        ]
    ];
    
    // Simulate adding to cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'quantity' => $quantity,
            'added_at' => time()
        ];
    }
    
    // Calculate cart count
    $cartCount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
    
    $debug['data']['new_cart'] = $_SESSION['cart'];
    $debug['data']['cart_count'] = $cartCount;
    
    echo json_encode($debug);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>
