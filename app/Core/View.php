<?php
namespace App\Core;
class View
{
    private $viewPath;
    private $layoutPath;
    private $data = [];
    public function __construct()
    {
        $this->viewPath = ROOT_PATH . '/app/Views/';
        $this->layoutPath = ROOT_PATH . '/app/Views/layouts/';
    }
    public function render($template, $data = [], $layout = 'main')
    {
        $this->data = array_merge($this->data, $data);
        $this->data['app_name'] = APP_NAME;
        $this->data['app_url'] = APP_URL;
        $this->data['current_user'] = $this->getCurrentUser();
        $this->data['cart_count'] = $this->getCartCount();
        $this->data['csrf_token'] = $this->getCsrfToken();
        ob_start();
        $viewFile = $this->viewPath . $template . '.php';
        if (file_exists($viewFile)) {
            extract($this->data);
            include $viewFile;
        } else {
            throw new \Exception("View file not found: {$viewFile}");
        }
        $content = ob_get_clean();
        if ($layout) {
            $this->data['content'] = $content;
            $layoutFile = $this->layoutPath . $layout . '.php';
            if (file_exists($layoutFile)) {
                extract($this->data);
                include $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    public function partial($template, $data = [])
    {
        $data = array_merge($this->data, $data);
        $viewFile = $this->viewPath . 'partials/' . $template . '.php';
        if (file_exists($viewFile)) {
            extract($data);
            include $viewFile;
        } else {
            throw new \Exception("Partial view file not found: {$viewFile}");
        }
    }
    public function share($key, $value)
    {
        $this->data[$key] = $value;
    }
    private function getCurrentUser()
    {
        if (isset($_SESSION['user_id'])) {
            $userModel = new \App\Models\User();
            return $userModel->find($_SESSION['user_id']);
        }
        return null;
    }
    private function getCartCount()
    {
        if (isset($_SESSION['cart'])) {
            return array_sum(array_column($_SESSION['cart'], 'quantity'));
        }
        return 0;
    }
    private function getCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    public function currency($amount)
    {
        return CURRENCY_SYMBOL . number_format($amount, 2);
    }
    public function date($date, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($date));
    }
    public function url($path = '')
    {
        return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
    }
    public function asset($path)
    {
        return ltrim($path, '/');
    }
    public function isActive($route)
    {
        $currentUri = $_SERVER['REQUEST_URI'];
        return strpos($currentUri, $route) !== false;
    }
    public function flash($type)
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
}