<?php

namespace IPay88\Exceptions;

use Exception;

class DailyRequeryLimitException extends Exception
{
	protected $message = 'Limited by per day maximum number of requery';
}