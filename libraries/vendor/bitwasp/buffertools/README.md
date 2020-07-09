# Buffertools

This library provides a `Buffer` and `Parser` class to make dealing with binary data in PHP easier.
`Templates` extend this by offering a read/write interface for larger serialized structures. 

[![Build Status](https://travis-ci.org/Bit-Wasp/buffertools-php.svg?branch=master)](https://travis-ci.org/Bit-Wasp/buffertools-php)
[![Code Coverage](https://scrutinizer-ci.com/g/bit-wasp/buffertools-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bit-wasp/buffertools-php/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Bit-Wasp/buffertools-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Bit-Wasp/buffertools-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/bitwasp/buffertools/v/stable)](https://packagist.org/packages/bitwasp/buffertools)
[![Total Downloads](https://poser.pugx.org/bitwasp/buffertools/downloads)](https://packagist.org/packages/bitwasp/buffertools)
[![License](https://poser.pugx.org/bitwasp/buffertools/license)](https://packagist.org/packages/bitwasp/buffertools)

## Requirements:

 * PHP 7.0+
 * Composer
 * ext-gmp

## Installation

 You can install this library via Composer: `composer require bitwasp/buffertools` 
  
## Examples 
 
 Buffer's are immutable classes to store binary data. 
 Buffer::hex can be used to initialize from hex
 Buffer::int can be used to initialize from a positive decimal integer (int|string)
   
 Buffer's main methods are:
  - getBinary()
  - getHex()
  - getInt()

 Parser will read Buffers. 
 Parser's main methods are: 
  - readBytes()
  - writeBytes()
  - readArray()
  - writeArray()
  
 In most cases, the interface offered by Parser should not be used directly. 
 Instead, Templates expose read/write access to larger serialized structures.
 
 - [Example 1: Using buffer to wrap binary data](./examples/usingBuffer.php) 
 - [Example 2: Using parser to extract binary data](./examples/usingParser.php) 
 - [Example 3: Using templates to read multiple elements from a parser](./examples/usingTemplates.php) 
 - [Example 4: Using templates to read/write structured messages](./examples/usingTemplates2.php) 
  
