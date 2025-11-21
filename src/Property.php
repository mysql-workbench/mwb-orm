<?php

namespace Mwb\Orm;

use \Mwb\Grt\Db\Column;

use \Mwb\Orm\NameingAbstract;
use \Mwb\Orm\Type;

class Property
{
	public Entity $owner;
	public Column $dbColumn;

	public ?string $name = Null;
	public ?Type $type = Null;
	//protected ?array $relations = Null;

	public function __construct(Entity $owner) {
		$this->owner = $owner;
	}
	public function setColumn(Column $dbColumn) {
		$this->dbColumn = $dbColumn;
		return $this;
	}
	public function getColumn() {
		return $this->dbColumn;
	}
	public function setName(string $name) {
		$this->name = $name;
		return $this;
	}
	public function getName() {
		return $this->name;
	}
	public function setType($type) {
		$this->type = $type;
		return $this;
	}
	public function getType() {
		return $this->type;
	}
}

