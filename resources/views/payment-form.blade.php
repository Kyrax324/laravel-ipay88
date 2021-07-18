<p>Please wait while we redirect you to payment gateway.</p>

<form id='autosubmit' action='{{ $requestUrl }}' method='POST'>
	<div
		><input type='text' name='MerchantCode' value="{{ $payload['MerchantCode'] }}">
	</div>
	<div
		><input type='text' name='PaymentId' value="{{ $payload['PaymentId'] }}">
	</div>
	<div
		><input type='text' name='RefNo' value="{{ $payload['RefNo'] }}">
	</div>
	<div
		><input type='text' name='Amount' value="{{ $payload['Amount'] }}">
	</div>
	<div
		><input type='text' name='Currency' value="{{ $payload['Currency'] }}">
	</div>
	<div
		><input type='text' name='ProdDesc' value="{{ $payload['ProdDesc'] }}">
	</div>
	<div
		><input type='text' name='UserName' value="{{ $payload['UserName'] }}">
	</div>
	<div
		><input type='text' name='UserEmail' value="{{ $payload['UserEmail'] }}">
	</div>
	<div
		><input type='text' name='UserContact' value="{{ $payload['UserContact'] }}">
	</div>
	<div
		><input type='text' name='Remark' value="{{ $payload['Remark'] }}">
	</div>
	<div
		><input type='text' name='Lang' value="{{ $payload['Lang'] }}">
	</div>
	<div
		><input type='text' name='SignatureType' value="{{ $payload['SignatureType'] }}">
	</div>
	<div
		><input type='text' name='Signature' value="{{ $payload['Signature'] }}">
	</div>
	<div
		><input type='text' name='ResponseURL' value="{{ $payload['ResponseURL'] }}">
	</div>
	<div
		><input type='text' name='BackendURL' value="{{ $payload['BackendURL'] }}">
	</div>
</form>

<script type='text/javascript'>
	window.onload = function(){
		document.getElementById('autosubmit').submit();
	};
</script>