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
	
	
	var_dump(True);
        //self::assertArrayHasKey('controllers', $config);
    }
}
