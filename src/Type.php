<?php

namespace Mwb\Orm;

use Mwb\Grt\Db\SimpleDatatype;
//use Mwb\Grt\Db\UserDatatype;

class Type
{
	public ?SimpleDatatype $simpleDataType = Null;
	protected ?string $name = Null;

	public function __construct(?SimpleDatatype $simpleDataType) {
		$this->simpleDataType = $simpleDataType;
		// UserDatatype
	}

	public function getName() {
		if (isset($this->name)) {
			return $this->name;
		}

		//$simpleDatatype = $this->dataType->actualType;

		$this->name = 'mixed';// int|float|string|array|object|null
		return $this->name;
	}

}

