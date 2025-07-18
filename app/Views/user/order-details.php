<div class="order-details-page">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= $this->url('/') ?>">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= $this->url('/profile') ?>">My Account</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= $this->url('/orders') ?>">Orders</a>
                </li>
                <li class="breadcrumb-item active">Order #<?= $order['order_number'] ?></li>
            </ol>
        </div>
    </nav>

    <!-- Order Header -->
    <section class="order-header">
        <div class="container">
            <div class="order-title">
                <h1>
                    <i class="fas fa-receipt"></i>
                    Order #<?= $order['order_number'] ?>
                </h1>
                <div class="order-meta">
                    <span class="order-date">
                        <i class="fas fa-calendar"></i>
                        Placed on <?= date('F j, Y \a\t g:i A', strtotime($order['created_at'])) ?>
                    </span>
                    <span class="order-status status-<?= strtolower($order['status']) ?>">
                        <i class="fas fa-circle"></i>
                        <?= ucfirst($order['status']) ?>
                    </span>
                </div>
            </div>
            
            <div class="order-actions">
                <?php if ($order['status'] === 'pending'): ?>
                    <button class="btn btn-outline" onclick="cancelOrder(<?= $order['id'] ?>)">
                        <i class="fas fa-times"></i>
                        Cancel Order
                    </button>
                <?php endif; ?>
                
                <button class="btn btn-secondary" onclick="printOrder()">
                    <i class="fas fa-print"></i>
                    Print Order
                </button>
                
                <?php if ($order['status'] === 'delivered'): ?>
                    <a href="<?= $this->url('/orders/' . $order['id'] . '/invoice') ?>" class="btn btn-primary">
                        <i class="fas fa-download"></i>
                        Download Invoice
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Order Content -->
    <section class="order-content">
        <div class="container">
            <div class="order-layout">
                <!-- Order Items -->
                <div class="order-main">
                    <div class="order-card">
                        <h2>
                            <i class="fas fa-box"></i>
                            Order Items (<?= count($order_items) ?> items)
                        </h2>
                        
                        <div class="order-items">
                            <?php foreach ($order_items as $item): ?>
                                <div class="order-item">
                                    <div class="item-image">
                                        <?php if (!empty($item['product_image'])): ?>
                                            <img src="<?= $this->asset('images/products/' . $item['product_image']) ?>" 
                                                 alt="<?= $this->escape($item['product_name']) ?>">
                                        <?php else: ?>
                                            <div class="product-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="item-details">
                                        <h3 class="item-name">
                                            <?= $this->escape($item['product_name']) ?>
                                        </h3>
                                        
                                        <?php if (!empty($item['product_sku'])): ?>
                                            <p class="item-sku">SKU: <?= $this->escape($item['product_sku']) ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="item-price">
                                            <span class="unit-price">$<?= number_format($item['price'], 2) ?> each</span>
                                            <span class="quantity">Qty: <?= $item['quantity'] ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="item-total">
                                        <span class="total-price">$<?= number_format($item['total'], 2) ?></span>
                                    </div>
                                    
                                    <div class="item-actions">
                                        <?php if ($order['status'] === 'delivered'): ?>
                                            <button class="btn btn-sm btn-outline" onclick="reorderItem(<?= $item['product_id'] ?>)">
                                                <i class="fas fa-redo"></i>
                                                Reorder
                                            </button>
                                            <button class="btn btn-sm btn-secondary" onclick="reviewProduct(<?= $item['product_id'] ?>)">
                                                <i class="fas fa-star"></i>
                                                Review
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="order-card">
                        <h2>
                            <i class="fas fa-history"></i>
                            Order Timeline
                        </h2>
                        
                        <div class="order-timeline">
                            <div class="timeline-item <?= $order['status'] !== 'cancelled' ? 'completed' : '' ?>">
                                <div class="timeline-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Order Placed</h4>
                                    <p><?= date('F j, Y \a\t g:i A', strtotime($order['created_at'])) ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?= in_array($order['status'], ['processing', 'shipped', 'delivered']) ? 'completed' : '' ?>">
                                <div class="timeline-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Order Processing</h4>
                                    <p><?= in_array($order['status'], ['processing', 'shipped', 'delivered']) ? 'Your order is being prepared' : 'Waiting for processing' ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?= in_array($order['status'], ['shipped', 'delivered']) ? 'completed' : '' ?>">
                                <div class="timeline-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Order Shipped</h4>
                                    <p><?= in_array($order['status'], ['shipped', 'delivered']) ? 'Your order has been shipped' : 'Waiting for shipment' ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?= $order['status'] === 'delivered' ? 'completed' : '' ?>">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>Order Delivered</h4>
                                    <p><?= $order['status'] === 'delivered' ? 'Your order has been delivered' : 'Pending delivery' ?></p>
                                </div>
                            </div>
                            
                            <?php if ($order['status'] === 'cancelled'): ?>
                                <div class="timeline-item cancelled">
                                    <div class="timeline-icon">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h4>Order Cancelled</h4>
                                        <p>This order has been cancelled</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Sidebar -->
                <div class="order-sidebar">
                    <!-- Order Summary -->
                    <div class="order-card">
                        <h3>
                            <i class="fas fa-calculator"></i>
                            Order Summary
                        </h3>
                        
                        <div class="order-totals">
                            <div class="total-row">
                                <span class="total-label">Subtotal:</span>
                                <span class="total-value">$<?= number_format($order['subtotal'], 2) ?></span>
                            </div>
                            
                            <?php if ($order['tax_amount'] > 0): ?>
                                <div class="total-row">
                                    <span class="total-label">Tax:</span>
                                    <span class="total-value">$<?= number_format($order['tax_amount'], 2) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($order['shipping_amount'] > 0): ?>
                                <div class="total-row">
                                    <span class="total-label">Shipping:</span>
                                    <span class="total-value">$<?= number_format($order['shipping_amount'], 2) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($order['discount_amount'] > 0): ?>
                                <div class="total-row discount">
                                    <span class="total-label">Discount:</span>
                                    <span class="total-value">-$<?= number_format($order['discount_amount'], 2) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="total-row total-final">
                                <span class="total-label">Total:</span>
                                <span class="total-value">$<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="order-card">
                        <h3>
                            <i class="fas fa-credit-card"></i>
                            Payment Information
                        </h3>
                        
                        <div class="payment-info">
                            <div class="payment-method">
                                <span class="payment-label">Payment Method:</span>
                                <span class="payment-value">
                                    <?php
                                    $paymentMethods = [
                                        'credit_card' => 'Credit Card',
                                        'paypal' => 'PayPal',
                                        'bank_transfer' => 'Bank Transfer',
                                        'cash_on_delivery' => 'Cash on Delivery'
                                    ];
                                    echo $paymentMethods[$order['payment_method']] ?? ucfirst(str_replace('_', ' ', $order['payment_method']));
                                    ?>
                                </span>
                            </div>
                            
                            <div class="payment-status">
                                <span class="payment-label">Payment Status:</span>
                                <span class="payment-value status-<?= $order['payment_status'] ?>">
                                    <i class="fas fa-circle"></i>
                                    <?= ucfirst($order['payment_status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="order-card">
                        <h3>
                            <i class="fas fa-truck"></i>
                            Shipping Address
                        </h3>
                        
                        <div class="address-info">
                            <?php 
                            $shippingAddress = json_decode($order['shipping_address'], true);
                            if ($shippingAddress):
                            ?>
                                <div class="address">
                                    <p><strong><?= $this->escape($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']) ?></strong></p>
                                    <?php if (!empty($shippingAddress['company'])): ?>
                                        <p><?= $this->escape($shippingAddress['company']) ?></p>
                                    <?php endif; ?>
                                    <p><?= $this->escape($shippingAddress['address_line_1']) ?></p>
                                    <?php if (!empty($shippingAddress['address_line_2'])): ?>
                                        <p><?= $this->escape($shippingAddress['address_line_2']) ?></p>
                                    <?php endif; ?>
                                    <p>
                                        <?= $this->escape($shippingAddress['city']) ?>, 
                                        <?= $this->escape($shippingAddress['state']) ?> 
                                        <?= $this->escape($shippingAddress['postal_code']) ?>
                                    </p>
                                    <p><?= $this->escape($shippingAddress['country']) ?></p>
                                    <?php if (!empty($shippingAddress['phone'])): ?>
                                        <p><i class="fas fa-phone"></i> <?= $this->escape($shippingAddress['phone']) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <p>No shipping address available</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="order-card">
                        <h3>
                            <i class="fas fa-file-invoice"></i>
                            Billing Address
                        </h3>
                        
                        <div class="address-info">
                            <?php 
                            $billingAddress = json_decode($order['billing_address'], true);
                            if ($billingAddress):
                            ?>
                                <div class="address">
                                    <p><strong><?= $this->escape($billingAddress['first_name'] . ' ' . $billingAddress['last_name']) ?></strong></p>
                                    <?php if (!empty($billingAddress['company'])): ?>
                                        <p><?= $this->escape($billingAddress['company']) ?></p>
                                    <?php endif; ?>
                                    <p><?= $this->escape($billingAddress['address_line_1']) ?></p>
                                    <?php if (!empty($billingAddress['address_line_2'])): ?>
                                        <p><?= $this->escape($billingAddress['address_line_2']) ?></p>
                                    <?php endif; ?>
                                    <p>
                                        <?= $this->escape($billingAddress['city']) ?>, 
                                        <?= $this->escape($billingAddress['state']) ?> 
                                        <?= $this->escape($billingAddress['postal_code']) ?>
                                    </p>
                                    <p><?= $this->escape($billingAddress['country']) ?></p>
                                    <?php if (!empty($billingAddress['phone'])): ?>
                                        <p><i class="fas fa-phone"></i> <?= $this->escape($billingAddress['phone']) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <p>No billing address available</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($order['notes'])): ?>
                        <!-- Order Notes -->
                        <div class="order-card">
                            <h3>
                                <i class="fas fa-sticky-note"></i>
                                Order Notes
                            </h3>
                            
                            <div class="order-notes">
                                <p><?= $this->escape($order['notes']) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Order Details Page Styles */
.order-details-page {
    padding-top: 0;
}

.order-header {
    padding: 3rem 0;
    background: var(--bg-primary);
    border-bottom: 1px solid var(--border-color);
}

.order-header .container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 2rem;
}

.order-title h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.order-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.order-date,
.order-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.order-date {
    color: var(--text-secondary);
}

.order-status {
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background: var(--bg-secondary);
}

.status-pending { color: var(--warning-color); }
.status-processing { color: var(--info-color); }
.status-shipped { color: var(--primary-color); }
.status-delivered { color: var(--success-color); }
.status-cancelled { color: var(--error-color); }

.order-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.order-content {
    padding: 3rem 0;
}

.order-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.order-card {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    margin-bottom: 2rem;
}

.order-card h2,
.order-card h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.order-card h2 {
    font-size: 1.5rem;
}

.order-card h3 {
    font-size: 1.25rem;
}

/* Order Items */
.order-items {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-item {
    display: grid;
    grid-template-columns: 80px 1fr auto auto;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
}

.item-image {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-placeholder {
    width: 100%;
    height: 100%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
}

.item-name {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.item-sku {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.item-price {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.unit-price {
    font-weight: 600;
    color: var(--text-primary);
}

.quantity {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.item-total {
    text-align: right;
}

.total-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

.item-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Order Timeline */
.order-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    width: 2px;
    height: calc(100% + 1rem);
    background: var(--border-light);
}

.timeline-item.completed::after {
    background: var(--success-color);
}

.timeline-item.cancelled::after {
    background: var(--error-color);
}

.timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--bg-secondary);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 1;
}

.timeline-item.completed .timeline-icon {
    background: var(--success-color);
    color: white;
}

.timeline-item.cancelled .timeline-icon {
    background: var(--error-color);
    color: white;
}

.timeline-content h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.timeline-content p {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Order Totals */
.order-totals {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.total-row:not(:last-child) {
    border-bottom: 1px solid var(--border-light);
}

.total-final {
    font-size: 1.125rem;
    font-weight: 700;
    border-top: 2px solid var(--border-color);
    padding-top: 1rem;
    margin-top: 0.5rem;
}

.total-label {
    color: var(--text-secondary);
}

.total-value {
    font-weight: 600;
    color: var(--text-primary);
}

.discount .total-value {
    color: var(--success-color);
}

/* Payment & Address Info */
.payment-info,
.address-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-method,
.payment-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-light);
}

.payment-label {
    color: var(--text-secondary);
    font-weight: 500;
}

.payment-value {
    font-weight: 600;
    color: var(--text-primary);
}

.payment-value.status-paid {
    color: var(--success-color);
}

.payment-value.status-pending {
    color: var(--warning-color);
}

.payment-value.status-failed {
    color: var(--error-color);
}

.address p {
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.order-notes p {
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 1024px) {
    .order-layout {
        grid-template-columns: 1fr;
    }
    
    .order-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .order-header .container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .order-title h1 {
        font-size: 1.5rem;
    }
    
    .order-actions {
        justify-content: center;
    }
    
    .order-item {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1rem;
    }
    
    .item-actions {
        flex-direction: row;
        justify-content: center;
    }
}

/* Print Styles */
@media print {
    .order-actions,
    .breadcrumb-nav {
        display: none;
    }
    
    .order-header {
        background: none;
        border: none;
    }
    
    .order-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}
</style>

<script>
function cancelOrder(orderId) {
    if (!confirm('Are you sure you want to cancel this order?')) {
        return;
    }
    
    fetch(`/orders/${orderId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Failed to cancel order');
        }
    })
    .catch(error => {
        console.error('Cancel order error:', error);
        alert('Failed to cancel order');
    });
}

function printOrder() {
    window.print();
}

function reorderItem(productId) {
    if (window.addToCart) {
        window.addToCart(productId);
    } else {
        alert('Cart functionality not available');
    }
}

function reviewProduct(productId) {
    // Redirect to product page for review
    window.location.href = `/product/${productId}#reviews`;
}
</script>
