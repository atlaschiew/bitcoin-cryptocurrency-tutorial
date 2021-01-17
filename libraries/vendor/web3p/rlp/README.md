# rlp
Recursive Length Prefix Encoding in PHP.

[![Build Status](https://travis-ci.org/web3p/rlp.svg?branch=master)](https://travis-ci.org/web3p/rlp)
[![codecov](https://codecov.io/gh/web3p/rlp/branch/master/graph/badge.svg)](https://codecov.io/gh/web3p/rlp)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/web3p/rlp/blob/master/LICENSE)

# Install

Set minimum stability to dev
```
composer require web3p/rlp
```

# Usage

RLP encode:
```php
use Web3p\RLP\RLP;

$rlp = new RLP;
$encodedBuffer = $rlp->encode(['dog']);

// to string, encoding: ascii utf8 hex
$encodedBuffer->toString($encoding);
```

RLP decode:
```php
use Web3p\RLP\RLP;

$rlp = new RLP;
$encodedBuffer = $rlp->encode(['dog']);

// only accept 0x prefixed hex string
$decodedArray = $rlp->decode('0x' . $encodedBuffer->toString('hex'));

// show dog
echo $decodedArray[0]->toString('utf8');
```

# API

### Web3p\RLP\RLP

#### encode

Returns recursive length prefix encoding of given data.

`encode(mixed $inputs)`

Mixed inputs - array of string, integer or numeric string.

###### Example

* Encode array of string.

```php
use Web3p\RLP\RLP;

$rlp = new RLP;
$encodedBuffer = $rlp->encode(['web3p', 'ethereum', 'solidity']);
$encodedString = $enccodedBuffer->toString('hex');

```

#### decode

Returns array recursive length prefix decoding of given data.

`decode(string $input)`

String input - recursive length prefix encoded string.

###### Example

* Decode recursive length prefix encoded string.

```php
use Web3p\RLP\RLP;

$rlp = new RLP;
$encodedBuffer = $rlp->encode(['web3p', 'ethereum', 'solidity']);
$encodedString = $enccodedBuffer->toString('hex');
$decodedArray = $rlp->decode('0x' . $encodedString);

// echo web3p
echo $decodedArray[0]->toString('utf8');

// echo ethereum
echo $decodedArray[1]->toString('utf8');

// echo solidity
echo $decodedArray[2]->toString('utf8');
```

# License
MIT
