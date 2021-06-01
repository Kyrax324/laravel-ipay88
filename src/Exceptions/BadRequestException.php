<?php

namespace IPay88\Exceptions;

use Exception;

class BadRequestException extends Exception
{
	public function __construct($message)
	{
		$this->message = $message;
	}
}