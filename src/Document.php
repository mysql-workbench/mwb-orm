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

	public function __construct() {
		$this->nameing = new NameingSingularize();
	}

	public function __call(string $name, array $arguments) {
		if ($name === 'load') {
		    // Appel de la méthode statique depuis l'instance
		    return self::load(array_pop($arguments), $this);
		}

		//throw new BadMethodCallException("Méthode $name inexistante");
	}

	static function load($filepath, ?Document $instance=Null) {
		if (!realpath($filepath)) {
			throw new \Exception("File not found '$filepath'");
		}
		if ($instance instanceof \Mwb\Orm\Document) {
			$instance->mwb = MwbDocument::load($filepath);
		} else {
			$instance = new self();
			$instance->mwb = MwbDocument::load($filepath);
			return $instance;
		}
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

