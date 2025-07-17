<!-- Hero Section -->
<section class="hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-text animate-fade-in-up">
                <h1 class="hero-title">Welcome to <?= APP_NAME ?></h1>
                <p class="hero-subtitle">Discover amazing products with our modern shopping experience</p>
                <div class="hero-actions">
                    <a href="<?= $this->url('/products') ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag"></i>
                        Shop Now
                    </a>
                    <a href="<?= $this->url('/about') ?>" class="btn btn-outline btn-lg">
                        <i class="fas fa-info-circle"></i>
                        Learn More
                    </a>
                </div>
            </div>
            <div class="hero-image animate-fade-in-right">
                <img src="<?= $this->asset('images/hero-image.jpg') ?>" alt="Hero Image" class="animate-float">
            </div>
        </div>
    </div>
</section>
<!-- Featured Products Section -->
<?php if (!empty($featured_products)): ?>
<section class="featured-products section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Discover our handpicked selection of amazing products</p>
        </div>
        <div class="grid grid-4 stagger-animation">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card hover-lift">
                    <div class="product-image">
                        <img src="<?= $this->asset('images/products/' . ($product['primary_image'] ?: 'placeholder.jpg')) ?>" 
                             alt="<?= $this->escape($product['name']) ?>" 
                             loading="lazy">
                        <?php if ($product['sale_price']): ?>
                            <div class="product-badge sale">Sale</div>
                        <?php endif; ?>
                        <div class="product-actions">
                            <button class="product-action wishlist-btn" data-product-id="<?= $product['id'] ?>" title="Add to Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="product-action add-to-cart" data-product-id="<?= $product['id'] ?>" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <a href="<?= $this->url('/product/' . $product['slug']) ?>" class="product-action" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?= $this->escape($product['category_name'] ?? 'Uncategorized') ?></div>
                        <h3 class="product-title">
                            <a href="<?= $this->url('/product/' . $product['slug']) ?>">
                                <?= $this->escape($product['name']) ?>
                            </a>
                        </h3>
                        <?php if ($product['avg_rating']): ?>
                            <div class="product-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star star <?= $i <= round($product['avg_rating']) ? '' : 'empty' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-count">(<?= $product['review_count'] ?>)</span>
                            </div>
                        <?php endif; ?>
                        <div class="product-price">
                            <?php if ($product['sale_price']): ?>
                                <span class="price-current"><?= $this->currency($product['sale_price']) ?></span>
                                <span class="price-original"><?= $this->currency($product['price']) ?></span>
                                <span class="price-discount">
                                    <?= round((($product['price'] - $product['sale_price']) / $product['price']) * 100) ?>% OFF
                                </span>
                            <?php else: ?>
                                <span class="price-current"><?= $this->currency($product['price']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center" style="margin-top: 3rem;">
            <a href="<?= $this->url('/products') ?>" class="btn btn-outline btn-lg">
                <i class="fas fa-arrow-right"></i>
                View All Products
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Categories Section -->
<?php if (!empty($categories)): ?>
<section class="categories section-padding bg-secondary">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Shop by Category</h2>
            <p class="section-subtitle">Find exactly what you're looking for</p>
        </div>
        <div class="grid grid-3 stagger-animation">
            <?php foreach (array_slice($categories, 0, 6) as $category): ?>
                <div class="category-card hover-lift">
                    <a href="<?= $this->url('/category/' . $category['slug']) ?>" class="category-link">
                        <div class="category-image">
                            <img src="<?= $this->asset('images/categories/' . ($category['image'] ?: 'placeholder.jpg')) ?>" 
                                 alt="<?= $this->escape($category['name']) ?>" 
                                 loading="lazy">
                            <div class="category-overlay">
                                <div class="category-info">
                                    <h3 class="category-name"><?= $this->escape($category['name']) ?></h3>
                                    <p class="category-count"><?= $category['product_count'] ?> Products</p>
                                    <span class="category-btn">Shop Now</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Latest Products Section -->
<?php if (!empty($latest_products)): ?>
<section class="latest-products section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Latest Arrivals</h2>
            <p class="section-subtitle">Check out our newest additions</p>
        </div>
        <div class="grid grid-4 stagger-animation">
            <?php foreach ($latest_products as $product): ?>
                <div class="product-card hover-lift">
                    <div class="product-image">
                        <img src="<?= $this->asset('images/products/' . ($product['primary_image'] ?: 'placeholder.jpg')) ?>" 
                             alt="<?= $this->escape($product['name']) ?>" 
                             loading="lazy">
                        <div class="product-badge new">New</div>
                        <div class="product-actions">
                            <button class="product-action wishlist-btn" data-product-id="<?= $product['id'] ?>" title="Add to Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="product-action add-to-cart" data-product-id="<?= $product['id'] ?>" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <a href="<?= $this->url('/product/' . $product['slug']) ?>" class="product-action" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?= $this->escape($product['category_name'] ?? 'Uncategorized') ?></div>
                        <h3 class="product-title">
                            <a href="<?= $this->url('/product/' . $product['slug']) ?>">
                                <?= $this->escape($product['name']) ?>
                            </a>
                        </h3>
                        <div class="product-price">
                            <span class="price-current"><?= $this->currency($product['price']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Newsletter Section -->
<section class="newsletter section-padding bg-primary">
    <div class="container">
        <div class="newsletter-content text-center">
            <h2 class="newsletter-title">Stay Updated</h2>
            <p class="newsletter-subtitle">Subscribe to our newsletter and get the latest updates on new products and exclusive offers.</p>
            <form class="newsletter-form-inline" action="<?= $this->url('/newsletter/subscribe') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="newsletter-input-group">
                    <input type="email" name="email" placeholder="Enter your email address" class="newsletter-input-large" required>
                    <button type="submit" class="btn btn-secondary btn-lg">
                        <i class="fas fa-paper-plane"></i>
                        Subscribe
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<style>
.hero {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
}
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?= $this->asset('images/hero-bg.jpg') ?>') center/cover;
}
.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(99, 102, 241, 0.8);
}
.hero-content {
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    z-index: 1;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
    line-height: 1.1;
}
.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}
.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.hero-image img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
}
.section-padding {
    padding: 5rem 0;
}
.bg-secondary {
    background: var(--bg-secondary);
}
.bg-primary {
    background: var(--primary-color);
    color: white;
}
.section-header {
    margin-bottom: 3rem;
}
.section-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}
.section-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}
.bg-primary .section-subtitle {
    color: rgba(255, 255, 255, 0.8);
}
.category-card {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    height: 300px;
}
.category-image {
    position: relative;
    width: 100%;
    height: 100%;
}
.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}
.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
    display: flex;
    align-items: flex-end;
    padding: 2rem;
    transition: background var(--transition-normal);
}
.category-card:hover .category-overlay {
    background: linear-gradient(to bottom, rgba(99, 102, 241, 0.3), rgba(99, 102, 241, 0.8));
}
.category-card:hover .category-image img {
    transform: scale(1.05);
}
.category-info {
    color: white;
}
.category-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.category-count {
    margin-bottom: 1rem;
    opacity: 0.9;
}
.category-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: white;
    color: var(--primary-color);
    border-radius: var(--radius-md);
    font-weight: 500;
    transition: all var(--transition-fast);
}
.category-card:hover .category-btn {
    background: var(--primary-color);
    color: white;
}
.newsletter-content {
    max-width: 600px;
    margin: 0 auto;
}
.newsletter-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: white;
}
.newsletter-subtitle {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    color: rgba(255, 255, 255, 0.9);
}
.newsletter-form-inline {
    max-width: 500px;
    margin: 0 auto;
}
.newsletter-input-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.newsletter-input-large {
    flex: 1;
    min-width: 250px;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: var(--radius-lg);
    font-size: 1rem;
}
@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    .hero-title {
        font-size: 2.5rem;
    }
    .newsletter-input-group {
        flex-direction: column;
    }
    .newsletter-input-large {
        min-width: 100%;
    }
}
</style>