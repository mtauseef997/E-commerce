<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <span class="breadcrumb-item"><a href="<?= $this->url('/') ?>">Home</a></span>
        <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
        <span class="breadcrumb-item">Shopping Cart</span>
    </nav>
</div>
<!-- Cart Content -->
<section class="cart-section">
    <div class="container">
        <?php if (!empty($cart_items)): ?>
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items">
                <div class="cart-header">
                    <h1>Shopping Cart</h1>
                    <span class="cart-count"><?= $cart_count ?> items</span>
                </div>
                <div class="cart-list">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item" data-product-id="<?= $item['product']['id'] ?>">
                        <div class="item-image">
                            <img src="<?= $this->asset('images/products/' . ($item['image'] ?: 'placeholder.jpg')) ?>" 
                                 alt="<?= $this->escape($item['product']['name']) ?>">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">
                                <a href="<?= $this->url('/product/' . $item['product']['slug']) ?>">
                                    <?= $this->escape($item['product']['name']) ?>
                                </a>
                            </h3>
                            <p class="item-sku">SKU: <?= $this->escape($item['product']['sku']) ?></p>
                            <?php if ($item['product']['sale_price']): ?>
                                <div class="item-price">
                                    <span class="price-current"><?= $this->currency($item['price']) ?></span>
                                    <span class="price-original"><?= $this->currency($item['product']['price']) ?></span>
                                </div>
                            <?php else: ?>
                                <div class="item-price">
                                    <span class="price-current"><?= $this->currency($item['price']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="item-quantity">
                            <div class="quantity-controls">
                                <button class="qty-btn" data-action="decrease" data-product-id="<?= $item['product']['id'] ?>">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       class="qty-input" 
                                       value="<?= $item['quantity'] ?>" 
                                       min="1" 
                                       max="<?= $item['product']['stock_quantity'] ?>"
                                       data-product-id="<?= $item['product']['id'] ?>">
                                <button class="qty-btn" data-action="increase" data-product-id="<?= $item['product']['id'] ?>">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="stock-info">
                                <?= $item['product']['stock_quantity'] ?> in stock
                            </div>
                        </div>
                        <div class="item-total">
                            <span class="total-price" data-item-total="<?= $item['product']['id'] ?>">
                                <?= $this->currency($item['total']) ?>
                            </span>
                        </div>
                        <div class="item-actions">
                            <button class="remove-item" 
                                    data-product-id="<?= $item['product']['id'] ?>" 
                                    title="Remove item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Cart Actions -->
                <div class="cart-actions">
                    <a href="<?= $this->url('/products') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Continue Shopping
                    </a>
                    <button class="btn btn-ghost" onclick="clearCart()">
                        <i class="fas fa-trash"></i>
                        Clear Cart
                    </button>
                </div>
            </div>
            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-card">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal (<?= $cart_count ?> items)</span>
                            <span class="cart-total"><?= $this->currency($cart_total) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span><?= $cart_total > 100 ? 'FREE' : $this->currency(10) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax</span>
                            <span><?= $this->currency($cart_total * 0.08) ?></span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span><?= $this->currency($cart_total + ($cart_total > 100 ? 0 : 10) + ($cart_total * 0.08)) ?></span>
                        </div>
                    </div>
                    <div class="summary-actions">
                        <?php if ($current_user): ?>
                            <a href="<?= $this->url('/checkout') ?>" class="btn btn-primary btn-full btn-lg">
                                <i class="fas fa-credit-card"></i>
                                Proceed to Checkout
                            </a>
                        <?php else: ?>
                            <a href="<?= $this->url('/login') ?>" class="btn btn-primary btn-full btn-lg">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to Checkout
                            </a>
                        <?php endif; ?>
                        <div class="payment-methods">
                            <span>We accept:</span>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fab fa-cc-apple-pay"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Promo Code -->
                <div class="promo-card">
                    <h4>Have a promo code?</h4>
                    <form class="promo-form">
                        <div class="promo-input-group">
                            <input type="text" class="form-input" placeholder="Enter promo code">
                            <button type="submit" class="btn btn-outline">Apply</button>
                        </div>
                    </form>
                </div>
                <!-- Security Info -->
                <div class="security-info">
                    <div class="security-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure checkout</span>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-truck"></i>
                        <span>Free shipping over $100</span>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-undo"></i>
                        <span>30-day returns</span>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Empty Cart -->
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <a href="<?= $this->url('/products') ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag"></i>
                Start Shopping
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<style>
.cart-section {
    padding: 2rem 0;
    min-height: 60vh;
}
.cart-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}
.cart-items {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}
.cart-header h1 {
    font-size: 1.75rem;
    margin: 0;
}
.cart-count {
    color: var(--text-secondary);
    font-size: 0.875rem;
}
.cart-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.cart-item {
    display: grid;
    grid-template-columns: 80px 1fr auto auto auto;
    gap: 1rem;
    align-items: center;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    transition: all var(--transition-fast);
}
.cart-item:hover {
    box-shadow: var(--shadow-md);
}
.item-image img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius-md);
}
.item-details {
    min-width: 0;
}
.item-name {
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
}
.item-name a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast);
}
.item-name a:hover {
    color: var(--primary-color);
}
.item-sku {
    color: var(--text-light);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}
.item-price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.price-current {
    font-weight: 600;
    color: var(--primary-color);
}
.price-original {
    text-decoration: line-through;
    color: var(--text-light);
    font-size: 0.875rem;
}
.quantity-controls {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
}
.qty-btn {
    width: 2rem;
    height: 2rem;
    border: none;
    background: var(--bg-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background var(--transition-fast);
}
.qty-btn:hover {
    background: var(--primary-color);
    color: white;
}
.qty-input {
    width: 3rem;
    height: 2rem;
    border: none;
    text-align: center;
    font-weight: 500;
}
.stock-info {
    font-size: 0.75rem;
    color: var(--success-color);
    margin-top: 0.25rem;
    text-align: center;
}
.item-total {
    text-align: right;
}
.total-price {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}
.item-actions {
    display: flex;
    justify-content: center;
}
.remove-item {
    width: 2rem;
    height: 2rem;
    border: none;
    background: var(--error-color);
    color: white;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition-fast);
}
.remove-item:hover {
    background: #dc2626;
    transform: scale(1.1);
}
.cart-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}
.cart-summary {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.summary-card,
.promo-card {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
}
.summary-title {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border-color);
}
.summary-details {
    margin-bottom: 1.5rem;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}
.summary-row.total {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}
.summary-divider {
    height: 1px;
    background: var(--border-color);
    margin: 1rem 0;
}
.payment-methods {
    text-align: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}
.payment-methods span {
    display: block;
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}
.payment-icons {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    color: var(--text-light);
}
.promo-input-group {
    display: flex;
    gap: 0.5rem;
}
.promo-input-group input {
    flex: 1;
}
.security-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
}
.security-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
}
.security-item i {
    color: var(--success-color);
    width: 1rem;
}
.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}
.empty-cart-icon {
    font-size: 4rem;
    color: var(--text-light);
    margin-bottom: 1.5rem;
}
.empty-cart h2 {
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}
.empty-cart p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}
@media (max-width: 768px) {
    .cart-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .cart-item {
        grid-template-columns: 60px 1fr;
        gap: 1rem;
    }
    .item-quantity,
    .item-total,
    .item-actions {
        grid-column: 1 / -1;
        justify-self: stretch;
    }
    .item-quantity {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-actions {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
<script>
function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        window.location.href = '<?= $this->url('/cart/clear') ?>';
    }
}
</script>