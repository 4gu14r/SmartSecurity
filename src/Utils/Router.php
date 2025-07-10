<?php

namespace SmartSecurity\Utils;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    
    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }
    
    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }
    
    public function put(string $path, callable|array $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }
    
    public function delete(string $path, callable|array $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }
    
    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function middleware(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
    
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Execute middlewares
        foreach ($this->middlewares as $middleware) {
            $middleware();
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                $params = $this->extractParams($route['path'], $path);
                $this->executeHandler($route['handler'], $params);
                return;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        include __DIR__ . '/../Views/errors/404.php';
    }
    
    private function matchPath(string $routePath, string $requestPath): bool
    {
        $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $routePattern = '#^' . $routePattern . '$#';
        
        return preg_match($routePattern, $requestPath);
    }
    
    private function extractParams(string $routePath, string $requestPath): array
    {
        $routePattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $routePath);
        $routePattern = '#^' . $routePattern . '$#';
        
        preg_match($routePattern, $requestPath, $matches);
        
        return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    }
    
    private function executeHandler(callable|array $handler, array $params): void
    {
        if (is_array($handler)) {
            [$controllerClass, $method] = $handler;
            $controller = new $controllerClass();
            $controller->$method($params);
        } else {
            $handler($params);
        }
    }
}

