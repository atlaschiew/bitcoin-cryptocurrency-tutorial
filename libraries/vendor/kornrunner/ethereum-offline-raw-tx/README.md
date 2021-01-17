# php-ethereum-offline-tx [![Build Status](https://travis-ci.org/kornrunner/php-ethereum-offline-raw-tx.svg?branch=master)](https://travis-ci.org/kornrunner/php-ethereum-offline-raw-tx) [![Coverage Status](https://coveralls.io/repos/github/kornrunner/php-ethereum-offline-raw-tx/badge.svg?branch=master)](https://coveralls.io/github/kornrunner/php-ethereum-offline-raw-tx?branch=master)

Pure PHP Ethereum Offline Raw Transaction Signer

Ethereum raw transaction hash offline in PHP

## Installation

```sh
$ composer require kornrunner/ethereum-offline-raw-tx
```

## Usage

```php
use kornrunner\Ethereum\Transaction;

$nonce    = '04';
$gasPrice = '03f5476a00';
$gasLimit = '027f4b';
$to       = '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72';
$value    = '2a45907d1bef7c00';

$privateKey = 'b2f2698dd7343fa5afc96626dee139cb92e58e5d04e855f4c712727bf198e898';

$transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $value);
$transaction->getRaw ($privateKey);
// f86d048503f5476a0083027f4b941a8c8adfbe1c59e8b58cc0d515f07b7225f51c72882a45907d1bef7c00801ba0e68be766b40702e6d9c419f53d5e053c937eda36f0e973074d174027439e2b5da0790df3e4d0294f92d69104454cd96005e21095efd5f2970c2829736ca39195d8
```

With different `chainId`

```php
use kornrunner\Ethereum\Transaction;

$nonce    = '04';
$gasPrice = '03f5476a00';
$gasLimit = '027f4b';
$to       = '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72';
$value    = '2a45907d1bef7c00';
$chainId  = 1;

$privateKey = 'b2f2698dd7343fa5afc96626dee139cb92e58e5d04e855f4c712727bf198e898';

$transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $value);
$transaction->getRaw ($privateKey, $chainId);
// f86d048503f5476a0083027f4b941a8c8adfbe1c59e8b58cc0d515f07b7225f51c72882a45907d1bef7c008025a0db4efcc22a7d9b2cab180ce37f81959412594798cb9af7c419abb6323763cdd5a0631a0c47d27e5b6e3906a419de2d732e290b73ead4172d8598ce4799c13bda69
```

## Crypto

ETH 0x9c7b7a00972121fb843af7af74526d7eb585b171
