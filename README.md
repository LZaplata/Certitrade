# Certitrade
This is small Nette Framework wrapper for Certitrade gateway.

## Installation
The easiest way to install library is via Composer.

````sh
$ composer require lzaplata/certitrade: dev-master
````
or edit `composer.json` in your project

````json
"require": {
        "lzaplata/certitrade": "dev-master"
}
````

You have to register the library as extension in `config.neon` file.

````neon
extensions:
        payu: LZaplata\Certitrade\DI\Extension
````

Now you can set parameters...

````neon
certitrade:
        merchantId      : *
        apiKey          : *
        sandbox         : true
        language        : en        // must be 2 digits language code
        currency        : SEK       // must be 3 digits uppercase currency code
````

...and autowire library to presenter

````php
use LZaplata\Certitrade\Service;

/** @var Service @inject */
public $certitrade;
````
## Usage
### Before payment
In first step you must create new payment.

````php
$payment = $this->certitrade->createOrder([
        "description" => $description,           
        "amount" => $price,                         // order price in lowest currency unit (1 CZK = 100)
        "reference" => $id,                         // eshop unique id
        "return_url" => $returnUrl,                 // return url from gateway (no matter of payment result)
        "callback_url" => $callbackUrl,             // url to report back via POST call while payment is under way
]);
````

Second step decides if creating order is successful...

````php
try {
        $response = $this->certitrade->pay($payment);
} catch (\Exception $e) {
        print $e->getMessage();
}
````

...before redirecting to gateway you can get Certitrade ID and merge it with your order

````php
$certitradeId = $response->id;

// updates order
$this->updateOrder($certitradeId);

````

...and finally you can redirect to gateway.

````php
$this->sendResponse($response);
````

### After payment
You can get payment via Certitrade ID...

````php
$payment = $this->certitrade->getPayment($certitradeId);
````

...end decide if payment has been payed.

````php
if ($this->certitrade->isPaid($payment)) {
    // do something
} else {
    // otherwise do something else
}
````