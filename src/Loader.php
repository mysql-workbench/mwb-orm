<?php

declare(strict_types=1);

namespace Mwb\Orm;

use Mwb\Orm\Document;
use Mwb\Orm\Entity;
use Mwb\Orm\Property;
use Mwb\Orm\Type;

class Loader {
	public ?Document $document = Null;

	function loadEntityPropertyType($property) {
		/*
                    $this->column =
                    <value type="object" struct-name="db.mysql.Column" id="5f6ea156-bfc0-11ef-98ea-0242384af379" struct-checksum="0xba88e21c">
                      <value type="int" key="autoIncrement">1</value>
                      <value type="string" key="expression"></value>
                      <value type="int" key="generated">0</value>
                      <value type="string" key="generatedStorage"></value>
                      <value type="string" key="characterSetName"></value>
                      <value _ptr_="0x55a0c464e580" type="list" content-type="object" content-struct-name="db.CheckConstraint" key="checks"/>
                      <value type="string" key="collationName"></value>
                      <value type="string" key="datatypeExplicitParams"></value>
                      <value type="string" key="defaultValue"></value>
                      <value type="int" key="defaultValueIsNull">0</value>
                      <value _ptr_="0x55a0c464e5f0" type="list" content-type="string" key="flags"/>
                      <value type="int" key="isNotNull">1</value>
                      <value type="int" key="length">-1</value>
                      <value type="int" key="precision">-1</value>
                      <value type="int" key="scale">-1</value>
                      <link type="object" struct-name="db.SimpleDatatype" key="simpleType">com.mysql.rdbms.mysql.datatype.int</link>
                      <value type="string" key="comment"></value>
                      <value type="string" key="name">id</value>
                      <value type="string" key="oldName">id</value>
                      <link type="object" struct-name="GrtObject" key="owner">42948398-bfc0-11ef-98ea-0242384af379</link>
                    </value>
		*/
		$type = Null;
		if (isset($property->dbColumn->userType)) {
			$type = new Type($property);
			$type->setDataType($property->dbColumn->userType);
		} else {
			$type = new Type($property);
			$type->setDataType($property->dbColumn->simpleType);
		}
		return $type;
	}

	function loadEntityProperties($entity) {
		$properties = new \ArrayObject();

		foreach ($entity->dbTable->columns as $column) {
			$property = new Property($entity);
			$property->setColumn($column);
			$property->setName($this->document->getNameing()->propertyify($column->name));
			$property->setType( $this->loadEntityPropertyType($property) );
			$properties[$property->getName()] = $property;
		}
		return $properties;
	}

	function loadEntities() {
		$entities = new \ArrayObject();
		
		foreach ($this->document->getMwbDocument()->doc->documentElement->physicalModels[0]->catalog->schemata[0]->tables as $name => $dbTable) {
			$entity = new Entity($this->document);
			//$entity->setNameingStrategy($loader->document->nameing);
			$entity->setDbTable($dbTable);
			$entity->setName($this->document->getNameing()->entityify($dbTable->name));
			$entities[$entity->getName()] = $entity;
			$this->loadEntityProperties($entity);
		}

		return $entities;
	}

	static public function Load(string $filepath)
	{
		$loader = new self();
		$loader->document = \Mwb\Orm\Document::Load($filepath);

		$loader->document->setEntities($loader->loadEntities());

		return $loader->document;
	}
}


