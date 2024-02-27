<?php

namespace Core\Exception;

use Core\App;

class NotFoundException extends \Exception
{
    protected $message = 'El comando no se reconoce';
}