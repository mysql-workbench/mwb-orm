<?php

namespace Mwb\Orm;

class Entity
{
	public $name;

	public function __construct($name) {
		$this->name = $name;
	}
}

