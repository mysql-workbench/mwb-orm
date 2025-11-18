<?php

namespace Mwb\Orm;

use \Mwb\Grt\Db\Table;

use \Mwb\Orm\NameingAbstract;

class Entity
{
	public Table $table;
	protected NameingAbstract $nameing;
	protected ?string $name = Null;
	protected ?array $properties = Null;

	public function __construct(Table $table) {
		$this->table = $table;
	}
	public function setNameingStrategy(NameingAbstract $nameing) {
		$this->nameing = $nameing;
	}
	public function getName() {
		if (!isset($this->name)) {
			$this->name = $this->nameing->entityify($this->table->name);
		}
		return $this->name;
	}
	public function getProperties() {
		if (isset($this->properties)) {
			return $this->properties;
		}

		$this->properties = [];
		foreach ($this->table->columns as $column) {
			$property = new Property($column);
			$property->setNameingStrategy($this->nameing);
			$this->properties[] = $property;
		}
		return $this->properties;
	}
	public function getRelations() {
	}
}

