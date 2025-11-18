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
		/*

    $this->table->foreignKeys = 
                  <value _ptr_="0x55a0c46527a0" type="list" content-type="object" content-struct-name="db.mysql.ForeignKey" key="foreignKeys">
                    <value type="object" struct-name="db.mysql.ForeignKey" id="a9869086-bfc1-11ef-98ea-0242384af379" struct-checksum="0x70a8fc40">
                      <link type="object" struct-name="db.mysql.Table" key="referencedTable">42948398-bfc0-11ef-98ea-0242384af379</link>
                      <value _ptr_="0x55a0c4654a20" type="list" content-type="object" content-struct-name="db.Column" key="columns">
                        <link type="object">e0cd9324-bfc0-11ef-98ea-0242384af379</link>
                      </value>
                      <value _ptr_="0x55a0c4654a90" type="dict" key="customData"/>
                      <value type="int" key="deferability">0</value>
                      <value type="string" key="deleteRule">NO ACTION</value>
                      <link type="object" struct-name="db.Index" key="index">a9869089-bfc1-11ef-98ea-0242384af379</link>
                      <value type="int" key="mandatory">1</value>
                      <value type="int" key="many">1</value>
                      <value type="int" key="modelOnly">0</value>
                      <link type="object" struct-name="db.Table" key="owner">a4406cf6-bfc0-11ef-98ea-0242384af379</link>
                      <value _ptr_="0x55a0c4654b20" type="list" content-type="object" content-struct-name="db.Column" key="referencedColumns">
                        <link type="object">5f6ea156-bfc0-11ef-98ea-0242384af379</link>
                      </value>
                      <value type="int" key="referencedMandatory">1</value>
                      <value type="string" key="updateRule">NO ACTION</value>
                      <value type="string" key="comment"></value>
                      <value type="string" key="name">fk_companies_associates_companies</value>
                      <value type="string" key="oldName">fk_companies_associates_companies</value>
                    </value>

		*/
	}
}

