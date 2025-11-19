<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Mwb\Orm\Document;

$doc = Document::load(__DIR__.'/../data/sakila_full.mwb');
//$doc = Document::load(__DIR__.'/../data/pk_composite.mwb');


foreach ($doc->getEntities() as $entity) {
	$entity->getRelations();
}

foreach ($doc->getEntities() as $entity) {
	echo $entity->getName() . PHP_EOL;
	foreach($entity->getRelations() as $relation) {
		if (       'OneToMany'==$relation->type) {
			echo '    --< '.$relation->type.' '.$relation->referencedEntity->getName() . PHP_EOL;
		} else if ('ManyToOne'==$relation->type) {
			echo '    >-- '.$relation->type.' '.$relation->referencedEntity->getName() . PHP_EOL;
		} else if ('OneToOne'==$relation->type) {
			echo '    --- '.$relation->type.' '.$relation->referencedEntity->getName() . PHP_EOL;
		} else {
			echo '    >-< '.$relation->type.' '.$relation->referencedEntity->getName() . PHP_EOL;
		}
	}
}


// FIX foreignKey->columns check if not null
