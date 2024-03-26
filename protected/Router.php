<?php

namespace Router;

class Router
{

    private $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
        ];
    }


    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }


    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }


    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);
    }


    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }


    public function route($uri, $method)
    {

        foreach ($this->routes as $route) {
            if ($this->uriValidator($uri, $method, $route['uri'], $route['method'])) {
                $routeParams = $this->extractRouteParams($uri, $route['uri']);
                $route['controller']($routeParams);
                return;
            }
        }
        http_response_code(404);
        require "protected/views/404.php";
        echo "Route not found for URI: $uri and Method: $method";
        die();
    }



    private function uriValidator($uri, $uriMethod, $routeUri, $routeMethod)
    {

        if (strpos($routeUri, '{') !== false) {

            $paramStart = strpos($routeUri, '{');
            $uriWithoutParams = substr($uri, 0, $paramStart - 1);
            $routeUriWithoutParams = substr($routeUri, 0, $paramStart - 1);
        } else {
            $uriWithoutParams = $uri;
            $routeUriWithoutParams = $routeUri;
        }
        return $routeUriWithoutParams === $uriWithoutParams && $routeMethod === $uriMethod;
    }


    private function extractRouteParams($uri, $routeUri)
    {
        $uriParts = explode('/', $uri);
        $routeParts = explode('/', $routeUri);
        $routeParams = [];
        foreach ($routeParts as $key => $part) {
            if (strpos($part, '{') !== false && strpos($part, '}') !== false) {
                $part = trim($part, '{}');
                $routeParams = [$part => $uriParts[$key]];
            }
        }
        return $routeParams;
    }
}
