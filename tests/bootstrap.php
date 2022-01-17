<?php

use Composer\Autoload\ClassLoader;

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('UTC');

/** @var ClassLoader $autoloader */
$autoloader = require __DIR__.'/../vendor/autoload.php';

$autoloader->addPsr4('Sberbank\Tests\\', __DIR__);