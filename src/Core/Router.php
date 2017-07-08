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
        $uri = $this->getUri();
        $resultActionWork = false;
        $pregMuchResult = false;

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $pregMuchResult = true;
                $segments = explode('/', $path);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = 'Controller\\' . ucfirst($controllerName);
                $actionName = array_shift($segments) . 'Action';

                if (class_exists($controllerName)) {
                    $controller = new $controllerName;

                    if (method_exists($controller, $actionName)) {

                        /** Here it is possible to write a recursion for processing of URLs of any nesting */
                        if (strpos($uri, '/')) {
                            $uriSegment = explode('/', $uri);
                            $endPointUri = end($uriSegment);
                            if ($controller->$actionName($endPointUri)) {
                                $resultActionWork = true;
                            }
                        } else {
                            if ($controller->$actionName()) {
                                $resultActionWork = true;
                            }
                        }

                    } else {
                        echo "<pre>" . var_dump("action $actionName does not exist") . "</pre>";
                        exit;
                    }

                } else {
                    echo "<pre>" . var_dump("Controller $controllerName does not exist") . "</pre>";
                    exit;
                }

                break;
            }
        }

        if ($uriPattern === end($this->routes) && $resultActionWork === false || $pregMuchResult === false) {
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
            $result = $_SERVER['REQUEST_URI'];
            if (strlen($result) > 1) {
                $result = trim($result, '/');
            }

            return $result;
        }
    }
}
