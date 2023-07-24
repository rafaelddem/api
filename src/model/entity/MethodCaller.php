<?php

namespace api\model\entity;

use api\exceptions\RouteNotExistException;

class MethodCaller
{
    private $className;
    private $methodName;

    public function __construct($className, $methodName)
    {
        if (!(class_exists($className) AND method_exists($className, $methodName))) 
            throw new RouteNotExistException('informed route does not exist', 1100003001);

        $this->className = $className;
        $this->methodName = $methodName;
    }

    public function run(array $parameters = null)
    {
        $method = $this->methodName;
        (new $this->className($parameters))->$method();
    }
}

?>