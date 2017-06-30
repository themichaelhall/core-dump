# Debug

[![Build Status](https://travis-ci.org/themichaelhall/debug.svg?branch=master)](https://travis-ci.org/themichaelhall/debug)
[![codecov.io](https://codecov.io/gh/themichaelhall/debug/coverage.svg?branch=master)](https://codecov.io/gh/themichaelhall/debug?branch=master)
[![Code Climate](https://codeclimate.com/github/themichaelhall/debug/badges/gpa.svg)](https://codeclimate.com/github/themichaelhall/debug)
[![StyleCI](https://styleci.io/repos/94369062/shield?style=flat)](https://styleci.io/repos/94369062)
[![License](https://poser.pugx.org/michaelhall/debug/license)](https://packagist.org/packages/michaelhall/debug)
[![Latest Stable Version](https://poser.pugx.org/michaelhall/debug/v/stable)](https://packagist.org/packages/michaelhall/debug)
[![Total Downloads](https://poser.pugx.org/michaelhall/debug/downloads)](https://packagist.org/packages/michaelhall/debug)

Debugging tools for PHP

## Requirements

- PHP >= 7.1

## Install with composer

``` bash
$ composer require "michaelhall/debug:~1.0"
```

## Basic usage

### CoreDump class

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// Creates a core dump and add some extra content.
// Globals like $_SERVER, $_GET, $_POST etc. are added automatically.
$coreDump = new \MichaelHall\Debug\CoreDump();
$coreDump->add('Foo', 'Bar');

// Writes the core dump.
echo $coreDump;

// Saves the core dump with an auto-generated file name in the current directory.
// Also returns the file name.
$coreDump->save();

// As above, but saves the core dump in the /tmp-directory.
$coreDump->save('/tmp');
```

### VarDump class

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$var = [
   1 => 'Foo',
];

// Writes:
// array[1]
// [
//   1 int => "Foo" string[3]
// ]
\MichaelHall\Debug\VarDump::write($var);

// As above, but instead assigns the result to a string.
$result = \MichaelHall\Debug\VarDump::toString($var);
```

## License

MIT