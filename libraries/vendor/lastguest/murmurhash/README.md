# MurmurHash3

[![Latest Stable Version](https://poser.pugx.org/lastguest/murmurhash/v/stable)](https://packagist.org/packages/lastguest/murmurhash) [![Total Downloads](https://poser.pugx.org/lastguest/murmurhash/downloads)](https://packagist.org/packages/lastguest/murmurhash) [![Latest Unstable Version](https://poser.pugx.org/lastguest/murmurhash/v/unstable)](https://packagist.org/packages/lastguest/murmurhash) [![License](https://poser.pugx.org/lastguest/murmurhash/license)](https://packagist.org/packages/lastguest/murmurhash)

PHP Implementation of MurmurHash3

More information about these algorithms can be found at:

* [MurmurHash Homepage](http://sites.google.com/site/murmurhash/)
* [Wikipedia Entry on MurmurHash](http://en.wikipedia.org/wiki/MurmurHash) 

Porting of the MurmurHash3 JavaScript version created by Gary Court (https://github.com/garycourt/murmurhash-js)

## Installation

Use [composer](https://getcomposer.org/download/) :

```bash
composer require lastguest/murmurhash
```

## Usage

You can retrieve an hash via `hash3` static method of class `Murmur`

```php
<?php
use lastguest\Murmur;

echo Murmur::hash3("Hello World");
// cnd0ue
```

You can pass a precise seed positive integer as second parameter 

```php
<?php
use lastguest\Murmur;

echo Murmur::hash3("Hello World", 1234567);
// qtq2u
```

If you need the integer hash, use the `hash3_int` method

```php
<?php
use lastguest\Murmur;

echo Murmur::hash3_int("Hello World");
// 427197390
```