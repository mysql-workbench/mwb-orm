<?php

namespace Mwb\Orm;

use \Mwb\Grt\Db\Table;

use \Mwb\Orm\Document;
use \Mwb\Orm\Relation;
use \Mwb\Orm\Property;

class Entity
{
	public Document $owner;
	public ?string $name = Null;
	public ?Table $dbTable = Null;

	/*
	 * @var \ArrayObject<\Mwb\Orm\Property> $properties
	 */
	public ?\ArrayObject $properties = Null;
	/*
	 * @var \ArrayObject<\Mwb\Orm\Relation> $relations
	 */
	public \ArrayObject $relations;
	private ?array $dbPKColumns = Null;
	private ?array $dbFKColumns = Null;

	private ?array $primaryKey = Null;
	private ?array $foreignPrimary = Null;
	private ?array $foreignPrimaryUnique = Null;

	public function __construct(Document $owner) {
		$this->owner = $owner;
		$this->relations = new \ArrayObject();
	}
	public function setDbTable(Table $dbTable) {
		$this->dbTable = $dbTable;
	}
	public function setName(string $entity_name) {
		$this->name = $entity_name;
		return $this;
	}
	public function getName() {
		return $this->name;
	}
	//public function getProperties() {
	//public function getProperties('PK') {
	//public function getProperties('-PK') {
	//public function getProperties('FK') {
	//public function getProperties('-FK') {
	//public function getProperties('PK-FK') {
	//public function getProperties('FK-PK') {
	//public function getProperties('FK+PK') {
	//public function getProperties('-PK-FK') {

	public function setProperties($properties) {
		$this->properties = $properties;
		return $this;
	}
	public function getProperties(?string $filter='') {
		return $this->properties;
	}
	/*
	*/
	public function setPKColumns($dbPKColumns) {
		$this->dbPKColumns = $dbPKColumns;
	}
	public function getPKColumns() {
		return $this->dbPKColumns;
	}
	public function setFKColumns($dbFKColumns) {
		return $this->dbFKColumns = $dbFKColumns;
	}
	public function getFKColumns() {
		return $this->dbFKColumns;
	}

	public function addRelation(Relation $relation) {
		$this->relations[] = $relation;
	}
}

