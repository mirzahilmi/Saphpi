<?php
namespace Saphpi\Core;

abstract class Model {
    protected function database(): Database {
        $database = Application::db();
        $database->establishConnection();
        return $database;
    }

    protected function populate(array $attributes): void {
        foreach ($attributes as $attribute => $value) {
            $attribute = $this->snakeToCamelCase($attribute);
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    private function snakeToCamelCase(string $stringArg) {
        $str = str_replace('_', '', ucwords($stringArg, '_'));
        $result = lcfirst($str);
        return $result;
    }
}
