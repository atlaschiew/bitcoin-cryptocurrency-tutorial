
# BigInteger wrapper library for PHP

## Information

This library is a common interface for php_gmp and php_bcmath modules. It automatically detects supported modules and uses the best of them (gmp>bcmath). Gmp is a lot faster, but is also missing on many hosting services -- that is why this wrapper has been created. It is used for example in encryption functions of the [PrivMX WebMail](https://privmx.com) software.  

## Installation

You can install this library via Composer:
```
composer require simplito/bigint-wrapper-php
```

## Documentation

If you want to force using a specific implementation, then define constant S_MATH_BIGINTEGER_MODE - set it to "gmp" or "bcmath". If you do not do this, mode of operation and the constant will be set automatically.

If there are no gmp and bcmath modules, an exception will be thrown. If you want to prevent this, then simply define S_MATH_BIGINTEGER_QUIET constant.

All functions of this library are implemented as members of class BigInteger, which is located under BI namespace. Instances of BigInteger are immutable - member functions usually return new instances of the BigInteger class.


### ConvertibleToBi - a placeholder type

To make the below documentation more readable we use the "ConvertibleToBi" type symbol, which in reality can be one of the following types:   
- an instance of the BigInteger class
- an integer
- a decimal string
- a gmp resource or class (only when you are in gmp mode)

If you have a non-decimal string and want to use it -- first you have to convert it to BigInteger class using:
```
new BigInteger($myNonDecimalString, $baseOfMyNonDecimalString)
```

### BI\BigInteger class members

#### construct(ConvertibleToBi $value = 0, int $base = 10)
Creates a new instance of BigInteger. If you pass an invalid value, an exception will be thrown. If $base === true then passed $value will be used without any check and conversion. Supported bases: 2, 10, 16, 256.
- **GMP implementation:** gmp_init + bin2hex for 256 base
- **Bcmath implementation:** custom(bcadd + bcmul)

#### static BigInteger|false createSafe(ConvertibleToBi $value = 0, int $base = 10)
Creates a new BigInteger instance in the same way as constructor, but if there is an error, false will be returned instead of throwing an exception.

#### BigInteger add(ConvertibleToBi $x)
Adds numbers
- **GMP implementation:** gmp_add
- **Bcmath implementation:** bcadd

#### BigInteger sub(ConvertibleToBi $x)
Subtracts numbers
- **GMP implementation:** gmp_sub
- **Bcmath implementation:** bcsub

#### BigInteger mul(ConvertibleToBi $x)
Multiplies numbers
- **GMP implementation:** gmp_mul
- **Bcmath implementation:** bcmul

#### BigInteger div(ConvertibleToBi $x)
Divides numbers
- **GMP implementation:** gmp_div_q
- **Bcmath implementation:** bcdiv

#### BigInteger divR(ConvertibleToBi $x)
Returns a remainder of the division of numbers. The remainder has the sign of the divided number.
- **GMP implementation:** gmp_div_r
- **Bcmath implementation:** bcmod

#### array(BigInteger, BigInteger) divQR(ConvertibleToBi $x)
Divides numbers and returns quotient and remainder. Returns an array(), with the first element being quotient, and the second being remainder.
- **GMP implementation:** gmp_div_qr
- **Bcmath implementation:** div + divR

#### BigInteger mod(ConvertibleToBi $x)
The "division modulo" operation. The result is always non-negative, the sign of divider is ignored.
- **GMP implementation:** gmp_mod
- **Bcmath implementation:** custom (bcmod + bcadd)

#### BigInteger gcd(ConvertibleToBi $x)
Calculates greatest common divisor
- **GMP implementation:** gmp_gcd
- **Bcmath implementation:** custom (bccomp + bcdiv + bcsub + bcmul)

#### BigInteger|false modInverse(ConvertibleToBi $x)
Inverses by modulo, returns false if inversion does not exist.
- **GMP implementation:** gmp_invert
- **Bcmath implementation:** custom (gcd)

#### BigInteger pow(ConvertibleToBi $x)
The power function.
- **GMP implementation:** gmp_pow
- **Bcmath implementation:** bcpow

#### BigInteger powMod(ConvertibleToBi $x, ConvertibleToBi $n)
The modular power function.
- **GMP implementation:** gmp_powm
- **Bcmath implementation:** bcpowmod

#### BigInteger abs()
Returns absolute value.
- **GMP implementation:** gmp_abs
- **Bcmath implementation:** check first character

#### BigInteger neg()
Negates the number
- **GMP implementation:** gmp_neg
- **Bcmath implementation:** check first character

#### BigInteger binaryAnd(ConvertibleToBi $x)
Bitwise AND.
- **GMP implementation:** gmp_and
- **Bcmath implementation:** custom (toBytes + php string and)

#### BigInteger binaryOr(ConvertibleToBi $x)
Bitwise OR
- **GMP implementation:** gmp_or
- **Bcmath implementation:** custom (toBytes + php string or)

#### BigInteger binaryXor(ConvertibleToBi $x)
Bitwise XOR
- **GMP implementation:** gmp_xor
- **Bcmath implementation:** custom (toBytes + php string xor)

#### BigInteger setbit($index, $bitOn = true)
Sets bit at given index
- **GMP implementation:** gmp_setbit
- **Bcmath implementation:** custom (toBits)

#### bool testbit($index)
Tests if a bit at given index is set
- **GMP implementation:** gmp_testbit
- **Bcmath implementation:** custom (toBits)

#### int scan0($start)
Scans for 0, and returns index of first found bit
- **GMP implementation:** gmp_scan0
- **Bcmath implementation:** custom (toBits)

#### int scan1($start)
Scans for 1, and returns index of first found bit
- **GMP implementation:** gmp_scan1
- **Bcmath implementation:** custom (toBits)

#### int cmp(ConvertibleToBi $x)
Compares numbers, returns <0, 0, >0
- **GMP implementation:** gmp_cmp
- **Bcmath implementation:** bccomp

#### bool equals(ConvertibleToBi $x)
Checks if numbers are equal
- **GMP implementation:** gmp_cmp
- **Bcmath implementation:** bccomp

#### int sign()
Sign of number, returns -1, 0, 1
- **GMP implementation:** gmp_sign
- **Bcmath implementation:** check first character

#### int toNumber()
Converts to number (use only with small 32/64bit numbers)
- **GMP implementation:** gmp_intval
- **Bcmath implementation:** intval

#### string toDec()
Converts to decimal string
- **GMP implementation:** gmp_strval
- **Bcmath implementation:** just the value

#### string toHex()
Converts to hex string
- **GMP implementation:** gmp_strval
- **Bcmath implementation:** toBytes + bin2hex

#### string toBytes
Converts to binary string
- **GMP implementation:** gmp_strval + hex2bin
- **Bcmath implementation:** custom (bcmod + bcdiv + bccomp)

#### string toBits()
Converts to bits string (0 and 1 characters)
- **GMP implementation:** gmp_strval
- **Bcmath implementation:** toBytes + decbin

#### string toString(int $base = 10)
Converts to string using given base (supported bases 2-62, 256)
- **GMP implementation:** all above toX functions, and for non standard gmp_strval
- **Bcmath implementation:** all above toX functions, and for non standard bcmod + bcdiv + bccomp
