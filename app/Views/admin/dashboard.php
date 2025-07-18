<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Products</div>
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($stats['total_products']) ?></div>
        <div class="stat-change">
            <i class="fas fa-arrow-up"></i>
            Active products in store
        </div>
    </div>
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-title">Total Orders</div>
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($stats['total_orders']) ?></div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            All time orders
        </div>
    </div>
    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-title">Total Users</div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($stats['total_users']) ?></div>
        <div class="stat-change">
            <i class="fas fa-user-plus"></i>
            Registered customers
        </div>
    </div>
    <div class="stat-card error">
        <div class="stat-header">
            <div class="stat-title">Pending Orders</div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($stats['pending_orders']) ?></div>
        <div class="stat-change">
            <i class="fas fa-exclamation-triangle"></i>
            Require attention
        </div>
    </div>
</div>

<?php if ($monthly_stats): ?>
<div class="dashboard-stats">
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-title">Monthly Revenue</div>
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stat-value"><?= $this->currency($monthly_stats['total_revenue'] ?? 0) ?></div>
        <div class="stat-change positive">
            <i class="fas fa-chart-line"></i>
            This month's earnings
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Monthly Orders</div>
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($monthly_stats['total_orders'] ?? 0) ?></div>
        <div class="stat-change">
            <i class="fas fa-calendar-alt"></i>
            Orders this month
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Average Order</div>
            <div class="stat-icon">
                <i class="fas fa-calculator"></i>
            </div>
        </div>
        <div class="stat-value"><?= $this->currency($monthly_stats['avg_order_value'] ?? 0) ?></div>
        <div class="stat-change">
            <i class="fas fa-equals"></i>
            Average order value
        </div>
    </div>
    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-title">Cancelled Orders</div>
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
        <div class="stat-value"><?= number_format($monthly_stats['cancelled_orders'] ?? 0) ?></div>
        <div class="stat-change">
            <i class="fas fa-ban"></i>
            This month
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (!empty($recent_orders)): ?>
<div class="data-table">
    <div class="table-header">
        <h3 class="table-title">Recent Orders</h3>
        <div class="table-actions">
            <a href="<?= $this->url('/admin/orders') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i>
                View All Orders
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_orders as $order): ?>
                <tr>
                    <td>
                        <strong><?= $this->escape($order['order_number']) ?></strong>
                    </td>
                    <td>
                        <div>
                            <strong><?= $this->escape($order['first_name'] . ' ' . $order['last_name']) ?></strong>
                            <br>
                            <small class="text-muted"><?= $this->escape($order['email']) ?></small>
                        </div>
                    </td>
                    <td>
                        <span class="badge"><?= $order['item_count'] ?> items</span>
                    </td>
                    <td>
                        <strong><?= $this->currency($order['total_amount']) ?></strong>
                    </td>
                    <td>
                        <span class="status-badge <?= $order['status'] ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?= $this->date($order['created_at'], 'M j, Y') ?>
                    </td>
                    <td>
                        <div class="table-actions-cell">
                            <a href="<?= $this->url('/admin/order/' . $order['id']) ?>" class="btn btn-sm btn-outline"
                                title="View Order">
                                <i class="fas fa-eye"></i>
                            </a>
                            <select class="form-select form-select-sm"
                                onchange="updateOrderStatus(<?= $order['id'] ?>, this.value)">
                                <option value="">Change Status</option>
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>
                                    Processing</option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped
                                </option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>
                                    Delivered</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>
                                    Cancelled</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<div class="dashboard-actions" style="margin-top: 2rem;">
    <div class="form-grid">
        <div class="form-section">
            <h3 class="form-section-title">Quick Actions</h3>
            <div class="action-buttons">
                <a href="<?= $this->url('/admin/product/create') ?>" class="btn btn-primary btn-full">
                    <i class="fas fa-plus"></i>
                    Add New Product
                </a>
                <a href="<?= $this->url('/admin/orders?status=pending') ?>" class="btn btn-warning btn-full">
                    <i class="fas fa-clock"></i>
                    View Pending Orders
                </a>
                <a href="<?= $this->url('/admin/users') ?>" class="btn btn-secondary btn-full">
                    <i class="fas fa-users"></i>
                    Manage Users
                </a>
            </div>
        </div>
        <div class="form-section">
            <h3 class="form-section-title">System Status</h3>
            <div class="system-status">
                <div class="status-item">
                    <div class="status-indicator success"></div>
                    <span>Database Connection</span>
                    <span class="status-value">Online</span>
                </div>
                <div class="status-item">
                    <div class="status-indicator success"></div>
                    <span>File Uploads</span>
                    <span class="status-value">Working</span>
                </div>
                <div class="status-item">
                    <div class="status-indicator success"></div>
                    <span>Email Service</span>
                    <span class="status-value">Active</span>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.system-status {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
}

.status-indicator {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    background: var(--success-color);
}

.status-indicator.warning {
    background: var(--warning-color);
}

.status-indicator.error {
    background: var(--error-color);
}

.status-value {
    margin-left: auto;
    font-weight: 500;
    color: var(--success-color);
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    background: var(--primary-color);
    color: white;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 500;
}

.text-muted {
    color: var(--text-light);
}

.form-select-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>
<script>
async function updateOrderStatus(orderId, status) {
    if (!status) return;
    try {
        const response = await App.makeRequest('/api/order/status', {
            method: 'POST',
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        });
        if (response.success) {
            App.showNotification('Order status updated successfully', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            App.showNotification(response.message, 'error');
        }
    } catch (error) {
        App.showNotification('Failed to update order status', 'error');
    }
}
</script>