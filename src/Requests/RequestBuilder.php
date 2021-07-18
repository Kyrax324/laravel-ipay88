<?php

namespace IPay88\Requests;

use IPay88\IPay88Core;

class RequestBuilder extends IPay88Core
{	
	// Refer to Appendix I.pdf file for MYR gateway. Refer to Appendix II.pdf file for Multi-curency gateway.
	protected $paymentID = '';

	// Unique merchant transaction number / Order
	protected $refNo;

	// Payment amount with two decimals and thousand symbols. Example: 1,278.99
	protected $amount;

	// Refer to Appendix I.pdf file for MYR gateway. Refer to Appendix II.pdf file for Multi-curency gateway.
	protected $currency;

	// Product description
	protected $prodDesc;

	// Customer name
	protected $userName;

	// Customer email for receiving receipt
	protected $userEmail;

	// Customer contact number
	protected $userContact;

	// Merchant remarks
	protected $remark = '';

	// Signature type = "SHA256" SHA-256 signature (refer to 3.1)
	protected $signature;

	//  Payment response page
	protected $responseURL;

	// Backend response page URL (refer to 2.7)
	protected $backendURL;

	public function setPaymentID($paymentID){
		$this->paymentID = $paymentID;
	}

	public function setRefNo($refNo){
		$this->refNo = $refNo;
	}

		// to 2.d.p & with thousand separator
	public function setAmount($amount){
		$this->amount = number_format($amount, 2, '.', ',');
	}

	public function setCurrency($currency){
		$this->currency = $currency;
	}

	public function setProdDesc($prodDesc){
		$this->prodDesc = $prodDesc;
	}

	public function setUserName($userName){
		$this->userName = $userName;
	}

	public function setUserEmail($userEmail){
		$this->userEmail = $userEmail;
	}

	public function setUserContact($userContact){
		$this->userContact = $userContact;
	}

	public function setRemark($remark){
		$this->remark = $remark;
	}

	public function setSignature($signature){
		$this->signature = $signature;
	}

	public function setResponseURL($responseURL){
		$this->responseURL = $responseURL;
	}

	public function setBackendURL($backendURL){
		$this->backendURL = $backendURL;
	}

	public function generateRequestSignature() : string
	{	
		$payload = [
			$this->merchantKey,
			$this->merchantCode,
			$this->refNo,
			preg_replace('/[\.\,]/', '', $this->amount),
			$this->currency
		];

		$this->signature = self::generateSignature( join('', $payload) );

		return $this->signature;
	}

	// generate signature & return array of required fields
	public function toRequestArray() : array
	{
		$this->generateRequestSignature();

		return [
			'MerchantCode' => $this->merchantCode,
			'PaymentId' => $this->paymentID,
			'RefNo' => $this->refNo,
			'Amount' => $this->amount,
			'Currency' => $this->currency,
			'ProdDesc' => $this->prodDesc,
			'UserName' => $this->userName,
			'UserEmail' => $this->userEmail,
			'UserContact' => $this->userContact,
			'Remark'=>  $this->remark,
			'Lang' => $this->lang,
			'SignatureType' => $this->signatureType,
			'Signature' => $this->signature,
			'ResponseURL' => $this->responseURL,
			'BackendURL' => $this->backendURL,
		];
	}

	// load the payment form
	public function loadPaymentFormView($data = null)
	{
		return view("iPay88::payment-form", [
			"requestUrl" => $this->requestUrl,
			"payload" => $this->toRequestArray(),
			"data" => $data
		]);
	}
}