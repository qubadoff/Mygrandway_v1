<?php

namespace App\Exceptions;

use Exception;

class OtpException extends Exception
{
    protected $code = 400;
}
