<div class="error-container">
    <div class="container">
        <div class="error-content">
            <div class="error-illustration">
                <div class="error-number">500</div>
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="error-text">
                <h1 class="error-title">Internal Server Error</h1>
                <p class="error-message">
                    We're sorry, but something went wrong on our end. Our team has been notified and is working to fix the issue.
                </p>
                <div class="error-actions">
                    <a href="<?= $this->url('/') ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i>
                        Go Home
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-outline">
                        <i class="fas fa-refresh"></i>
                        Try Again
                    </button>
                </div>
                <div class="error-help">
                    <p>If the problem persists, please <a href="<?= $this->url('/contact') ?>">contact our support team</a></p>
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
    color: #ef4444;
    opacity: 0.1;
    line-height: 1;
    margin-bottom: -2rem;
}
.error-icon {
    font-size: 4rem;
    color: #ef4444;
    margin-bottom: 2rem;
}
.error-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary, #333);
    margin-bottom: 1rem;
}
.error-message {
    font-size: 1.125rem;
    color: var(--text-secondary, #666);
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
    color: var(--text-light, #999);
}
.error-help a {
    color: var(--primary-color, #007cba);
    text-decoration: none;
}
.error-help a:hover {
    text-decoration: underline;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s;
}
.btn-primary {
    background: var(--primary-color, #007cba);
    color: white;
}
.btn-primary:hover {
    background: var(--primary-dark, #005a8b);
    transform: translateY(-1px);
}
.btn-outline {
    background: transparent;
    color: var(--text-primary, #333);
    border: 2px solid var(--border-color, #ddd);
}
.btn-outline:hover {
    background: var(--bg-secondary, #f5f5f5);
    border-color: var(--primary-color, #007cba);
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