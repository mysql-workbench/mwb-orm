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
	 * @var array<\Mwb\Orm\Entity> $entities
	 */
	protected ?array $entities = Null;

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

		$this->entities = [];

		// mwb->document->grtXml->
		// mwb->document->grt->
		// mwb->document->workbench->
		// mwb->document->grtElement
		// mwb->document->documentElement
		foreach ($this->mwb->doc->documentElement->physicalModels[0]->catalog->schemata[0]->tables as $table) {
			$entity = new Entity($table);
			$entity->setNameingStrategy($this->nameing);
			$this->entities[] = $entity;
		}

		return $this->entities;
	}
}

