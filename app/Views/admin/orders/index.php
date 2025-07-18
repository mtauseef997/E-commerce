<div class="admin-header">
    <div class="admin-header-content">
        <div class="admin-title">
            <h1><i class="fas fa-shopping-bag"></i> Manage Orders</h1>
            <p>Process and track customer orders</p>
        </div>
        <div class="admin-actions">
            <button class="btn btn-outline" onclick="exportOrders()">
                <i class="fas fa-download"></i>
                Export Orders
            </button>
            <button class="btn btn-primary" onclick="refreshOrders()">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>
    </div>
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


<div class="order-stats">
    <div class="stat-card">
        <div class="stat-icon pending">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_orders ?></h3>
            <p>Total Orders</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon processing">
            <i class="fas fa-cog"></i>
        </div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Processing</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon shipped">
            <i class="fas fa-truck"></i>
        </div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Shipped</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon delivered">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>0</h3>
            <p>Delivered</p>
        </div>
    </div>
</div>


<div class="admin-filters">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <label for="status">Order Status</label>
            <select id="status" name="status" class="form-control" onchange="this.form.submit()">
                <option value="">All Orders</option>
                <option value="pending" <?= ($status_filter ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="processing" <?= ($status_filter ?? '') === 'processing' ? 'selected' : '' ?>>Processing
                </option>
                <option value="shipped" <?= ($status_filter ?? '') === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="delivered" <?= ($status_filter ?? '') === 'delivered' ? 'selected' : '' ?>>Delivered
                </option>
                <option value="cancelled" <?= ($status_filter ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled
                </option>
                <option value="refunded" <?= ($status_filter ?? '') === 'refunded' ? 'selected' : '' ?>>Refunded
                </option>
            </select>
        </div>

        <div class="filter-group">
            <label for="date_range">Date Range</label>
            <select id="date_range" name="date_range" class="form-control">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="quarter">This Quarter</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="search">Search Orders</label>
            <input type="text" id="search" name="search" placeholder="Order number, customer name, email..."
                class="form-control">
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Filter
            </button>
            <a href="<?= $this->url('/admin/orders') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<div class="admin-table-container">
    <?php if (!empty($orders)): ?>
    <div class="table-header">
        <div class="table-info">
            <span class="results-count">
                Showing <?= count($orders) ?> of <?= $total_orders ?> orders
            </span>
        </div>
        <div class="table-actions">
            <button class="btn btn-outline btn-sm" onclick="selectAll()">
                <i class="fas fa-check-square"></i>
                Select All
            </button>
            <button class="btn btn-outline btn-sm" onclick="bulkUpdateStatus()">
                <i class="fas fa-edit"></i>
                Bulk Update
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="order-checkbox" value="<?= $order['id'] ?>">
                    </td>
                    <td>
                        <div class="order-number">
                            <strong>#<?= $this->escape($order['order_number']) ?></strong>
                        </div>
                    </td>
                    <td>
                        <div class="customer-info">
                            <div class="customer-name">
                                <?= $this->escape(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '')) ?>
                            </div>
                            <div class="customer-email">
                                <?= $this->escape($order['email'] ?? 'N/A') ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="order-date">
                            <div class="date"><?= $this->date($order['created_at'], 'M j, Y') ?></div>
                            <div class="time"><?= $this->date($order['created_at'], 'g:i A') ?></div>
                        </div>
                    </td>
                    <td>
                        <div class="order-items">
                            <span class="item-count"><?= $order['item_count'] ?? 'N/A' ?> items</span>
                        </div>
                    </td>
                    <td>
                        <div class="order-total">
                            <strong><?= $this->currency($order['total_amount']) ?></strong>
                        </div>
                    </td>
                    <td>
                        <span class="payment-status payment-<?= $order['payment_status'] ?>">
                            <?= ucfirst($order['payment_status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="status-container">
                            <select class="status-select" data-order-id="<?= $order['id'] ?>"
                                onchange="updateOrderStatus(<?= $order['id'] ?>, this.value)">
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
                                <option value="refunded" <?= $order['status'] === 'refunded' ? 'selected' : '' ?>>
                                    Refunded</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="viewOrder(<?= $order['id'] ?>)" class="btn btn-sm btn-outline"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="printOrder(<?= $order['id'] ?>)" class="btn btn-sm btn-secondary"
                                title="Print Order">
                                <i class="fas fa-print"></i>
                            </button>
                            <button onclick="sendEmail(<?= $order['id'] ?>)" class="btn btn-sm btn-primary"
                                title="Send Email">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
    <div class="admin-pagination">
        <div class="pagination-info">
            Page <?= $current_page ?> of <?= $total_pages ?>
        </div>
        <div class="pagination-controls">
            <?php if ($current_page > 1): ?>
            <a href="<?= $this->url('/admin/orders?page=' . ($current_page - 1) . ($status_filter ? '&status=' . $status_filter : '')) ?>"
                class="btn btn-outline">
                <i class="fas fa-chevron-left"></i>
                Previous
            </a>
            <?php endif; ?>

            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <?php if ($i == $current_page): ?>
            <span class="btn btn-primary"><?= $i ?></span>
            <?php else: ?>
            <a href="<?= $this->url('/admin/orders?page=' . $i . ($status_filter ? '&status=' . $status_filter : '')) ?>"
                class="btn btn-outline"><?= $i ?></a>
            <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
            <a href="<?= $this->url('/admin/orders?page=' . ($current_page + 1) . ($status_filter ? '&status=' . $status_filter : '')) ?>"
                class="btn btn-outline">
                Next
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h3>No orders found</h3>
        <p>No orders match your current filters or no orders have been placed yet.</p>
        <a href="<?= $this->url('/admin/orders') ?>" class="btn btn-primary">
            <i class="fas fa-refresh"></i>
            View All Orders
        </a>
    </div>
    <?php endif; ?>
</div>


<div class="modal" id="orderModal">
    <div class="modal-content large">
        <div class="modal-header">
            <h2 id="orderModalTitle">Order Details</h2>
            <button class="modal-close" onclick="closeOrderModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="orderModalBody">

        </div>
    </div>
</div>

<style>
.order-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-icon.pending {
    background: #f59e0b;
}

.stat-icon.processing {
    background: #3b82f6;
}

.stat-icon.shipped {
    background: #10b981;
}

.stat-icon.delivered {
    background: #059669;
}

.stat-info h3 {
    margin: 0 0 0.25rem 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.customer-info {
    min-width: 150px;
}

.customer-name {
    font-weight: 500;
    color: var(--text-primary);
}

.customer-email {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.order-date .date {
    font-weight: 500;
    color: var(--text-primary);
}

.order-date .time {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.order-items {
    text-align: center;
}

.item-count {
    background: var(--bg-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}

.order-total {
    text-align: right;
    font-size: 1.125rem;
}

.payment-status {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.payment-pending {
    background: #fef3c7;
    color: #92400e;
}

.payment-paid {
    background: #dcfce7;
    color: #166534;
}

.payment-failed {
    background: #fee2e2;
    color: #991b1b;
}

.payment-refunded {
    background: #e0e7ff;
    color: #3730a3;
}

.status-select {
    padding: 0.25rem 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 0.875rem;
    min-width: 100px;
}

.status-select:focus {
    outline: none;
    border-color: var(--primary-color);
}

.modal-content.large {
    max-width: 800px;
}

@media (max-width: 768px) {
    .order-stats {
        grid-template-columns: 1fr;
    }

    .admin-table {
        font-size: 0.875rem;
    }

    .customer-info,
    .order-date {
        min-width: auto;
    }
}
</style>

<script>
function updateOrderStatus(orderId, newStatus) {
    if (confirm(`Are you sure you want to change this order status to "${newStatus}"?`)) {
        fetch(`/admin/orders/${orderId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update order status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the order status');
            });
    }
}

function viewOrder(orderId) {

    document.getElementById('orderModalTitle').textContent = `Order #${orderId}`;
    document.getElementById('orderModalBody').innerHTML = '<div class="loading">Loading order details...</div>';
    document.getElementById('orderModal').classList.add('active');


    console.log('View order:', orderId);
}

function closeOrderModal() {
    document.getElementById('orderModal').classList.remove('active');
}

function printOrder(orderId) {

    window.open(`/admin/orders/${orderId}/print`, '_blank');
}

function sendEmail(orderId) {

    if (confirm('Send order confirmation email to customer?')) {
        console.log('Send email for order:', orderId);
    }
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.order-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function bulkUpdateStatus() {
    const selectedOrders = document.querySelectorAll('.order-checkbox:checked');

    if (selectedOrders.length === 0) {
        alert('Please select orders to update.');
        return;
    }

    const newStatus = prompt('Enter new status (pending, processing, shipped, delivered, cancelled, refunded):');
    if (newStatus && confirm(`Update ${selectedOrders.length} orders to "${newStatus}"?`)) {
        console.log('Bulk update:', Array.from(selectedOrders).map(cb => cb.value), 'to', newStatus);
    }
}

function exportOrders() {

    window.location.href = '/admin/orders/export';
}

function refreshOrders() {
    location.reload();
}


document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderModal();
    }
});
</script>