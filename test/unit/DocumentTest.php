<?php

declare(strict_types=1);

namespace Mwb\Orm\Test;

use Mwb\Orm\Document;
use Mwb\Orm\Entity;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Application\Module;
 */
class DocumentTest extends TestCase
{
    public function testDump(): void
    {
	$owner = Document::Load(__DIR__.'/../../data/sakila_full.mwb');
	
        self::assertTrue($owner instanceof Document);
	
	/*
        self::assertNull($entity->name);
        self::assertNull($entity->dbTable);
        self::assertNull($entity->properties);
	*/
    }
}

