<?php

require_once 'vendor/symfony/class-loader/ClassLoader.php';

use Symfony\Component\ClassLoader\ClassLoader;

$loader = new ClassLoader();

// to enable searching the include path (eg. for PEAR packages)
$loader->setUseIncludePath(true);

$loader->addPrefix('Transformer', 'src/');

$loader->register();
