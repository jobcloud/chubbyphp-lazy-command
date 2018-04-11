# chubbyphp-lazy-command

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-lazy-command.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-lazy-command)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-lazy-command/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-lazy-command)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-lazy-command/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-lazy-command)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-lazy-command/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-lazy-command/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-lazy-command/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-lazy-command/?branch=master)

## Description

Allow to lazyload commands.

## Requirements

 * php: ~7.0
 * psr/container: ~1.0
 * symfony/console: ~2.3|~3.0|~4.0

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-lazy-command][1].

```sh
composer require chubbyphp/chubbyphp-lazy-command "~1.1"
```

## Usage

```php
<?php

use Chubbyphp\Lazy\LazyCommand;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface as Output;

$container['service'] = function (Input $input, Output $output) {
    // run some lazy logic
};

$command = new LazyCommand(
   $container,
   'service',
   'name',
   [
       new InputArgument('argument'),
   ],
   'description',
   'help'
);

$command->run();
```

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-lazy-command

## Copyright

Dominik Zogg 2016
