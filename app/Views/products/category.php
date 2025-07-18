<div class="category-page">
    <!-- Breadcrumb -->
    <?php if (!empty($breadcrumb)): ?>
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
                        <a href="<?= $this->url('/products') ?>">Products</a>
                    </li>
                    <?php foreach ($breadcrumb as $crumb): ?>
                        <li class="breadcrumb-item">
                            <a href="<?= $this->url('/category/' . $crumb['slug']) ?>">
                                <?= $this->escape($crumb['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </nav>
    <?php endif; ?>

    <!-- Category Header -->
    <section class="category-header">
        <div class="container">
            <div class="category-info">
                <div class="category-details">
                    <h1 class="category-title"><?= $this->escape($category['name']) ?></h1>
                    <?php if ($category['description']): ?>
                        <p class="category-description"><?= $this->escape($category['description']) ?></p>
                    <?php endif; ?>
                    <div class="category-stats">
                        <span class="product-count">
                            <i class="fas fa-box"></i>
                            <?= $total_products ?> <?= $total_products === 1 ? 'Product' : 'Products' ?>
                        </span>
                    </div>
                </div>
                <?php if ($category['image']): ?>
                    <div class="category-image">
                        <img src="<?= $this->asset('images/categories/' . $category['image']) ?>"
                            alt="<?= $this->escape($category['name']) ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Filters and Products -->
    <section class="products-section">
        <div class="container">
            <div class="products-layout">
                <!-- Sidebar Filters -->
                <aside class="filters-sidebar">
                    <div class="filters-header">
                        <h3>Filter Products</h3>
                        <button class="filters-toggle" onclick="toggleFilters()">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>

                    <form class="filters-form" method="GET">
                        <!-- Search -->
                        <div class="filter-group">
                            <label for="search">Search in <?= $this->escape($category['name']) ?></label>
                            <input type="text" id="search" name="search"
                                value="<?= $this->escape($filters['search'] ?? '') ?>"
                                placeholder="Search products..." class="form-control">
                        </div>

                        <!-- Price Range -->
                        <div class="filter-group">
                            <label>Price Range</label>
                            <div class="price-inputs">
                                <input type="number" name="min_price"
                                    value="<?= $this->escape($filters['min_price'] ?? '') ?>"
                                    placeholder="Min" class="form-control" min="0" step="0.01">
                                <span class="price-separator">to</span>
                                <input type="number" name="max_price"
                                    value="<?= $this->escape($filters['max_price'] ?? '') ?>"
                                    placeholder="Max" class="form-control" min="0" step="0.01">
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="filter-group">
                            <label for="sort">Sort By</label>
                            <select id="sort" name="sort" class="form-control">
                                <option value="created_at" <?= ($filters['sort'] ?? 'created_at') === 'created_at' ? 'selected' : '' ?>>
                                    Newest First
                                </option>
                                <option value="name" <?= ($filters['sort'] ?? '') === 'name' ? 'selected' : '' ?>>
                                    Name A-Z
                                </option>
                                <option value="price" <?= ($filters['sort'] ?? '') === 'price' ? 'selected' : '' ?>>
                                    Price Low to High
                                </option>
                                <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>
                                    Price High to Low
                                </option>
                            </select>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Apply Filters
                            </button>
                            <a href="<?= $this->url('/category/' . $category['slug']) ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Clear All
                            </a>
                        </div>
                    </form>

                    <!-- Categories Sidebar -->
                    <?php if (!empty($categories)): ?>
                        <div class="categories-sidebar">
                            <h4>Browse Categories</h4>
                            <ul class="category-list">
                                <?php foreach ($categories as $cat): ?>
                                    <li class="category-item <?= $cat['id'] == $category['id'] ? 'active' : '' ?>">
                                        <a href="<?= $this->url('/category/' . $cat['slug']) ?>" class="category-link">
                                            <?= $this->escape($cat['name']) ?>
                                            <span class="product-count">(<?= $cat['product_count'] ?>)</span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </aside>

                <!-- Products Grid -->
                <main class="products-main">
                    <!-- Results Header -->
                    <div class="results-header">
                        <div class="results-info">
                            <h2>
                                <?php if (!empty($filters['search'])): ?>
                                    Search results for "<?= $this->escape($filters['search']) ?>" in <?= $this->escape($category['name']) ?>
                                <?php else: ?>
                                    <?= $this->escape($category['name']) ?> Products
                                <?php endif; ?>
                            </h2>
                            <p class="results-count">
                                Showing <?= count($products) ?> of <?= $total_products ?> products
                                <?php if ($total_pages > 1): ?>
                                    (Page <?= $current_page ?> of <?= $total_pages ?>)
                                <?php endif; ?>
                            </p>
                        </div>

                        <div class="view-options">
                            <button class="view-btn active" data-view="grid" title="Grid View">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <?php if (!empty($products)): ?>
                        <div class="products-grid" id="products-grid">
                            <?php foreach ($products as $product): ?>
                                <div class="product-card">
                                    <div class="product-image">
                                        <a href="<?= $this->url('/product/' . $product['id']) ?>">
                                            <?php if ($product['image']): ?>
                                                <img src="<?= $this->asset('images/products/' . $product['image']) ?>"
                                                    alt="<?= $this->escape($product['name']) ?>" loading="lazy">
                                            <?php else: ?>
                                                <div class="product-placeholder">
                                                    <i class="fas fa-image"></i>
                                                    <span>No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </a>

                                        <?php if ($product['stock'] <= 5 && $product['stock'] > 0): ?>
                                            <span class="stock-badge low-stock">Only <?= $product['stock'] ?> left</span>
                                        <?php elseif ($product['stock'] == 0): ?>
                                            <span class="stock-badge out-of-stock">Out of Stock</span>
                                        <?php endif; ?>

                                        <div class="product-actions">
                                            <button class="action-btn wishlist-btn" title="Add to Wishlist">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="action-btn quick-view-btn" title="Quick View"
                                                onclick="quickView(<?= $product['id'] ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name">
                                            <a href="<?= $this->url('/product/' . $product['id']) ?>">
                                                <?= $this->escape($product['name']) ?>
                                            </a>
                                        </h3>

                                        <?php if ($product['description']): ?>
                                            <p class="product-description">
                                                <?= $this->escape(substr($product['description'], 0, 100)) ?>
                                                <?= strlen($product['description']) > 100 ? '...' : '' ?>
                                            </p>
                                        <?php endif; ?>

                                        <div class="product-price">
                                            <span class="current-price">$<?= number_format($product['price'], 2) ?></span>
                                        </div>

                                        <div class="product-footer">
                                            <?php if ($product['stock'] > 0): ?>
                                                <button class="btn btn-primary add-to-cart-btn"
                                                    onclick="addToCart(<?= $product['id'] ?>)">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    Add to Cart
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-secondary" disabled>
                                                    <i class="fas fa-times"></i>
                                                    Out of Stock
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav class="pagination-nav">
                                <div class="pagination">
                                    <?php if ($current_page > 1): ?>
                                        <a href="<?= $this->url('/category/' . $category['slug'] . '?page=' . ($current_page - 1) . '&' . http_build_query($filters)) ?>"
                                            class="pagination-btn prev">
                                            <i class="fas fa-chevron-left"></i>
                                            Previous
                                        </a>
                                    <?php endif; ?>

                                    <div class="pagination-numbers">
                                        <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                                            <?php if ($i == $current_page): ?>
                                                <span class="pagination-btn current"><?= $i ?></span>
                                            <?php else: ?>
                                                <a href="<?= $this->url('/category/' . $category['slug'] . '?page=' . $i . '&' . http_build_query($filters)) ?>"
                                                    class="pagination-btn"><?= $i ?></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>

                                    <?php if ($current_page < $total_pages): ?>
                                        <a href="<?= $this->url('/category/' . $category['slug'] . '?page=' . ($current_page + 1) . '&' . http_build_query($filters)) ?>"
                                            class="pagination-btn next">
                                            Next
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </nav>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>No products found</h3>
                            <?php if (!empty($filters['search'])): ?>
                                <p>No products match your search criteria in this category.</p>
                                <a href="<?= $this->url('/category/' . $category['slug']) ?>" class="btn btn-primary">
                                    <i class="fas fa-times"></i>
                                    Clear Search
                                </a>
                            <?php else: ?>
                                <p>This category doesn't have any products yet.</p>
                                <a href="<?= $this->url('/products') ?>" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i>
                                    Browse All Products
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </section>
</div>

<style>
    /* Category Page Styles */
    .category-page {
        padding-top: 0;
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        background: var(--bg-secondary);
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .breadcrumb {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
        gap: 0.5rem;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
    }

    .breadcrumb-item:not(:last-child)::after {
        content: '/';
        margin-left: 0.5rem;
        color: var(--text-light);
    }

    .breadcrumb-item a {
        color: var(--text-secondary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color var(--transition-fast);
    }

    .breadcrumb-item a:hover {
        color: var(--primary-color);
    }

    .breadcrumb-item:last-child a {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Category Header */
    .category-header {
        padding: 3rem 0;
        background: var(--bg-primary);
    }

    .category-info {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
    }

    .category-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .category-description {
        font-size: 1.125rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .category-stats {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .product-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .category-image {
        width: 200px;
        height: 200px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Products Layout */
    .products-section {
        padding: 2rem 0 4rem;
    }

    .products-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }

    /* Filters Sidebar */
    .filters-sidebar {
        background: var(--bg-primary);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        height: fit-content;
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 2rem;
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .filters-header h3 {
        margin: 0;
        color: var(--text-primary);
    }

    .filters-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--primary-color);
        font-size: 1.25rem;
        cursor: pointer;
    }

    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
    }

    .price-inputs {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 0.5rem;
        align-items: center;
    }

    .price-separator {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .filter-actions {
        display: grid;
        gap: 0.5rem;
    }

    .categories-sidebar {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .categories-sidebar h4 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .category-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .category-item {
        margin-bottom: 0.5rem;
    }

    .category-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        text-decoration: none;
        transition: all var(--transition-fast);
    }

    .category-link:hover,
    .category-item.active .category-link {
        background: var(--primary-color);
        color: white;
    }

    /* Results Header */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .results-info h2 {
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .results-count {
        color: var(--text-secondary);
        margin: 0;
    }

    .view-options {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        width: 40px;
        height: 40px;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .view-btn:hover,
    .view-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .product-card {
        background: var(--bg-primary);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all var(--transition-normal);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .product-image {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-normal);
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-placeholder {
        width: 100%;
        height: 100%;
        background: var(--bg-secondary);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }

    .product-placeholder i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }

    .stock-badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stock-badge.low-stock {
        background: var(--warning-color);
        color: white;
    }

    .stock-badge.out-of-stock {
        background: var(--error-color);
        color: white;
    }

    .product-actions {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity var(--transition-fast);
    }

    .product-card:hover .product-actions {
        opacity: 1;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        color: var(--text-primary);
        cursor: pointer;
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        margin-bottom: 0.5rem;
    }

    .product-name a {
        color: var(--text-primary);
        text-decoration: none;
        font-size: 1.125rem;
        font-weight: 600;
        transition: color var(--transition-fast);
    }

    .product-name a:hover {
        color: var(--primary-color);
    }

    .product-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .product-price {
        margin-bottom: 1rem;
    }

    .current-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .product-footer {
        margin-top: auto;
    }

    .add-to-cart-btn {
        width: 100%;
        justify-content: center;
    }

    /* Pagination */
    .pagination-nav {
        margin-top: 3rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-btn {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-primary);
        text-decoration: none;
        border-radius: var(--radius-md);
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination-btn.current {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination-numbers {
        display: flex;
        gap: 0.25rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1.125rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .products-layout {
            grid-template-columns: 250px 1fr;
        }
    }

    @media (max-width: 768px) {
        .category-info {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .category-image {
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .products-layout {
            grid-template-columns: 1fr;
        }

        .filters-sidebar {
            position: static;
            margin-bottom: 2rem;
        }

        .filters-toggle {
            display: block;
        }

        .results-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .pagination {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .price-inputs {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .price-separator {
            display: none;
        }
    }
</style>

<script>
    function toggleFilters() {
        const sidebar = document.querySelector('.filters-sidebar');
        sidebar.classList.toggle('active');
    }

    function quickView(productId) {
        // Implement quick view functionality
        console.log('Quick view for product:', productId);
    }

    // addToCart function is now handled globally in main.js

    // View toggle functionality
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const view = this.dataset.view;
            const grid = document.getElementById('products-grid');

            if (view === 'list') {
                grid.classList.add('list-view');
            } else {
                grid.classList.remove('list-view');
            }
        });
    });
</script>