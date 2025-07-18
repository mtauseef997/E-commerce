<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $this->escape($title) . ' - ' . APP_NAME : APP_NAME ?></title>
    <!-- Meta Tags -->
    <meta name="description" content="<?= isset($meta_description) ? $this->escape($meta_description) : 'Modern e-commerce platform with unique design' ?>">
    <meta name="keywords" content="ecommerce, shopping, online store, products">
    <meta name="author" content="<?= APP_NAME ?>">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->asset('images/favicon.ico') ?>">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $this->asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('css/animations.css') ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?= $csrf_token ?>">
</head>

<body class="<?= isset($body_class) ? $body_class : '' ?>">
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </div>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="<?= $this->url('/') ?>" class="logo-link">
                        <i class="fas fa-shopping-bag"></i>
                        <span><?= APP_NAME ?></span>
                    </a>
                </div>
                <!-- Search Bar -->
                <div class="search-container">
                    <form action="<?= $this->url('/search') ?>" method="GET" class="search-form">
                        <input type="text" name="q" placeholder="Search products..." class="search-input" value="<?= isset($_GET['q']) ? $this->escape($_GET['q']) : '' ?>">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <!-- Header Actions -->
                <div class="header-actions">
                    <?php if ($current_user): ?>
                        <!-- User Menu -->
                        <div class="user-menu dropdown">
                            <button class="dropdown-toggle" data-dropdown="user-dropdown">
                                <i class="fas fa-user"></i>
                                <span><?= $this->escape($current_user['first_name']) ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="user-dropdown">
                                <a href="<?= $this->url('/profile') ?>" class="dropdown-item">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                <a href="<?= $this->url('/orders') ?>" class="dropdown-item">
                                    <i class="fas fa-box"></i> Orders
                                </a>
                                <a href="<?= $this->url('/wishlist') ?>" class="dropdown-item">
                                    <i class="fas fa-heart"></i> Wishlist
                                </a>
                                <?php if ($current_user['role'] === 'admin'): ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?= $this->url('/admin') ?>" class="dropdown-item">
                                        <i class="fas fa-cog"></i> Admin Panel
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="<?= $this->url('/logout') ?>" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Auth Links -->
                        <a href="<?= $this->url('/login') ?>" class="auth-link">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                        <a href="<?= $this->url('/register') ?>" class="auth-link register">
                            <i class="fas fa-user-plus"></i>
                            <span>Register</span>
                        </a>
                    <?php endif; ?>
                    <!-- Cart -->
                    <a href="<?= $this->url('/cart') ?>" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cart-count"><?= $cart_count ?></span>
                    </a>
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
            <!-- Navigation -->
            <nav class="main-nav" id="main-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="<?= $this->url('/') ?>" class="nav-link <?= $this->isActive('/') ? 'active' : '' ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $this->url('/products') ?>" class="nav-link <?= $this->isActive('/products') ? 'active' : '' ?>">Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-dropdown="categories-dropdown">
                            Categories <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu mega-menu" id="categories-dropdown">
                            <!-- Categories will be loaded here -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $this->url('/about') ?>" class="nav-link <?= $this->isActive('/about') ? 'active' : '' ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $this->url('/contact') ?>" class="nav-link <?= $this->isActive('/contact') ? 'active' : '' ?>">Contact</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        <?php if ($success = $this->flash('success')): ?>
            <div class="alert alert-success" id="flash-message">
                <i class="fas fa-check-circle"></i>
                <?= $success ?>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($error = $this->flash('error')): ?>
            <div class="alert alert-error" id="flash-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= $error ?>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>
        <!-- Page Content -->
        <?= $content ?>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About <?= APP_NAME ?></h3>
                    <p>Your trusted online shopping destination with a modern and unique shopping experience.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="<?= $this->url('/') ?>">Home</a></li>
                        <li><a href="<?= $this->url('/products') ?>">Products</a></li>
                        <li><a href="<?= $this->url('/about') ?>">About Us</a></li>
                        <li><a href="<?= $this->url('/contact') ?>">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Customer Service</h3>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Subscribe to get updates on new products and offers.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email" class="newsletter-input">
                        <button type="submit" class="newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Back to Top -->
    <button class="back-to-top" id="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <!-- JavaScript -->
    <script src="<?= $this->asset('js/main.js') ?>"></script>
    <script src="<?= $this->asset('js/components.js') ?>"></script>
    <script src="<?= $this->asset('js/animations.js') ?>"></script>
    <?php if (isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>
</body>

</html>