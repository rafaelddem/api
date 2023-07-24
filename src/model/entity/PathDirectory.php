<?php

namespace api\model\entity;

use Exception;

class PathDirectory
{
    private string $value;
    private string $variable_name;

    public function __construct(string $value)
    {
        self::setValue($value);
        self::setVariableValue();
    }

    private function setValue(string $value)
    {
        if(strlen($value) < 1 OR strlen($value) > 30)
            throw new Exception('Directory name must be less than 30 characters');
        else if (preg_match('/{{|}}/', $value)) {echo $value;
            throw new Exception('Directory parameter need to respect the patern \'{identify}\'');}
    
        $this->value = $value;
    }
    
    public function getValue() : string {
        return $this->value;
    }

    public function isVariable()
    {
        return preg_match('/({)+([a-z,_]+)+(})/', $this->value); 
    }

    private function setVariableValue()
    {
        if (!self::isVariable()) 
            return;

        $this->variable_name = substr($this->value, 1, -1);
    }

    public function getVariableName()
    {
        return $this->variable_name;
    }

    public function equals(PathDirectory $directory) : bool
    {
        if (self::isVariable()) {
            if (is_numeric($directory->getValue())) 
                return true;
        } else {
            if (self::getValue() == $directory->getValue()) 
                return true;
        }

        return false;
    }
}

?>