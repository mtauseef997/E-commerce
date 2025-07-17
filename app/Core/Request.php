<?php
namespace App\Core;
class Request
{
    private $get;
    private $post;
    private $files;
    private $server;
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }
    public function get($key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }
    public function post($key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }
    public function getAllGet()
    {
        return $this->get;
    }
    public function getAllPost()
    {
        return $this->post;
    }
    public function file($key)
    {
        return $this->files[$key] ?? null;
    }
    public function getAllFiles()
    {
        return $this->files;
    }
    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }
    public function isPost()
    {
        return $this->getMethod() === 'POST';
    }
    public function isGet()
    {
        return $this->getMethod() === 'GET';
    }
    public function isAjax()
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && 
               $this->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    public function getUri()
    {
        return $this->server['REQUEST_URI'];
    }
    public function getUserAgent()
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }
    public function getIp()
    {
        if (!empty($this->server['HTTP_CLIENT_IP'])) {
            return $this->server['HTTP_CLIENT_IP'];
        } elseif (!empty($this->server['HTTP_X_FORWARDED_FOR'])) {
            return $this->server['HTTP_X_FORWARDED_FOR'];
        } else {
            return $this->server['REMOTE_ADDR'];
        }
    }
    public function validate($rules)
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            $value = $this->post($field);
            $ruleArray = explode('|', $rule);
            foreach ($ruleArray as $singleRule) {
                if ($singleRule === 'required' && empty($value)) {
                    $errors[$field][] = ucfirst($field) . ' is required';
                } elseif (strpos($singleRule, 'min:') === 0) {
                    $min = (int) substr($singleRule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field][] = ucfirst($field) . " must be at least {$min} characters";
                    }
                } elseif (strpos($singleRule, 'max:') === 0) {
                    $max = (int) substr($singleRule, 4);
                    if (strlen($value) > $max) {
                        $errors[$field][] = ucfirst($field) . " must not exceed {$max} characters";
                    }
                } elseif ($singleRule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = ucfirst($field) . ' must be a valid email address';
                } elseif ($singleRule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = ucfirst($field) . ' must be a number';
                }
            }
        }
        return $errors;
    }
    public function sanitize($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}