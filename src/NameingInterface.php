<?php

namespace Mwb\Orm;

interface NameingInterface
{
	public function entityify(string $name);
	public function propertyify(string $name);
}

