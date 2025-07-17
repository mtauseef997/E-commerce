<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $this->escape($title) . ' - Admin - ' . APP_NAME : 'Admin - ' . APP_NAME ?></title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $this->asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('css/admin.css') ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https:
    <link rel="preconnect" href="https:
    <link href="https:
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https:
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?= $csrf_token ?>">
</head>
<body class="admin-layout">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-cog"></i>
                <span>Admin Panel</span>
            </div>
            <button class="sidebar-toggle" id="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= $this->url('/admin') ?>" class="nav-link <?= $this->isActive('/admin') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->url('/admin/products') ?>" class="nav-link <?= $this->isActive('/admin/products') ? 'active' : '' ?>">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->url('/admin/categories') ?>" class="nav-link <?= $this->isActive('/admin/categories') ? 'active' : '' ?>">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->url('/admin/orders') ?>" class="nav-link <?= $this->isActive('/admin/orders') ? 'active' : '' ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->url('/admin/users') ?>" class="nav-link <?= $this->isActive('/admin/users') ? 'active' : '' ?>">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-divider"></li>
                <li class="nav-item">
                    <a href="<?= $this->url('/') ?>" class="nav-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Store</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->url('/logout') ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Admin Main Content -->
    <main class="admin-main">
        <!-- Admin Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="mobile-sidebar-toggle" id="mobile-sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?= isset($title) ? $this->escape($title) : 'Admin Panel' ?></h1>
            </div>
            <div class="header-right">
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name"><?= $this->escape($current_user['first_name'] . ' ' . $current_user['last_name']) ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </div>
        </header>
        <!-- Admin Content -->
        <div class="admin-content">
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
        </div>
    </main>
    <!-- JavaScript -->
    <script src="<?= $this->asset('js/main.js') ?>"></script>
    <script src="<?= $this->asset('js/admin.js') ?>"></script>
    <?php if (isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>
</body>
</html>