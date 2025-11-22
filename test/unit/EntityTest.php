<?php

declare(strict_types=1);

namespace Mwb\Orm\Test;

use Mwb\Orm\Document;
use Mwb\Orm\Entity;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Application\Module;
 */
class EntityTest extends TestCase
{
    public function testGetTable(): void
    {
	$owner = new Document();
	$entity = new Entity($owner);
	
	
        self::assertTrue($owner === $entity->owner);
	/*
        self::assertNull($entity->name);
        self::assertNull($entity->dbTable);
        self::assertNull($entity->properties);
	*/
    }

    /*
     * 
     */
    public function testGetProperties(): void
    {
        $filepath = realpath(dirname(__FILE__, 3).'/vendor/mysql-workbench/mwb-dom/data/sakila_full.mwb');

        $mwbOrm = \Mwb\Orm\Loader::Load($filepath);
        $entity = $mwbOrm->getEntities()['City'];

        self::assertTrue(1 === count($entity->getPKcolumns()) );
        self::assertTrue(1 === count($entity->getFKcolumns()) );
    }
}

