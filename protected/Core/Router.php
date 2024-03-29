<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{

    private array $routes = [];

    public function add(string $method, string $uri, $controller, array $middlware = []): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'middleware' => $middlware
        ];
    }


    public function post(string $uri, $controller,  array $middleware = []): void
    {
        $this->add('POST', $uri, $controller, $middleware);
    }


    public function get($uri, $controller, array $middleware = []): void
    {
        $this->add('GET', $uri, $controller, $middleware);
    }


    public function put($uri, $controller, array $middleware = []): void
    {
        $this->add('PUT', $uri, $controller, $middleware);
    }


    public function delete($uri, $controller, array $middleware = []): void
    {
        $this->add('DELETE', $uri, $controller, $middleware);
    }


    public function route($uri, $method): void
    {


        foreach ($this->routes as $route) {
            if ($this->uriValidator($uri, $method, $route['uri'], $route['method'])) {
                if ($route["middleware"]) {
                    foreach ($route["middleware"] as $m) {
                        Middleware::check($m);
                    }
                }
                $routeParams = $this->extractRouteParams($uri, $route['uri']);
                $route['controller']($routeParams);
                return;
            }
        }
        http_response_code(404);
        require "protected/views/404.php";
        die();
    }



    private function uriValidator($uri, $uriMethod, $routeUri, $routeMethod): bool
    {

        if (str_contains($routeUri, '{')) {

            $paramStart = strpos($routeUri, '{');
            $uriWithoutParams = substr($uri, 0, $paramStart - 1);
            $routeUriWithoutParams = substr($routeUri, 0, $paramStart - 1);
        } else {
            return $routeUri === $uri && $routeMethod === $uriMethod;
        }
        return $routeUriWithoutParams === $uriWithoutParams && $routeMethod === $uriMethod;
    }


    private function extractRouteParams($uri, $routeUri): array
    {
        $uriParts = explode('/', $uri);
        $routeParts = explode('/', $routeUri);
        $routeParams = [];
        foreach ($routeParts as $key => $part) {
            if (str_contains($part, '{') && str_contains($part, '}')) {
                $part = trim($part, '{}');
                $routeParams = [$part => $uriParts[$key]];
            }
        }
        return $routeParams;
    }
}
