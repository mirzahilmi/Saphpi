<?php
namespace Saphpi;

use Saphpi\Contracts\Validation\DataAwareRule;

class Validator {
    private function __construct() {}

    public static function validate(array $datas, array $attributeRules) {
        $arr = [];

        foreach ($attributeRules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $colonPos = strpos($rule, ':');
                if ($colonPos !== false) {
                    $arg = substr($rule, $colonPos + 1);
                    $rule = substr($rule, 0, $colonPos);
                }

                $rule = "Saphpi\Rules\\$rule";
                /** @var \Saphpi\Contracts\Validation\ValidationRule */
                @$instance = new $rule($arg);
                if ($instance instanceof DataAwareRule) {
                    $instance->setData($datas);
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
