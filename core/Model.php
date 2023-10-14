<?php
namespace Saphpi;

abstract class Model {
    protected string $tableName;

    protected function conn(): Database {
        return Application::$app->db;
    }

    protected function populate(array $attributes): void {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }
}
