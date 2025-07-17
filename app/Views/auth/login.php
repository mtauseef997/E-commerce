<div class="auth-container">
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-card animate-scale-in">
                <div class="auth-header">
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Sign in to your account to continue shopping</p>
                </div>
                <form action="<?= $this->url('/login') ?>" method="POST" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               placeholder="Enter your email"
                               value="<?= $this->escape($_POST['email'] ?? '') ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-input-group">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-input" 
                                   placeholder="Enter your password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" value="1" class="checkbox-input">
                                <span class="checkbox-custom"></span>
                                Remember me
                            </label>
                            <a href="<?= $this->url('/forgot-password') ?>" class="forgot-link">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full btn-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                </form>
                <div class="auth-divider">
                    <span>or</span>
                </div>
                <div class="social-login">
                    <button class="btn btn-ghost btn-full social-btn">
                        <i class="fab fa-google"></i>
                        Continue with Google
                    </button>
                    <button class="btn btn-ghost btn-full social-btn">
                        <i class="fab fa-facebook"></i>
                        Continue with Facebook
                    </button>
                </div>
                <div class="auth-footer">
                    <p>Don't have an account? 
                        <a href="<?= $this->url('/register') ?>" class="auth-link">
                            Create one here
                        </a>
                    </p>
                </div>
            </div>
            <div class="auth-image animate-fade-in-right">
                <img src="<?= $this->asset('images/auth-login.svg') ?>" alt="Login Illustration">
                <div class="auth-image-overlay">
                    <h3>Join Our Community</h3>
                    <p>Discover amazing products and enjoy a seamless shopping experience with exclusive member benefits.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    position: relative;
    overflow: hidden;
}
.auth-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?= $this->asset('images/auth-bg-pattern.svg') ?>') repeat;
    opacity: 0.1;
}
.auth-wrapper {
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem 0;
}
.auth-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: 3rem;
    box-shadow: var(--shadow-xl);
    position: relative;
}
.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}
.auth-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}
.auth-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
}
.auth-form {
    margin-bottom: 2rem;
}
.form-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-secondary);
}
.checkbox-input {
    display: none;
}
.checkbox-custom {
    width: 1rem;
    height: 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    position: relative;
    transition: all var(--transition-fast);
}
.checkbox-input:checked + .checkbox-custom {
    background: var(--primary-color);
    border-color: var(--primary-color);
}
.checkbox-input:checked + .checkbox-custom::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 0.75rem;
    font-weight: bold;
}
.forgot-link {
    color: var(--primary-color);
    font-size: 0.875rem;
    text-decoration: none;
    transition: color var(--transition-fast);
}
.forgot-link:hover {
    color: var(--primary-dark);
}
.password-input-group {
    position: relative;
}
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0.25rem;
    transition: color var(--transition-fast);
}
.password-toggle:hover {
    color: var(--primary-color);
}
.auth-divider {
    position: relative;
    text-align: center;
    margin: 2rem 0;
    color: var(--text-light);
}
.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--border-color);
}
.auth-divider span {
    background: white;
    padding: 0 1rem;
    position: relative;
}
.social-login {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}
.social-btn {
    justify-content: flex-start;
    gap: 1rem;
}
.social-btn i {
    width: 1.25rem;
    text-align: center;
}
.auth-footer {
    text-align: center;
    color: var(--text-secondary);
}
.auth-link {
    color: var(--primary-color);
    font-weight: 500;
    text-decoration: none;
    transition: color var(--transition-fast);
}
.auth-link:hover {
    color: var(--primary-dark);
}
.auth-image {
    text-align: center;
    color: white;
}
.auth-image img {
    width: 100%;
    max-width: 400px;
    height: auto;
    margin-bottom: 2rem;
}
.auth-image-overlay h3 {
    font-size: 1.75rem;
    margin-bottom: 1rem;
    color: white;
}
.auth-image-overlay p {
    font-size: 1rem;
    opacity: 0.9;
    line-height: 1.6;
}
@media (max-width: 768px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .auth-card {
        padding: 2rem;
    }
    .auth-image {
        order: -1;
    }
    .auth-image img {
        max-width: 250px;
    }
    .form-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
@media (max-width: 480px) {
    .auth-card {
        padding: 1.5rem;
        margin: 1rem;
    }
    .auth-title {
        font-size: 1.5rem;
    }
}
</style>
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.nextElementSibling;
    const icon = toggle.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
document.querySelector('.auth-form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if (!email || !password) {
        e.preventDefault();
        App.showNotification('Please fill in all required fields', 'error');
        return;
    }
    if (!email.includes('@')) {
        e.preventDefault();
        App.showNotification('Please enter a valid email address', 'error');
        return;
    }
});
</script>