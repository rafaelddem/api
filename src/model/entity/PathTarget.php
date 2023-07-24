<?php

namespace api\model\entity;

use Exception;

class PathTarget extends Path
{
    private array $variables;

    public function __construct(string $original_value)
    {
        parent::__construct($original_value);
        self::identifyVariables();
    }

    public function identifyVariables() {
        $directories = $this->directories;
        foreach ($directories as $directory) {
            if ($directory->isVariable()) {
                $index = array_search($directory, $directories);
                $this->variables[array_search($directory, $directories)] = $directory->getVariableName();
            }
        }
    }

    public function extractVariables(Path $pathRequest) {
        if (!parent::equals($pathRequest)) 
            throw new Exception("The two \'Path\' are not equals");

        $variables = array();
        foreach ($this->variables as $variable_index => $variable_name) {
            $variables[$variable_name] = $pathRequest->getDirectories()[$variable_index];
        }

        return $variables;
    }
}

?>