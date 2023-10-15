<?php
namespace Saphpi\Contracts\Validation;

interface DataAwareRule {
    public function setData(array $datas): void;
}
