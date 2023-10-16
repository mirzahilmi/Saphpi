<?php
namespace Saphpi\Core\Contracts\Validation;

interface DataAwareRule {
    public function setData(array $datas): void;
}
