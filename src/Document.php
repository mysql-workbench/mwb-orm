<?php

namespace Mwb\Orm;

use \Mwb\Document as MwbDocument;
use \Mwb\Orm\NameingAbstract;
use \Mwb\Orm\Strategy\NameingSingularize;
//use \Mwb\Orm\Strategy\NameingCamelCase;

use \Mwb\Orm\Entity;

class Document
{
	protected ?NameingAbstract $nameing = Null;

	protected ?MwbDocument $mwb = Null;
	/*
	 * @var \ArrayObject<\Mwb\Orm\Entity> $entities
	 */
	protected ?\ArrayObject $entities = Null;

	protected function __construct() {
		$this->nameing = new NameingSingularize();
	}

	static function load($filepath) {
		if (!realpath($filepath)) {
			throw new \Exception("File not found '$filepath'");
		}
		$orm = new self();
		$orm->mwb = MwbDocument::load($filepath);
		return $orm;
	}
	function getEntities() {
		if (isset($this->entities)) {
			return $this->entities;
		}

		$this->entities = new \ArrayObject();

		// mwb->document->grtXml->
		// mwb->document->grt->
		// mwb->document->workbench->
		// mwb->document->grtElement
		// mwb->document->documentElement
		foreach ($this->mwb->doc->documentElement->physicalModels[0]->catalog->schemata[0]->tables as $name => $table) {
			$entity = new Entity($this);
			$entity->setNameingStrategy($this->nameing);
			$entity->setTable($table);
			$this->entities[$entity->getName()] = $entity;
		}

		return $this->entities;
	}
}

