<?php

namespace Mwb\Orm;

use \Mwb\Grt\Db\Column;

use \Mwb\Orm\NameingAbstract;
use \Mwb\Orm\Type;

class Property
{
	public Entity $owner;
	protected NameingAbstract $nameing;
	public Column $column;

	protected ?string $name = Null;
	protected ?Type $type = Null;
	//protected ?array $relations = Null;

	public function __construct(Entity $owner) {
		$this->owner = $owner;
	}
	public function setColumn(Column $column) {
		$this->column = $column;
	}
	public function setNameingStrategy(NameingAbstract $nameing) {
		$this->nameing = $nameing;
	}
	public function getName() {
		if (isset($this->name)) {
			return $this->name;
		}

		$this->name = $this->nameing->propertyify($this->column->name);
		return $this->name;
	}
	public function getType() {
		if (isset($this->type)) {
			return $this->type;
		}

		/*
    $this->column = <value type="object" struct-name="db.mysql.Column" id="5f6ea156-bfc0-11ef-98ea-0242384af379" struct-checksum="0xba88e21c">
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
		if (isset($this->column->userType)) {
			$this->type = new Type($this);
			$this->type->setDataType($this->column->userType);
		} else {
			$this->type = new Type($this);
			$this->type->setDataType($this->column->simpleType);
		}
		return $this->type;
	}
}

