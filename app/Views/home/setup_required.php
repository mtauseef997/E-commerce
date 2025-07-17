<div class="setup-container">
    <div class="container">
        <div class="setup-content">
            <div class="setup-icon">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <h1 class="setup-title">Setup Required</h1>
            <p class="setup-message">
                Welcome to <?= APP_NAME ?>! It looks like the application needs to be set up first.
            </p>
            <?php if (isset($error)): ?>
                <div class="error-details">
                    <p><strong>Error:</strong> <?= $this->escape($error) ?></p>
                </div>
            <?php endif; ?>
            <div class="setup-steps">
                <h2>Quick Setup Steps:</h2>
                <ol>
                    <li>
                        <strong>Run Database Setup:</strong>
                        <a href="setup.php" class="btn btn-primary">
                            <i class="fas fa-database"></i>
                            Setup Database
                        </a>
                    </li>
                    <li>
                        <strong>Generate Images:</strong>
                        <a href="generate_placeholders.php" class="btn btn-secondary">
                            <i class="fas fa-image"></i>
                            Generate Images
                        </a>
                    </li>
                    <li>
                        <strong>Test Everything:</strong>
                        <a href="test" class="btn btn-outline">
                            <i class="fas fa-check"></i>
                            Run Tests
                        </a>
                    </li>
                </ol>
            </div>
            <div class="setup-info">
                <h3>What will be set up:</h3>
                <ul>
                    <li>✅ Database tables and structure</li>
                    <li>✅ Sample products and categories</li>
                    <li>✅ Test user accounts</li>
                    <li>✅ Product images</li>
                    <li>✅ Sample orders and reviews</li>
                </ul>
            </div>
            <div class="setup-help">
                <p>Need help? Check the <strong>GETTING_STARTED.md</strong> file for detailed instructions.</p>
            </div>
        </div>
    </div>
</div>
<style>
.setup-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.setup-content {
    background: white;
    border-radius: 12px;
    padding: 3rem;
    max-width: 600px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
.setup-icon {
    font-size: 4rem;
    color: #667eea;
    margin-bottom: 2rem;
}
.setup-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}
.setup-message {
    font-size: 1.125rem;
    color: #666;
    margin-bottom: 2rem;
    line-height: 1.6;
}
.error-details {
    background: #fee;
    border: 1px solid #fed7d7;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 2rem;
    color: #c53030;
    font-size: 0.875rem;
}
.setup-steps {
    text-align: left;
    margin-bottom: 2rem;
}
.setup-steps h2 {
    color: #333;
    margin-bottom: 1rem;
    text-align: center;
}
.setup-steps ol {
    list-style: none;
    counter-reset: step-counter;
}
.setup-steps li {
    counter-increment: step-counter;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    position: relative;
}
.setup-steps li::before {
    content: counter(step-counter);
    position: absolute;
    left: -10px;
    top: -10px;
    background: #667eea;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}
.setup-info {
    text-align: left;
    margin-bottom: 2rem;
}
.setup-info h3 {
    color: #333;
    margin-bottom: 1rem;
    text-align: center;
}
.setup-info ul {
    list-style: none;
    padding: 0;
}
.setup-info li {
    padding: 0.5rem 0;
    color: #666;
}
.setup-help {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 6px;
    padding: 1rem;
    color: #0369a1;
    font-size: 0.875rem;
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
    margin: 0.5rem;
}
.btn-primary {
    background: #667eea;
    color: white;
}
.btn-primary:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
}
.btn-secondary {
    background: #6b7280;
    color: white;
}
.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-1px);
}
.btn-outline {
    background: transparent;
    color: #333;
    border: 2px solid #ddd;
}
.btn-outline:hover {
    background: #f5f5f5;
    border-color: #667eea;
}
@media (max-width: 768px) {
    .setup-content {
        padding: 2rem;
        margin: 1rem;
    }
    .setup-title {
        font-size: 2rem;
    }
    .setup-steps li {
        padding: 0.75rem;
    }
    .btn {
        width: 100%;
        justify-content: center;
        margin: 0.25rem 0;
    }
}
</style>