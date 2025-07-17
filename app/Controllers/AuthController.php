<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;
class AuthController extends Controller
{
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    public function showLogin()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/');
        }
        $this->render('auth/login', [
            'title' => 'Login',
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success')
        ]);
    }
    public function login()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/login');
        }
        $email = $this->request->post('email');
        $password = $this->request->post('password');
        $remember = $this->request->post('remember');
        $errors = $this->request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!empty($errors)) {
            $this->setFlash('error', 'Please fill in all required fields correctly.');
            $this->redirect('/login');
        }
        $user = $this->userModel->findByEmail($email);
        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->setFlash('error', 'Invalid email or password.');
            $this->redirect('/login');
        }
        if ($user['status'] !== 'active') {
            $this->setFlash('error', 'Your account is inactive. Please contact support.');
            $this->redirect('/login');
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_role'] = $user['role'];
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
        }
        $redirectTo = $_SESSION['intended_url'] ?? ($user['role'] === 'admin' ? '/admin' : '/');
        unset($_SESSION['intended_url']);
        $this->setFlash('success', 'Welcome back!');
        $this->redirect($redirectTo);
    }
    public function showRegister()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/');
        }
        $this->render('auth/register', [
            'title' => 'Register',
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success')
        ]);
    }
    public function register()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/register');
        }
        $data = [
            'first_name' => $this->request->post('first_name'),
            'last_name' => $this->request->post('last_name'),
            'username' => $this->request->post('username'),
            'email' => $this->request->post('email'),
            'password' => $this->request->post('password'),
            'confirm_password' => $this->request->post('confirm_password'),
            'phone' => $this->request->post('phone')
        ];
        $errors = $this->request->validate([
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'username' => 'required|min:3|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required'
        ]);
        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'][] = 'Passwords do not match';
        }
        if ($this->userModel->emailExists($data['email'])) {
            $errors['email'][] = 'Email already exists';
        }
        if ($this->userModel->usernameExists($data['username'])) {
            $errors['username'][] = 'Username already exists';
        }
        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $field => $fieldErrors) {
                $errorMessages = array_merge($errorMessages, $fieldErrors);
            }
            $this->setFlash('error', implode('<br>', $errorMessages));
            $this->redirect('/register');
        }
        unset($data['confirm_password']);
        $userId = $this->userModel->createUser($data);
        if ($userId) {
            $this->setFlash('success', 'Registration successful! Please log in.');
            $this->redirect('/login');
        } else {
            $this->setFlash('error', 'Registration failed. Please try again.');
            $this->redirect('/register');
        }
    }
    public function logout()
    {
        session_destroy();
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        $this->setFlash('success', 'You have been logged out successfully.');
        $this->redirect('/');
    }
    public function showForgotPassword()
    {
        $this->render('auth/forgot-password', [
            'title' => 'Forgot Password',
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success')
        ]);
    }
    public function forgotPassword()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/forgot-password');
        }
        $email = $this->request->post('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash('error', 'Please enter a valid email address.');
            $this->redirect('/forgot-password');
        }
        $user = $this->userModel->findByEmail($email);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->setFlash('success', 'Password reset instructions have been sent to your email.');
        } else {
            $this->setFlash('success', 'If the email exists, password reset instructions have been sent.');
        }
        $this->redirect('/forgot-password');
    }
}