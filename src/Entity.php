<?php

namespace Mwb\Orm;

use \Mwb\Grt\Db\Table;

use \Mwb\Orm\NameingAbstract;
use \Mwb\Orm\Document;
use \Mwb\Orm\Relation;
use \Mwb\Orm\Property;

class Entity
{
	public Document $owner;
	protected NameingAbstract $nameing;
	public Table $table;
	private ?array $primaryKey = Null;
	private ?array $foreignPrimary = Null;
	private ?array $foreignPrimaryUnique = Null;

	protected ?string $name = Null;
	/*
	 * @var \ArrayObject<\Mwb\Orm\Property> $properties
	 */
	protected ?\ArrayObject $properties = Null;
	/*
	 * @var \ArrayObject<\Mwb\Orm\Relation> $relations
	 */
	protected \ArrayObject $relations;
	private bool $relationLoaded = False;

	public function __construct(Document $owner) {
		$this->owner = $owner;
		$this->relations = new \ArrayObject();
	}
	public function setTable(Table $table) {
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
	//public function getProperties() {
	//public function getProperties('PK') {
	//public function getProperties('-PK') {
	//public function getProperties('FK') {
	//public function getProperties('-FK') {
	//public function getProperties('PK-FK') {
	//public function getProperties('FK-PK') {
	//public function getProperties('FK+PK') {
	//public function getProperties('-PK-FK') {
	public function getProperties() {
		if (isset($this->properties)) {
			return $this->properties;
		}

		$this->properties = new \ArrayObject();
		foreach ($this->table->columns as $column) {
			$property = new Property($this);
			$property->setColumn($column);
			$property->setNameingStrategy($this->nameing);
			$this->properties[$property->getName()] = $property;
		}
		return $this->properties;
	}
	public function addRelation(Relation $relation) {
		$this->relations[] = $relation;
	}
	public function getRelations() {
		if ($this->relationLoaded) {
			return $this->relations;
		}

		$entities = $this->owner->getEntities();

		$referencingTable = $this->table;

		$referencingPrimaryKey = [];
		foreach($referencingTable->indices as $index) {
			if (!$index->isPrimary) {
				continue;
			}
			foreach($index->columns as $ndexColumn) {
				$referencingPrimaryKey[] = $ndexColumn->name;
			}
		}

		foreach ($referencingTable->foreignKeys as $foreignKey) {
			$referencingForeignKey = [];
			
			foreach($foreignKey->columns as $column) {
				if ($column) {
					$referencingForeignKey[] = $column->name;
				}
			}

			$type = Null;
			if (!array_diff($referencingPrimaryKey, $referencingForeignKey)) {
				$type = Relation::ONE_TO_ONE;
				$relation = new Relation($type);
			} else {
				$type = Relation::MANY_TO_ONE;
				$relation = new Relation($type);
			}

			$referencedEntity = $entities[$this->nameing->entityify($foreignKey->referencedTable->name)];

			$relation->setReferencedEntity($referencedEntity);
			$relation->setReferencingEntity($this);
			$this->addRelation($relation);

			$relationReversed = Null;	
			if (Relation::ONE_TO_ONE == $type) 
				$relationReversed = new Relation(Relation::ONE_TO_ONE);
			else
				$relationReversed = new Relation(Relation::ONE_TO_MANY);

			$relationReversed->setReferencedEntity($this);
			$relationReversed->setReferencingEntity($referencedEntity);
			$referencedEntity->addRelation($relationReversed);
		}

		$this->relationLoaded = True;
		return $this->relations;
	}
}

