<?php
namespace Saphpi\Core;

use Saphpi\Rules\Required;
use Saphpi\Exceptions\NotImplementException;
use Saphpi\Core\Contracts\Validation\DataAwareRule;
use Saphpi\Core\Contracts\Validation\ValidationRule;

class Validator {
    private ?array $validated;
    private ?array $errors;
    private bool $failed = false;

    private function __construct() {}

    public static function validate(array $datas, array $attributeRules): Validator {
        $validator = new Validator();

        foreach ($attributeRules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $colonPos = strpos($rule, ':');
                if ($colonPos !== false) {
                    $arg = substr($rule, $colonPos + 1);
                    $rule = substr($rule, 0, $colonPos);
                }

                $rule = "Saphpi\\Rules\\$rule";
                /** @var \Saphpi\Core\Contracts\Validation\ValidationRule */
                @$instance = new $rule($arg);
                if (!$instance instanceof ValidationRule) {
                    throw new NotImplementException("$rule does not implement ValidationRule interface");
                }

                if ($instance instanceof DataAwareRule) {
                    $instance->setData($datas);
                }

                if (!isset($datas[$attribute]) && !$instance instanceof Required) {
                    continue 2;
                }

                if ($instance->validate($attribute, $datas[$attribute] ?? null) === false) {
                    $validator->errors[] = sprintf($instance->error(), $attribute);
                    $validator->failed = true;
                } else {
                    $validator->validated = $datas[$attribute];
                }
            }
        }

        return $validator;
    }

    public function validated(): ?array {
        return $this->validated;
    }

    public function errors(): ?array {
        return $this->errors;
    }

    public function fails(): bool {
        return $this->failed;
    }
}
