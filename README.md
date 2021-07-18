# Laravel IPay88

IPay88 Payment Gateway Integration for Laravel Application.

## Installation

```bash
composer require kyrax324/laravel-ipay88
```

## Configuration

Publish the config file & setup the `merchantKey` and `merchantCode`

```bash
php artisan vendor:publish --provider="IPay88\IPay88ServiceProvider" --tag=config
```

## Views (Optional)

If you wish to modify the payment form, you may publish the views

```bash
php artisan vendor:publish --provider="IPay88\IPay88ServiceProvider" --tag=views
```

## Usage

According to IPay88 documentation, each payment order will undergoes the following steps:

1. Prepare & Submit Request to IPay88 Server
2. Handle Response from IPay88 Server
	- Response (set from `responseURL`)
	- Backend Post (set from `backendURL`)
3. Requery to check payment status (If needed)

### 1. Prepare & Submit Request to IPay88 Server

#### `Ipay88\Request\RequestBuilder`

- create payment request and return view

```php
use Ipay88\Request\RequestBuilder as IPay88RequestBuilder;

$builder = new IPay88RequestBuilder();
$builder->setRefNo(1);
$builder->setAmount(1);
$builder->setCurrency('MYR');
$builder->setProdDesc('Sample Prod Desc');
$builder->setUserName('Sample User Name');
$builder->setUserEmail('Sample User Email');
$builder->setUserContact('Sample User Contact');
$builder->setResponseURL("http://sample.com/response_url");
$builder->setBackendURL("http://sample.com/backend_url");

return $builder->loadPaymentFormView();
```
### 2. Handle Response from IPay88 Server

#### `Ipay88\Request\Response`

##### A. Response (set from responseURL)

```php
use Ipay88\Responses\Response as IPay88Response;

$response = new IPay88Response($request);

// logic to check if order has been updated before

if($response->isSuccess()){
	// update order to PAID
}else{
	// update order to FAIL
}
```

##### B. Backend Post (set from backendURL)

>   Backend post will be called simultaneously with responseURL (if payment is success)
>
>   IPay88 Server will re-try to call up to 3 times on different interval if no ‘RECEIVEOK’ acknowledgement detected

```php
use Ipay88\Responses\Response as IPay88Response;

$response = new IPay88Response($request);

// logic to check if order has been updated before

if($response->isSuccess()){
	// update order to PAID
 	return "RECEIVEOK";
}else{
	// update order to FAIL
}
```

### 3. Requery to check payment status (If needed)

#### `Ipay88\Request\RequeryBuilder`

```php
use Ipay88\Request\RequeryBuilder as IPay88RequeryBuilder;

$builder = new IPay88RequeryBuilder();
$builder->setRefNo(1);
$builder->setAmount(1);

if($builder->isSuccess()){
	// update order to PAID
}else{
	// update order to FAIL
}
```

## FAQ

For more information, kindly refer to [IPay88 Integration FAQ](https://docs.google.com/document/d/13hYO2RstXHgJCsWBq36N1x3io3tyOZY_6S_kuaIjdjw/edit)

## Issues

If you found any issue, please [open a new issue](https://github.com/Kyrax324/laravel-ipay88/issues)