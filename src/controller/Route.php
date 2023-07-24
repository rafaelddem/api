<?php

namespace api\controller;

use api\conf\Parameters;
use api\exceptions\RouteNotExistException;
use api\model\entity\requisition\DELETE;
use api\model\entity\requisition\GET;
use api\model\entity\requisition\POST;
use api\model\entity\requisition\PUT;
use api\model\entity\MethodCaller;

class Route
{
    static array $routes = array();

    static function addGet(string $path, string $class_name, string $method)
    {
        try {
            self::$routes[Parameters::REQUEST_METHOD_GET][$path] = new MethodCaller($class_name, $method);
        } catch (\Throwable $th) {
            Response::send(['code' => $th->getCode(), 'message' => $th->getMessage()], true, 404);
        }
    }

    static function addPost(string $path, string $class_name, string $method)
    {
        try {
            self::$routes[Parameters::REQUEST_METHOD_POST][$path] = new MethodCaller($class_name, $method);
        } catch (\Throwable $th) {
            Response::send(['code' => $th->getCode(), 'message' => $th->getMessage()], true, 404);
        }
    }

    static function addPut(string $path, string $class_name, string $method)
    {
        try {
            self::$routes[Parameters::REQUEST_METHOD_PUT][$path] = new MethodCaller($class_name, $method);
        } catch (\Throwable $th) {
            Response::send(['code' => $th->getCode(), 'message' => $th->getMessage()], true, 404);
        }
    }

    static function addDelete(string $path, string $class_name, string $method)
    {
        try {
            self::$routes[Parameters::REQUEST_METHOD_DELETE][$path] = new MethodCaller($class_name, $method);
        } catch (\Throwable $th) {
            Response::send(['code' => $th->getCode(), 'message' => $th->getMessage()], true, 404);
        }
    }

    static function getPath()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case Parameters::REQUEST_METHOD_POST:
                    $baseMethod = new POST;
                    break;
    
                case Parameters::REQUEST_METHOD_PUT:
                    $baseMethod = new PUT;
                    break;
    
                case Parameters::REQUEST_METHOD_DELETE:
                    $baseMethod = new DELETE;
                    break;
    
                default:
                    $baseMethod = new GET;
                    break;
            }
    
            if (!isset(self::$routes[$baseMethod->getMethodType()][$baseMethod->getUrlPath()])) 
                throw new RouteNotExistException('informed route does not exist', 1100002001);
    
            self::$routes[$baseMethod->getMethodType()][$baseMethod->getUrlPath()]->run($baseMethod->getUrlParameters());
        } catch (\Throwable $th) {
            Response::send(['code' => $th->getCode(), 'message' => $th->getMessage()], true, 404);
        }
    }
}

?>