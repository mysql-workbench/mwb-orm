<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Mwb\Orm\Document;

$doc = Document::load(__DIR__.'/../data/sakila_full.mwb');

foreach ($doc->getEntities() as $entity) {
	echo $entity->getName() . ' (' . $entity->table->name . ')' . PHP_EOL;
	foreach ($entity->getProperties() as $property) {
	echo '    + ' . $property->getName() . ' (' . $property->column->name . ')' . PHP_EOL;
	echo '        + ' . $property->getType()->getName() . ' (' . $property->getType()->simpleDataType->name .')'. PHP_EOL;
	}

}


