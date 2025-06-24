# CECA HMAC
Implementation of the new encryption algorithm for CECABANK payment gateway

## Installation

Add to composer.json

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:taiwanleaftea/cecahmac.git"
    }
]
```

Run the following commands from your terminal:

```bash
composer require taiwanleaftea/cecahmac
```

## Usage

```
use TLT\Cecahmac\Hmac;

// Create request to sign
$signature = 'request, as described in the documentation';

// Create encryptor
$encryptor = new Hmac(32bytes_encryption_key_from_bank_config);

// Sign the request. The signature is in base64 and ready to POST
$firma = $hmac->makeSignature($signature, operation_number); 
```


