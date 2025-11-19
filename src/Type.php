<?php

namespace Mwb\Orm;

use Mwb\Grt\Db\SimpleDatatype;
use Mwb\Grt\Db\UserDatatype;

use Mwb\Orm\Property;

class Type
{
	public Property $owner = Null;
	public null|SimpleDatatype|UserDatatype $dataType = Null;// Grt_Object
	protected ?string $name = Null;

	public function __construct(Property $owner) {
		$this->owner = $owner;
	}
	public function setDataType(null|SimpleDatatype|UserDatatype $dataType) {
		$this->dataType = $dataType;
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

