<div class="success-page">
    <div class="container">
        <div class="success-content">

            <div class="success-icon">
                <div class="icon-circle">
                    <i class="fas fa-check"></i>
                </div>
            </div>


            <div class="success-message">
                <h1>Order Placed Successfully!</h1>
                <p class="success-subtitle">
                    Thank you for your purchase. Your order has been received and is being processed.
                </p>
            </div>

            <div class="order-details">
                <div class="order-header">
                    <h2>Order Details</h2>
                    <div class="order-meta">
                        <span class="order-number">Order #<?= $order['id'] ?></span>
                        <span class="order-date"><?= date('F j, Y', strtotime($order['created_at'])) ?></span>
                    </div>
                </div>

                <div class="order-info-grid">

                    <div class="order-summary-card">
                        <h3>Order Summary</h3>
                        <div class="order-items">
                            <?php foreach ($order['items'] as $item): ?>
                            <div class="order-item">
                                <div class="item-details">
                                    <h4><?= $this->escape($item['product_name']) ?></h4>
                                    <p class="item-sku">SKU: <?= $this->escape($item['product_sku']) ?></p>
                                    <p class="item-quantity">Quantity: <?= $item['quantity'] ?></p>
                                </div>
                                <div class="item-price">
                                    $<?= number_format($item['total'], 2) ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="order-totals">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span>$<?= number_format($order['subtotal'], 2) ?></span>
                            </div>
                            <div class="total-row">
                                <span>Tax:</span>
                                <span>$<?= number_format($order['tax_amount'], 2) ?></span>
                            </div>
                            <div class="total-row">
                                <span>Shipping:</span>
                                <span><?= $order['shipping_amount'] > 0 ? '$' . number_format($order['shipping_amount'], 2) : 'Free' ?></span>
                            </div>
                            <div class="total-row total-final">
                                <span>Total:</span>
                                <span>$<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="addresses-card">
                        <h3>Shipping & Billing Information</h3>

                        <?php
                        $billingAddress = json_decode($order['billing_address'], true);
                        $shippingAddress = json_decode($order['shipping_address'], true);
                        ?>

                        <div class="address-section">
                            <h4>
                                <i class="fas fa-truck"></i>
                                Shipping Address
                            </h4>
                            <div class="address">
                                <p><strong><?= $this->escape($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']) ?></strong>
                                </p>
                                <?php if ($shippingAddress['company']): ?>
                                <p><?= $this->escape($shippingAddress['company']) ?></p>
                                <?php endif; ?>
                                <p><?= $this->escape($shippingAddress['address_line_1']) ?></p>
                                <?php if ($shippingAddress['address_line_2']): ?>
                                <p><?= $this->escape($shippingAddress['address_line_2']) ?></p>
                                <?php endif; ?>
                                <p>
                                    <?= $this->escape($shippingAddress['city']) ?>,
                                    <?= $this->escape($shippingAddress['state']) ?>
                                    <?= $this->escape($shippingAddress['postal_code']) ?>
                                </p>
                                <p><?= $this->escape($shippingAddress['country']) ?></p>
                                <?php if ($shippingAddress['phone']): ?>
                                <p>Phone: <?= $this->escape($shippingAddress['phone']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="address-section">
                            <h4>
                                <i class="fas fa-file-invoice"></i>
                                Billing Address
                            </h4>
                            <div class="address">
                                <p><strong><?= $this->escape($billingAddress['first_name'] . ' ' . $billingAddress['last_name']) ?></strong>
                                </p>
                                <?php if ($billingAddress['company']): ?>
                                <p><?= $this->escape($billingAddress['company']) ?></p>
                                <?php endif; ?>
                                <p><?= $this->escape($billingAddress['address_line_1']) ?></p>
                                <?php if ($billingAddress['address_line_2']): ?>
                                <p><?= $this->escape($billingAddress['address_line_2']) ?></p>
                                <?php endif; ?>
                                <p>
                                    <?= $this->escape($billingAddress['city']) ?>,
                                    <?= $this->escape($billingAddress['state']) ?>
                                    <?= $this->escape($billingAddress['postal_code']) ?>
                                </p>
                                <p><?= $this->escape($billingAddress['country']) ?></p>
                                <?php if ($billingAddress['phone']): ?>
                                <p>Phone: <?= $this->escape($billingAddress['phone']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="payment-status-card">
                        <h3>Payment & Status</h3>

                        <div class="status-info">
                            <div class="status-item">
                                <span class="status-label">Order Status:</span>
                                <span class="status-badge status-<?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>

                            <div class="status-item">
                                <span class="status-label">Payment Status:</span>
                                <span class="status-badge payment-<?= $order['payment_status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $order['payment_status'])) ?>
                                </span>
                            </div>

                            <div class="status-item">
                                <span class="status-label">Payment Method:</span>
                                <span class="payment-method">
                                    <?php
                                    $paymentMethods = [
                                        'credit_card' => 'Credit Card',
                                        'paypal' => 'PayPal',
                                        'bank_transfer' => 'Bank Transfer'
                                    ];
                                    echo $paymentMethods[$order['payment_method']] ?? ucfirst(str_replace('_', ' ', $order['payment_method']));
                                    ?>
                                </span>
                            </div>
                        </div>

                        <?php if ($order['notes']): ?>
                        <div class="order-notes">
                            <h4>Order Notes</h4>
                            <p><?= $this->escape($order['notes']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="next-steps">
                <h3>What's Next?</h3>
                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="step-content">
                            <h4>Confirmation Email</h4>
                            <p>You'll receive an order confirmation email shortly with all the details.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="step-content">
                            <h4>Processing</h4>
                            <p>We'll start processing your order and prepare it for shipment.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="step-content">
                            <h4>Shipping</h4>
                            <p>You'll receive tracking information once your order ships.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="success-actions">
                <a href="<?= $this->url('/orders') ?>" class="btn btn-primary">
                    <i class="fas fa-list"></i>
                    View All Orders
                </a>
                <a href="<?= $this->url('/products') ?>" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Continue Shopping
                </a>
                <a href="<?= $this->url('/') ?>" class="btn btn-outline">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.success-page {
    padding: 4rem 0;
    background: var(--bg-secondary);
    min-height: 80vh;
}

.success-content {
    max-width: 1000px;
    margin: 0 auto;
    text-align: center;
}


.success-icon {
    margin-bottom: 2rem;
}

.icon-circle {
    width: 100px;
    height: 100px;
    background: var(--success-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    animation: successPulse 2s ease-in-out;
}

.icon-circle i {
    font-size: 3rem;
    color: white;
}

@keyframes successPulse {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}


.success-message {
    margin-bottom: 3rem;
}

.success-message h1 {
    font-size: 2.5rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.success-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}



.order-details {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 3rem;
    box-shadow: var(--shadow-md);
    text-align: left;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.order-header h2 {
    margin: 0;
    color: var(--text-primary);
}

.order-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.25rem;
}

.order-number {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1.125rem;
}

.order-date {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.order-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}


.order-summary-card {
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    padding: 1.5rem;
}

.order-summary-card h3 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
}

.order-item:last-child {
    border-bottom: none;
}

.item-details h4 {
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.item-sku,
.item-quantity {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.item-price {
    font-weight: 600;
    color: var(--text-primary);
}

.order-totals {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.total-final {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    padding-top: 0.75rem;
    border-top: 1px solid var(--border-color);
}


.addresses-card {
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    padding: 1.5rem;
}

.addresses-card h3 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.address-section {
    margin-bottom: 2rem;
}

.address-section:last-child {
    margin-bottom: 0;
}

.address-section h4 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-size: 1.125rem;
}

.address p {
    margin-bottom: 0.25rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

.payment-status-card {
    grid-column: 1 / -1;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    padding: 1.5rem;
}

.payment-status-card h3 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.status-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.status-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-label {
    font-weight: 500;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    width: fit-content;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-processing {
    background: #dbeafe;
    color: #1e40af;
}

.status-shipped {
    background: #d1fae5;
    color: #065f46;
}

.status-delivered {
    background: #dcfce7;
    color: #166534;
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

.payment-method {
    font-weight: 500;
    color: var(--text-primary);
}

.order-notes {
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.order-notes h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.order-notes p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.next-steps {
    margin-bottom: 3rem;
}

.next-steps h3 {
    margin-bottom: 2rem;
    color: var(--text-primary);
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    text-align: left;
}

.step-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-primary);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

.step-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.step-content h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.step-content p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    line-height: 1.5;
}

.success-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .success-page {
        padding: 2rem 0;
    }

    .success-message h1 {
        font-size: 2rem;
    }

    .order-info-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .order-meta {
        align-items: flex-start;
    }

    .steps-grid {
        grid-template-columns: 1fr;
    }

    .success-actions {
        flex-direction: column;
        align-items: center;
    }

    .success-actions .btn {
        width: 100%;
        max-width: 300px;
    }
}
</style>