<div class="checkout-page">

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
                    <a href="<?= $this->url('/cart') ?>">Cart</a>
                </li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </div>
    </nav>


    <section class="checkout-section">
        <div class="container">
            <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= $success ?>
            </div>
            <?php endif; ?>

            <div class="checkout-header">
                <h1>Checkout</h1>
                <div class="checkout-steps">
                    <div class="step active">
                        <span class="step-number">1</span>
                        <span class="step-title">Billing & Shipping</span>
                    </div>
                    <div class="step">
                        <span class="step-number">2</span>
                        <span class="step-title">Payment</span>
                    </div>
                    <div class="step">
                        <span class="step-number">3</span>
                        <span class="step-title">Review</span>
                    </div>
                </div>
            </div>

            <form class="checkout-form" method="POST" action="<?= $this->url('/checkout/process') ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                <div class="checkout-layout">

                    <div class="checkout-main">

                        <div class="checkout-section-card">
                            <h2>
                                <i class="fas fa-map-marker-alt"></i>
                                Billing Address
                            </h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing_first_name">First Name *</label>
                                    <input type="text" id="billing_first_name" name="billing_first_name"
                                        value="<?= $this->escape($user['first_name'] ?? '') ?>" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="billing_last_name">Last Name *</label>
                                    <input type="text" id="billing_last_name" name="billing_last_name"
                                        value="<?= $this->escape($user['last_name'] ?? '') ?>" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="billing_company">Company (Optional)</label>
                                <input type="text" id="billing_company" name="billing_company" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="billing_address_1">Address Line 1 *</label>
                                <input type="text" id="billing_address_1" name="billing_address_1" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="billing_address_2">Address Line 2 (Optional)</label>
                                <input type="text" id="billing_address_2" name="billing_address_2" class="form-control">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing_city">City *</label>
                                    <input type="text" id="billing_city" name="billing_city" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="billing_state">State *</label>
                                    <input type="text" id="billing_state" name="billing_state" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="billing_postal_code">Postal Code *</label>
                                    <input type="text" id="billing_postal_code" name="billing_postal_code"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing_country">Country *</label>
                                    <select id="billing_country" name="billing_country" class="form-control" required>
                                        <option value="US" selected>United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="billing_phone">Phone Number</label>
                                    <input type="tel" id="billing_phone" name="billing_phone"
                                        value="<?= $this->escape($user['phone'] ?? '') ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="checkout-section-card">
                            <div class="section-header">
                                <h2>
                                    <i class="fas fa-truck"></i>
                                    Shipping Address
                                </h2>
                                <label class="checkbox-label">
                                    <input type="checkbox" id="different_shipping" name="different_shipping" value="1">
                                    <span class="checkmark"></span>
                                    Ship to a different address
                                </label>
                            </div>

                            <div id="shipping_fields" class="shipping-fields" style="display: none;">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="shipping_first_name">First Name *</label>
                                        <input type="text" id="shipping_first_name" name="shipping_first_name"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_last_name">Last Name *</label>
                                        <input type="text" id="shipping_last_name" name="shipping_last_name"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="shipping_company">Company (Optional)</label>
                                    <input type="text" id="shipping_company" name="shipping_company"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_address_1">Address Line 1 *</label>
                                    <input type="text" id="shipping_address_1" name="shipping_address_1"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_address_2">Address Line 2 (Optional)</label>
                                    <input type="text" id="shipping_address_2" name="shipping_address_2"
                                        class="form-control">
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="shipping_city">City *</label>
                                        <input type="text" id="shipping_city" name="shipping_city" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_state">State *</label>
                                        <input type="text" id="shipping_state" name="shipping_state"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_postal_code">Postal Code *</label>
                                        <input type="text" id="shipping_postal_code" name="shipping_postal_code"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="shipping_country">Country *</label>
                                        <select id="shipping_country" name="shipping_country" class="form-control">
                                            <option value="US" selected>United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_phone">Phone Number</label>
                                        <input type="tel" id="shipping_phone" name="shipping_phone"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-section-card">
                            <h2>
                                <i class="fas fa-credit-card"></i>
                                Payment Method
                            </h2>

                            <div class="payment-methods">
                                <label class="payment-method">
                                    <input type="radio" name="payment_method" value="credit_card" checked>
                                    <div class="payment-option">
                                        <div class="payment-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="payment-info">
                                            <h4>Credit Card</h4>
                                            <p>Pay securely with your credit or debit card</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-method">
                                    <input type="radio" name="payment_method" value="paypal">
                                    <div class="payment-option">
                                        <div class="payment-icon">
                                            <i class="fab fa-paypal"></i>
                                        </div>
                                        <div class="payment-info">
                                            <h4>PayPal</h4>
                                            <p>Pay with your PayPal account</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-method">
                                    <input type="radio" name="payment_method" value="bank_transfer">
                                    <div class="payment-option">
                                        <div class="payment-icon">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <div class="payment-info">
                                            <h4>Bank Transfer</h4>
                                            <p>Direct bank transfer</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="checkout-section-card">
                            <h2>
                                <i class="fas fa-sticky-note"></i>
                                Order Notes (Optional)
                            </h2>
                            <div class="form-group">
                                <textarea id="notes" name="notes" class="form-control" rows="4"
                                    placeholder="Special instructions for your order..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-sidebar">
                        <div class="order-summary">
                            <h3>Order Summary</h3>

                            <div class="order-items">
                                <?php foreach ($cart_items as $item): ?>
                                <div class="order-item">
                                    <div class="item-info">
                                        <h4><?= $this->escape($item['product']['name']) ?></h4>
                                        <span class="item-quantity">Qty: <?= $item['quantity'] ?></span>
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
                                    <span>$<?= number_format($subtotal, 2) ?></span>
                                </div>
                                <div class="total-row">
                                    <span>Tax:</span>
                                    <span>$<?= number_format($tax_amount, 2) ?></span>
                                </div>
                                <div class="total-row">
                                    <span>Shipping:</span>
                                    <span><?= $shipping_amount > 0 ? '$' . number_format($shipping_amount, 2) : 'Free' ?></span>
                                </div>
                                <div class="total-row total-final">
                                    <span>Total:</span>
                                    <span>$<?= number_format($total, 2) ?></span>
                                </div>
                            </div>

                            <div class="checkout-actions">
                                <button type="submit" class="btn btn-primary btn-lg checkout-btn">
                                    <i class="fas fa-lock"></i>
                                    Place Order
                                </button>
                                <a href="<?= $this->url('/cart') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Cart
                                </a>
                            </div>

                            <div class="security-badges">
                                <div class="security-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>SSL Secured</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-lock"></i>
                                    <span>256-bit Encryption</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<style>
