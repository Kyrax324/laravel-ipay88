<?php

namespace IPay88\Requests;

use IPay88\IPay88Core;

class RequestBuilder extends IPay88Core
{
	protected $paymentID = '';

	protected $refNo;

	protected $amount;

	protected $currency;

	protected $prodDesc;

	protected $userName;

	protected $userEmail;

	protected $userContact;

	protected $remark = '';

	protected $signature;

	protected $responseURL;

	protected $backendURL;

	public function setPaymentID($paymentID){
		$this->paymentID = $paymentID;
	}

	public function setRefNo($refNo){
		$this->refNo = $refNo;
	}

	public function setAmount($amount){
		$this->amount = number_format($amount, 2, '.', '');
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

	public function toArray() : array
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


	public function renderView($autoSubmit = true,  $fieldType = "hidden")
	{
		echo "<form id='autosubmit' action='".$this->requestUrl."' method='post'>";

		$fields = $this->toArray();
		foreach ($fields as $key => $val) {
			echo "<div><input type='{$fieldType}' name='{$key}' value='{$val}'></div>";
		}

		echo "</form>";
		if($autoSubmit){
			echo "
			<script type='text/javascript'>
				function submitForm() {
					document.getElementById('autosubmit').submit();
				}
				window.onload = submitForm;
			</script>
			";
		}

		return null;
	}
}