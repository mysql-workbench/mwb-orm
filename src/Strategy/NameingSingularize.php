<?php

namespace Mwb\Orm\Strategy;

use \Mwb\Orm\NameingAbstract;

use \Doctrine\Inflector\InflectorFactory;

class NameingSingularize extends NameingAbstract
{
	public $inflectorFilter;

	public function __construct() {
		$this->inflectorFilter = InflectorFactory::create()->build();
	}

	public function entityify(string $code) {

		$names = explode('_', $code);
		$parts = [];
		foreach($names as $name) {
			$parts[] = $this->inflectorFilter->singularize($name);
		}

		$parts = array_map('ucfirst', $parts);
		$name = implode('', $parts);
		return $name;
	}

	public function propertyify(string $code) {
		$names = explode('_', $code);
		$parts = array_map('ucfirst', $names);
		$name = implode('', $parts);
		$name = lcfirst($name);
		return $name;
	}

}

