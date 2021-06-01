<?php

namespace IPay88\Responses;

use IPay88\IPay88Core;
use IPay88\Exceptions\InvalidSignatureException;

class Response extends IPay88Core
{
	protected $resMerchantCode;

	protected $resPaymentId;

	protected $resRefNo;

	protected $resAmount;

	protected $resCurrency;

	protected $resRemark;

	protected $resTransId;

	protected $resAuthCode;

	protected $resStatus;

	protected $resErrDesc;

	protected $resSignature;

	protected $resCCName;

	protected $resCCNo;

	protected $resS_bankname;

	protected $resS_country;

	public function __construct($request, $validation = true)
	{
		parent::__construct();

		$this->resMerchantCode = $request->MerchantCode;
		$this->resPaymentId = $request->PaymentId;
		$this->resRefNo = $request->RefNo;
		$this->resAmount = $request->Amount;
		$this->resCurrency = $request->Currency;
		$this->resRemark = $request->Remark;
		$this->resTransId = $request->TransId;
		$this->resAuthCode = $request->AuthCode;
		$this->resStatus = $request->Status;
		$this->resErrDesc = $request->ErrDesc;
		$this->resSignature = $request->Signature;
		$this->resCCName = $request->CCName;
		$this->resCCNo = $request->CCNo;
		$this->resS_bankname = $request->S_bankname;
		$this->resS_country = $request->S_country;

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
}