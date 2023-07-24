<?php

namespace api\model\entity;

use Exception;

class Path
{
    private string $original_value;
    protected array $directories;

    public function __construct(string $original_value)
    {
        self::setOriginalValue($original_value);
        self::extractDirectories();
    }

    private function setOriginalValue(string $original_value)
    {
        if (preg_match('/[!@#$%&*$?<>:;|]/', $original_value))
            throw new Exception('Path value only accepts letters, numbers and the characters \'{\', \'}\' and \'_\'');
        else if (preg_match('/\/\//', $original_value)) {
            throw new Exception('Path need to respect the patern \'/directory/subdirectory\'');}

        $this->original_value = $original_value;
    }

    private function extractDirectories()
    {
        $directories = explode('/', $this->original_value);
        foreach ($directories as $directory_name) {
            if (empty($directory_name)) continue;

            $directory = new PathDirectory($directory_name);
            $this->directories[] = $directory;
        }
    }

    public function getDirectories() : array {
        return $this->directories;
    }

    public function equals(Path $path) : bool
    {
        if (count($path->getDirectories()) != count($this->directories))
            return false;

        foreach ($this->directories as $directory_target) {
            $directory_target_key = array_search($directory_target, $this->directories);

            if (!$directory_target->equals($path->getDirectories()[$directory_target_key]))
                return false;
        }

        return true;
    }
}

?>