<?php
namespace Saphpi\Core;

use Saphpi\Rules\Required;
use Saphpi\Exceptions\NotImplementException;
use Saphpi\Core\Contracts\Validation\DataAwareRule;
use Saphpi\Core\Contracts\Validation\ValidationRule;

class Validator {
    private function __construct() {}

    public static function validate(array $datas, array $attributeRules): array {
        $arr = [];

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
                    $arr['errors'][$attribute] = str_replace(':attribute', $attribute, $instance->error());
                } else {
                    $arr['validated'][$attribute] = $datas[$attribute];
                }
            }
        }

        return $arr;
    }
}
