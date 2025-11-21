<?php

declare(strict_types=1);

namespace Mwb\Orm\Test;

use Mwb\Orm\Loader;
use Mwb\Orm\Document;
use Mwb\Orm\Entity;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Application\Module;
 */
class LoaderTest extends TestCase
{
    public function testLoad(): void
    {
	$orm = Loader::Load(__DIR__.'/../../data/sakila_full.mwb');

	//var_dump(count($orm->getEntities()));
        self::assertTrue(16 == count($orm->getEntities()));

	$entityCity = $orm->entities['City'];
        self::assertTrue('City' == $entityCity->name);

	//var_dump( count($entityCity->relations) );
        self::assertTrue(2 == count($entityCity->relations));
	
	//var_dump( $entityCity->relations[0]->type );
        self::assertTrue('OneToMany' == $entityCity->relations[0]->type);

	//var_dump( $entityCity->relations[0]->referencingEntity->name );
        self::assertTrue('City' == $entityCity->relations[0]->referencingEntity->name);
	//var_dump( $entityCity->relations[0]->referencedEntity->name );
        self::assertTrue('Address' == $entityCity->relations[0]->referencedEntity->name);

    }
}

