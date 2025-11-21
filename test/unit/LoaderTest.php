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

    }
}

