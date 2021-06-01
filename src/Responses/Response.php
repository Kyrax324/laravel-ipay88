<?php

namespace IPay88\Responses;

use IPay88\IPay88Core;
use IPay88\Exceptions\InvalidSignatureException;
use Illuminate\Support\Arr;

class Response extends IPay88Core
{
	protected $resMerchantCode;

	protected $resPaymentId;

	protected $resRefNo;

	protected $resAmount;

	protected $resStatus;

	protected $resSignature;

	protected $mandatoryFields = [
		'MerchantCode',
		'PaymentId',
		'RefNo',
		'Amount',
		'Currency',
		'Status',
		'Signature'
	];

	protected $additionalResults;

	public function __construct(Array $request, $validation = true)
	{
		parent::__construct();

		$this->resMerchantCode = $request['MerchantCode'];
		$this->resPaymentId = $request['PaymentId'];
		$this->resRefNo = $request['RefNo'];
		$this->resAmount = $request['Amount'];
		$this->resCurrency = $request['Currency'];
		$this->resStatus = $request['Status'];
		$this->resSignature = $request['Signature'];
		$this->additionalResults = Arr::except($request, $this->mandatoryFields);

		if($validation){
			self::verifySignature();
		}
	}

	public function generateResponseSignature() : string
	{	
		$payload = [
			$this->merchantKey,
			$this->resMerchantCode,
			$this->resPaymentId,
			$this->resRefNo,
			preg_replace('/[\.\,]/', '', $this->resAmount),
			$this->resCurrency,
			$this->resStatus
		];

		$signature = self::generateSignature( join('',$payload) );

		return $signature;
	}

	public function verifySignature() : bool
	{
		$verified = ($this->resSignature == self::generateResponseSignature());
		
		if(!$verified){
			throw new InvalidSignatureException;		
		}

		return true;
	}

	public function isSuccess() : bool
	{
		return $this->resStatus == 1;
	}

	public function getAdditionalResults() : Array
	{
		return $this->additionalResults;
	}
}