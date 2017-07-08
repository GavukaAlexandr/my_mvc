<?php

namespace Core;

use Config\Routing;

class Router
{
    private $routes;

    public function __construct(Routing $routing)
    {
        $this->routes = $routing->routes;
    }

    /**
     * This function finds the controller by URI and starts the action
     */
    public function run()
    {
        $uriData = $this->getUri();

        if (is_array($uriData)) {
            $uri = $uriData['0'];
            $endPointUri = $uriData['1'];
        } else {
            $uri = $uriData;
        }

        /** The same can be done with preg_match (), but my implementation without foreach */
        if (array_key_exists($uri, $this->routes)) {
                $segments = explode('/', $this->routes[$uri]);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = 'Controller\\' . ucfirst($controllerName);
                $actionName = array_shift($segments) . 'Action';

                if (class_exists($controllerName)) {
                    $controller = new $controllerName;

                    if (method_exists($controller, $actionName)) {
                        if (!empty($endPointUri)) {
                            $controller->$actionName($endPointUri);
                        }

                        $controller->$actionName();
                    } else {
                        echo "<pre>" . var_dump("action $actionName does not exist") . "</pre>";exit;
                    }

                } else {
                    echo "<pre>" . var_dump("Controller $controllerName does not exist") . "</pre>";exit;
                }
        } else {
            echo '<h1>404 Page not found</h1>';
            http_response_code(404);
        }
    }

    /**
     * @return string or array URI
     */
    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            if (strlen($_SERVER['REQUEST_URI']) > 1) {
                $result = trim($_SERVER['REQUEST_URI'], '/');

                if (strpos($result, '/')) {
                    $result = explode('/', $result);

                    return $result;
                }

                return $result;
            } else {
                return $_SERVER['REQUEST_URI'];
            }
        }
    }
}
