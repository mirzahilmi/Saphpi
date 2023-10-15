<?php
namespace Saphpi\Exceptions;

class NotFoundException extends \Exception {
    protected $message = 'Not Found';
    protected $code = 404;
}
