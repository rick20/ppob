# PPOB Package for Laravel 5

The purpose of this package is to allow your website to purchase 
many prepaid digital products like Token PLN, Pulsa, Paket Data and more in Indonesia.

Right now, the following providers are supported:
- MobilePulsa ([https://mobilepulsa.com](https://mobilepulsa.com))
- PortalPulsa ([https://portalpulsa.com](https://portalpulsa.com))
- Tripay ([https://tripay.co.id](https://tripay.co.id))
- IndoH2H ([https://indoh2h.com](https://indoh2h.com))


## Installation

To get started with PPOB, run this command or add the package to your `composer.json`

    composer require rick20/ppob
    

## Configuration

The PPOB package use Laravel autodiscovery so it will be loaded automatically.
Copy the `config` file with the following command:
`php artisan vendor:publish --vendor="Rick20\PPOB\PPOBServiceProvider"`

Finally add your provider's account in the `.env` file:
```
MOBILEPULSA_USERNAME=<your-phone>
MOBILEPULSA_APIKEY=<your-api-key>

PORTALPULSA_USERNAME=<your-username>
PORTALPULSA_APIKEY=<your-apikey>
PORTALPULSA_SECRET=<your-secret>

TRIPAY_APIKEY=<your-apikey>
TRIPAY_PIN=<your-pin>

INDOH2H_USERNAME=<your-username>
INDOH2H_APIKEY=<your-apikey>
```

To add more accounts in a single provider, add those accounts in `config/ppob.php`

```php
...
'accounts' => [
    'account-A' => [
        'provider' => 'mobile-pulsa',
        'username' => 'usernameA',
        'apikey' => 'apikeyA'
    ],
    'account-B' => [
        'provider' => 'mobile-pulsa',
        'username' => 'usernameB',
        'apikey' => 'apikeyB'
    ],
]
...
```


## How To Use

After all sets, use the PPOB as follows:
```php

use Rick20\PPOB\Products\Pulsa;
use Rick20\PPOB\Products\TokenPLN;
use Rick20\PPOB\Products\GenericProduct;

// Topup Pulsa
$status = PPOB::topup(new Pulsa('082112345678', 50000), 'ref123');

// Check your deposit balance 
$balance = PPOB::balance();

// Check status of a transaction
$status = PPOB::status('ref123');

// Use another account
$status = PPOB::account('account-portalpulsa')->topup(new TokenPLN('no-meter', 'no-hp', 100000), 'ref456');

// Purchase other products
$status = PPOB::account('account-tripay')->topup(new GenericProduct('subscriber-id', 'no-hp', 'product-code'), 'ref789');

```

## Bugs & Improvements

Feel free to report me any bug you found. I would be also very happy to receive pull requests for improvements and for other PPOB provider as well.
If you find this package helpful, a donation would be awesome! =)
