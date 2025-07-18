<div class="orders-container">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-shopping-bag"></i> My Orders</h1>
            <p>Track and manage your order history</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= $this->escape($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $this->escape($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($orders)): ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <h3>Order #<?= $this->escape($order['order_number']) ?></h3>
                                <p class="order-date">Placed on <?= $this->date($order['created_at'], 'F j, Y') ?></p>
                            </div>
                            <div class="order-status">
                                <span class="status-badge status-<?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="order-details">
                            <div class="order-summary">
                                <div class="summary-item">
                                    <span class="label">Total Amount:</span>
                                    <span class="value"><?= $this->currency($order['total_amount']) ?></span>
                                </div>
                                <div class="summary-item">
                                    <span class="label">Payment Status:</span>
                                    <span class="payment-status payment-<?= $order['payment_status'] ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </div>
                                <div class="summary-item">
                                    <span class="label">Items:</span>
                                    <span class="value"><?= $order['item_count'] ?? 'N/A' ?> items</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-actions">
                            <a href="<?= $this->url('/order/' . $order['id']) ?>" class="btn btn-outline">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                            <?php if ($order['status'] === 'pending'): ?>
                                <button class="btn btn-secondary" onclick="cancelOrder(<?= $order['id'] ?>)">
                                    <i class="fas fa-times"></i>
                                    Cancel Order
                                </button>
                            <?php endif; ?>
                            <?php if ($order['status'] === 'delivered'): ?>
                                <button class="btn btn-primary" onclick="reorder(<?= $order['id'] ?>)">
                                    <i class="fas fa-redo"></i>
                                    Reorder
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?php if ($current_page > 1): ?>
                            <a href="<?= $this->url('/orders?page=' . ($current_page - 1)) ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i>
                                Previous
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if ($i == $current_page): ?>
                                <span class="page-btn active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="<?= $this->url('/orders?page=' . $i) ?>" class="page-btn"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <a href="<?= $this->url('/orders?page=' . ($current_page + 1)) ?>" class="page-btn">
                                Next
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="pagination-info">
                        Showing page <?= $current_page ?> of <?= $total_pages ?> (<?= $total_orders ?> total orders)
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2>No orders yet</h2>
                <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="<?= $this->url('/products') ?>" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i>
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.orders-container {
    padding: 2rem 0;
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-header p {
    color: var(--text-secondary);
    font-size: 1.125rem;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.order-info h3 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
    font-size: 1.25rem;
}

.order-date {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipped { background: #d1fae5; color: #065f46; }
.status-delivered { background: #dcfce7; color: #166534; }
.status-cancelled { background: #fee2e2; color: #991b1b; }

.order-details {
    margin-bottom: 1.5rem;
}

.order-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: 8px;
}

.summary-item .label {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.summary-item .value {
    color: var(--text-primary);
    font-weight: 500;
}

.payment-status {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.payment-pending { background: #fef3c7; color: #92400e; }
.payment-paid { background: #dcfce7; color: #166534; }
.payment-failed { background: #fee2e2; color: #991b1b; }

.order-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-light);
    margin-bottom: 1.5rem;
}

.empty-state h2 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.125rem;
}

.pagination-container {
    margin-top: 3rem;
    text-align: center;
}

.pagination {
    display: inline-flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.page-btn {
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.page-btn:hover,
.page-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination-info {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .order-summary {
        grid-template-columns: 1fr;
    }
    
    .order-actions {
        flex-direction: column;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>

<script>
function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        // Implementation for order cancellation
        console.log('Cancel order:', orderId);
    }
}

function reorder(orderId) {
    // Implementation for reordering
    console.log('Reorder:', orderId);
}
</script>
