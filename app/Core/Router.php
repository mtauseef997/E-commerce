<?php
namespace App\Core;
class Router
{
    private $routes = [];
    private $currentRoute = null;
    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }
    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }
    private function addRoute($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }
    public function handleRequest()
    {
        try {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $requestUri = $this->getRequestUri();
            foreach ($this->routes as $route) {
                if ($route['method'] === $requestMethod && $this->matchRoute($route['uri'], $requestUri)) {
                    $this->currentRoute = $route;
                    return $this->executeRoute($route['action'], $this->getRouteParams($route['uri'], $requestUri));
                }
            }
            $this->handleNotFound();
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }
    private function getRequestUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        $basePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', ROOT_PATH);
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        return rtrim($uri, '/') ?: '/';
    }
    private function matchRoute($routeUri, $requestUri)
    {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';
        return preg_match($pattern, $requestUri);
    }
    private function getRouteParams($routeUri, $requestUri)
    {
        $params = [];
        preg_match_all('/\{([^}]+)\}/', $routeUri, $paramNames);
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';
        if (preg_match($pattern, $requestUri, $matches)) {
            array_shift($matches);
            foreach ($paramNames[1] as $index => $name) {
                if (isset($matches[$index])) {
                    $params[$name] = $matches[$index];
                }
            }
        }
        return $params;
    }
    private function executeRoute($action, $params = [])
    {
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }
        if (is_string($action) && strpos($action, '@') !== false) {
            list($controllerName, $methodName) = explode('@', $action);
            $controllerClass = "App\\Controllers\\{$controllerName}";
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $methodName)) {
                    return call_user_func_array([$controller, $methodName], $params);
                }
            }
        }
        throw new \Exception("Route action not found: " . (is_string($action) ? $action : 'closure'));
    }
    private function handleNotFound()
    {
        http_response_code(404);
        $view = new View();
        $view->render('errors/404');
        exit;
    }
    private function handleError(\Exception $e)
    {
        http_response_code(500);
        if (defined('APP_DEBUG') && APP_DEBUG) {
            echo '<h1>Application Error</h1>';
            echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
            echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
            if (defined('APP_URL')) {
                echo '<p><a href="' . APP_URL . '/test">Run Diagnostics</a></p>';
            }
        } else {
            $view = new View();
            $view->render('errors/500');
        }
        exit;
    }
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }
}