.checkout-page {
    padding-top: 0;
}

.checkout-section {
    padding: 2rem 0 4rem;
}

.checkout-header {
    text-align: center;
    margin-bottom: 3rem;
}

.checkout-header h1 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: var(--text-primary);
}

.checkout-steps {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-light);
}

.step.active {
    color: var(--primary-color);
}

.step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.step.active .step-number {
    background: var(--primary-color);
    color: white;
}

.checkout-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.checkout-section-card {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
}

.checkout-section-card h2 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    font-size: 1.5rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.shipping-fields {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.payment-methods {
    display: grid;
    gap: 1rem;
}

.payment-method {
    cursor: pointer;
}

.payment-method input[type="radio"] {
    display: none;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.payment-method input[type="radio"]:checked+.payment-option {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
}

.payment-icon {
    width: 50px;
    height: 50px;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-color);
}

.payment-info h4 {
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.payment-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.order-summary {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 2rem;
}

.order-summary h3 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.order-items {
    margin-bottom: 1.5rem;
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

.item-info h4 {
    margin-bottom: 0.25rem;
    font-size: 1rem;
    color: var(--text-primary);
}

.item-quantity {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.item-price {
    font-weight: 600;
    color: var(--text-primary);
}

.order-totals {
    padding: 1.5rem 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.total-row:last-child {
    margin-bottom: 0;
}

.total-final {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    padding-top: 0.75rem;
    border-top: 1px solid var(--border-color);
}

.checkout-actions {
    display: grid;
    gap: 1rem;
    margin-bottom: 2rem;
}

.checkout-btn {
    width: 100%;
    justify-content: center;
    font-size: 1.125rem;
    padding: 1rem;
}

.security-badges {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light);
}

.security-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.security-item i {
    color: var(--success-color);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.checkbox-label input[type="checkbox"] {
    margin: 0;
}

@media (max-width: 1024px) {
    .checkout-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .order-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .checkout-steps {
        flex-direction: column;
        gap: 1rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .checkout-section-card {
        padding: 1.5rem;
    }

    .order-summary {
        padding: 1.5rem;
    }
}
</style>

<script>
document.getElementById('different_shipping').addEventListener('change', function() {
    const shippingFields = document.getElementById('shipping_fields');
    const shippingInputs = shippingFields.querySelectorAll('input, select');

    if (this.checked) {
        shippingFields.style.display = 'block';
        shippingInputs.forEach(input => {
            if (input.hasAttribute('required')) {
                input.setAttribute('data-was-required', 'true');
            }
        });
    } else {
        shippingFields.style.display = 'none';
        shippingInputs.forEach(input => {
            input.removeAttribute('required');
        });
    }
});


document.querySelector('.checkout-form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});
</script>