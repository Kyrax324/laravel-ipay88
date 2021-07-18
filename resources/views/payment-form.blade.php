<p>Please wait while we redirect you to payment gateway.</p>

<form id='autosubmit' action='{{ $requestUrl }}' method='POST'>
	<div
		><input type='hidden' name='MerchantCode' value="{{ $payload['MerchantCode'] }}">
	</div>
	<div
		><input type='hidden' name='PaymentId' value="{{ $payload['PaymentId'] }}">
	</div>
	<div
		><input type='hidden' name='RefNo' value="{{ $payload['RefNo'] }}">
	</div>
	<div
		><input type='hidden' name='Amount' value="{{ $payload['Amount'] }}">
	</div>
	<div
		><input type='hidden' name='Currency' value="{{ $payload['Currency'] }}">
	</div>
	<div
		><input type='hidden' name='ProdDesc' value="{{ $payload['ProdDesc'] }}">
	</div>
	<div
		><input type='hidden' name='UserName' value="{{ $payload['UserName'] }}">
	</div>
	<div
		><input type='hidden' name='UserEmail' value="{{ $payload['UserEmail'] }}">
	</div>
	<div
		><input type='hidden' name='UserContact' value="{{ $payload['UserContact'] }}">
	</div>
	<div
		><input type='hidden' name='Remark' value="{{ $payload['Remark'] }}">
	</div>
	<div
		><input type='hidden' name='Lang' value="{{ $payload['Lang'] }}">
	</div>
	<div
		><input type='hidden' name='SignatureType' value="{{ $payload['SignatureType'] }}">
	</div>
	<div
		><input type='hidden' name='Signature' value="{{ $payload['Signature'] }}">
	</div>
	<div
		><input type='hidden' name='ResponseURL' value="{{ $payload['ResponseURL'] }}">
	</div>
	<div
		><input type='hidden' name='BackendURL' value="{{ $payload['BackendURL'] }}">
	</div>
</form>

<script type='text/javascript'>
	window.onload = function(){
		document.getElementById('autosubmit').submit();
	};
</script>