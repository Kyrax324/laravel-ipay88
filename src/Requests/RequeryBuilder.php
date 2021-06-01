<?php

namespace IPay88\Requests;

use IPay88\IPay88Core;
use IPay88\Exceptions\BadRequestException;
use IPay88\Exceptions\DailyRequeryLimitException;

class RequeryBuilder extends IPay88Core
{

	private $resultMessage;

	const STATUS_PAYMENT_SUCCESS = "00";

	const STATUS_INVALID_PARAMETERS = "INVALID PARAMETERS";

	const STATUS_RECORD_NOT_FOUND = "RECORD NOT FOUND";

	const STATUS_INCORRECT_AMOUNT = "INCORRECT AMOUNT";

	const STATUS_PAYMENT_FAILED = "PAYMENT FAIL";

	const STATUS_FAILED_BY_IPAY88_ADMIN = "M88ADMIN";

	const STATUS_REACHED_DAILY_MAXIMUM_REQUERY_NUMBER = "LIMITED BY PER DAY MAXIMUM NUMBER OF REQUERY";

	protected $refNo;

	protected $amount;

	public function setRefNo($refNo){
		$this->refNo = $refNo;
	}

	public function setAmount($amount){
		$this->amount = number_format($amount, 2, '.', '');
	}

	public function getResultMessage()
	{
		return $this->resultMessage;
	}

	public function handleable() : array
	{
		return [ 
			self::STATUS_PAYMENT_SUCCESS,
			self::STATUS_PAYMENT_FAILED,
			self::STATUS_FAILED_BY_IPAY88_ADMIN,
			self::STATUS_RECORD_NOT_FOUND,
		];
	}

	public function submit() : string
	{
		$url = $this->requeryUrl.'?'.http_build_query([
			'MerchantCode' => $this->merchantCode,
			'RefNo' => $this->refNo,
			'Amount' => $this->amount
		]);

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $curl_result = curl_exec($ch);

	    $upper_curl_result = strtoupper($curl_result);
	    if($upper_curl_result == self::STATUS_REACHED_DAILY_MAXIMUM_REQUERY_NUMBER){
	    	throw new DailyRequeryLimitException();
	    }

	    if( !in_array($upper_curl_result, $this->handleable() ) ){
	    	throw new BadRequestException($curl_result);
	    }

	    $this->resultMessage = $curl_result;

	    return $curl_result;
	}

	public function isSuccess() : bool
	{
		if($this->resultMessage == null){
			$this->submit();
		}
		return strtoupper($this->resultMessage) == self::STATUS_PAYMENT_SUCCESS;
	}

	public function isFailure() : bool
	{
		if($this->resultMessage == null){
			$this->submit();
		}
		return in_array(strtoupper($this->resultMessage), [ self::STATUS_PAYMENT_FAILED, self::STATUS_FAILED_BY_IPAY88_ADMIN]);
	}

	public function recordNotFound() : bool
	{
		if($this->resultMessage == null){
			$this->submit();
		}
		return strtoupper($this->resultMessage) == self::STATUS_RECORD_NOT_FOUND;
	}
}