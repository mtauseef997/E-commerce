<?php
namespace App\Core;
abstract class Controller
{
    protected $view;
    protected $request;
    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();
    }
    protected function render($template, $data = [], $layout = 'main')
    {
        $data['current_user'] = $this->getCurrentUser();
        $data['cart_count'] = $this->getCartCount();
        $data['csrf_token'] = $this->generateCsrfToken();
        return $this->view->render($template, $data, $layout);
    }
    protected function redirect($url, $statusCode = 302)
    {
        header("Location: {$url}", true, $statusCode);
        exit;
    }
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
    protected function requireAdmin()
    {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }
    }
    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }
    protected function isAdmin()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    protected function getCurrentUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }
    protected function getCurrentUser()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }
        $userModel = new \App\Models\User();
        return $userModel->find($this->getCurrentUserId());
    }
    protected function setFlash($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }
    protected function getFlash($type)
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
    protected function getCartCount()
    {
        $cart = $_SESSION['cart'] ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    protected function generateCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    protected function validateCsrf()
    {
        $token = $this->request->post('csrf_token');
        if (!$token || $token !== $_SESSION['csrf_token']) {
            throw new \Exception('CSRF token validation failed');
        }
    }
    protected function generateCsrf()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}