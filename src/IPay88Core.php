<?php

namespace IPay88;

class IPay88Core
{	
	protected $merchantKey;

	protected $merchantCode;

	protected $requestUrl = "https://payment.ipay88.com.my/ePayment/entry.asp";

	protected $requeryUrl = "https://payment.ipay88.com.my/ePayment/enquiry.asp";

	protected $lang = "UTF-8";

	protected $signatureType = "SHA256";

	public function setMerchantKey($merchantKey){
		$this->merchantKey = $merchantKey;
	}

	public function setMerchantCode($merchantCode){
		$this->merchantCode = $merchantCode;
	}

	public function setRequestUrl($requestUrl){
		$this->requestUrl = $requestUrl;
	}

	public function setRequeryUrl($requeryUrl){
		$this->requeryUrl = $requeryUrl;
	}

	public function setLang($lang){
		$this->lang = $lang;
	}

	public function setSignatureType($signatureType){
		$this->signatureType = $signatureType;
	}

	public function __construct()
	{
		$this->merchantKey = config('iPay88.merchantKey');
		$this->merchantCode = config('iPay88.merchantCode');
	}

	public function generateSignature(String $source) : String
	{	
		return hash('sha256', $source);
	}
}