<?php
session_start();

define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('CONFIG_PATH', ROOT_PATH . '/config');

require_once ROOT_PATH . '/app/Core/Autoloader.php';

$autoloader = new App\Core\Autoloader();
$autoloader->register();

require_once CONFIG_PATH . '/config.php';

$router = new App\Core\Router();

require_once ROOT_PATH . '/routes/web.php';

$router->handleRequest();
