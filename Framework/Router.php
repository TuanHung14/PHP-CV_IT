<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
    protected $routes = [];
    /**
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @param string $middleware
     * 
     * @return void
     */
    public function registerRoute($method, $uri, $action, $middleware = ['global'])
    {
        // cắt phần tử theo dấu @ và đẩy các phần tử đó ra thành từng biến hàm list()
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware,
        ];
    }
    /**
     * Add a Get route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $middleware
     * @return void
     */
    public function get($uri, $controller, $middleware = ['global'])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }
    /**
     * Add a Post route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $middleware
     * @return void
     */
    public function post($uri, $controller, $middleware = ['global'])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }
    /**
     * Add a Put route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $middleware
     * @return void
     */
    public function put($uri, $controller, $middleware = ['global'])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }
    /**
     * Add a Delete route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $middleware
     * @return void
     */
    public function delete($uri, $controller, $middleware = ['global'])
    {
        $this->registerRoute('DELETE', $uri, $controller,$middleware);
    } 
    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        //check for _method input
        if($requestMethod === 'POST' && isset($_POST['_method'])){
            //Ghi đè phương thức yêu cầu với phương thức _method
            $requestMethod = strtoupper($_POST['_method']);
        }
        foreach ($this->routes as $route) {
            $uriSegments = explode('/', trim($uri, '/')); // Uri trên thanh công cụ search
            $routeSegments = explode('/', trim($route['uri'], '/')); // Uri trong routes
            $match = true;
            if ((count($uriSegments) === count($routeSegments)) && (strtoupper($route['method']) === $requestMethod)) {
                $params = [];
                $match = true;
                $folder = "client";
                for ($i = 0; $i < count($uriSegments); $i++) {
                    
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }
                    if($uriSegments[0] == "admin-panel"){
                        $folder = "admin";
                    }
                    //Kiểm tra param truyền vào và lấy $param array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                if ($match) {
                    foreach ($route['middleware'] as $middleware){
                        $authInstance = new Authorize();
                        $authInstance->handle($middleware);
                    }
                    $controller = 'App\\Controllers\\'. $folder. '\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];
                    // Khởi tạo class controller và gọi cái method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }
        ErrorController::notFound();
    }
}
