<div class="error-container">
    <div class="container">
        <div class="error-content">
            <div class="error-illustration">
                <div class="error-number">404</div>
                <div class="error-icon">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            <div class="error-text">
                <h1 class="error-title">Page Not Found</h1>
                <p class="error-message">
                    Sorry, the page you are looking for doesn't exist or has been moved.
                </p>
                <div class="error-actions">
                    <a href="<?= $this->url('/') ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i>
                        Go Home
                    </a>
                    <a href="<?= $this->url('/products') ?>" class="btn btn-outline">
                        <i class="fas fa-shopping-bag"></i>
                        Browse Products
                    </a>
                </div>
                <div class="error-help">
                    <p>Need help? <a href="<?= $this->url('/contact') ?>">Contact our support team</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.error-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}
.error-content {
    text-align: center;
    max-width: 600px;
}
.error-illustration {
    position: relative;
    margin-bottom: 3rem;
}
.error-number {
    font-size: 8rem;
    font-weight: 900;
    color: var(--primary-color);
    opacity: 0.1;
    line-height: 1;
    margin-bottom: -2rem;
}
.error-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 2rem;
}
.error-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}
.error-message {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
    line-height: 1.6;
}
.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.error-help {
    color: var(--text-light);
}
.error-help a {
    color: var(--primary-color);
    text-decoration: none;
}
.error-help a:hover {
    text-decoration: underline;
}
@media (max-width: 768px) {
    .error-number {
        font-size: 6rem;
    }
    .error-icon {
        font-size: 3rem;
    }
    .error-title {
        font-size: 2rem;
    }
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    .error-actions .btn {
        width: 100%;
        max-width: 250px;
    }
}
</style>