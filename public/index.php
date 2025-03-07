<?php 
    require __DIR__ . '/../vendor/autoload.php';
    // require(__DIR__ . '/../helpers.php');
    // inspectAndDie($_SERVER['REQUEST_URI']);
    require "../helpers.php";
    use Framework\Router;
    use Framework\Session;
    Session::start();
    // Khởi tạo router
    $router = new Router();
    // Get Routes
    $routes = require basePath("routes.php");
    // Get phương thức Uri và HTTP method
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // router the request
    $router->route($uri);
    



