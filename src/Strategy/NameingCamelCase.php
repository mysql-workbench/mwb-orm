<?php

namespace Mwb\Orm\Strategy;

use \Mwb\Orm\NameingAbstract;

use Laminas\Filter\Word\UnderscoreToCamelCase;

class NameingCamelCase extends NameingAbstract
{
	public $filter;

	public function __construct() {
		$this->filter = new UnderscoreToCamelCase();
	}

	public function entityify(string $code) {
		return $this->filter->filter($code);
	}
}

