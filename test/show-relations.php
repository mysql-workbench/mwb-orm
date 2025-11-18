<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Mwb\Orm\Document;

$doc = Document::load(__DIR__.'/../data/sakila_full.mwb');

echo 'Hello World !' . count($doc->getEntities()) . PHP_EOL;

