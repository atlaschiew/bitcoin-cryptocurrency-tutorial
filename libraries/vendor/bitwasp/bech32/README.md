bech32
######

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Bit-Wasp/bech32/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Bit-Wasp/bech32/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Bit-Wasp/bech32/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Bit-Wasp/bech32/?branch=master)
[![Build Status](https://travis-ci.org/Bit-Wasp/bech32.svg?branch=master)](https://travis-ci.org/Bit-Wasp/bech32)

This package provides a pure implementation of bech32 and
native segregated witness address encoding.

It will eventually replace the implementation in `bitwasp/bitcoin`
but as yet its primary purpose is serving old codebases which
have yet to upgrade.

Presently supports PHP version 5.6, 7.0-7.2 though
future releases will deprecate 5.6 support. HHVM is
NOT supported.

### Install

    composer require bitwasp/bech32

### Contributing

 All contributions are welcome. Please see [[this page](https://github.com/Bit-Wasp/bech32/blob/master/CONTRIBUTING.md)] before you get started
