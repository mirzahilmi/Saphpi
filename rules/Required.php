<?php
namespace Saphpi\Rules;

use Saphpi\Core\Contracts\Validation\DataAwareRule;
use Saphpi\Core\Contracts\Validation\ValidationRule;

class Required implements ValidationRule, DataAwareRule {
    private array $datas;

    public function setData(array $datas): void {
        $this->datas = $datas;
    }

    public function validate(string $attribute, mixed $value): bool {
        return array_key_exists($attribute, $this->datas);
    }

    public function error(): string {
        return ':attribute is required';
    }
}
