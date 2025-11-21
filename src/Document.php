<?php

namespace Mwb\Orm;

use \Mwb\Document as MwbDocument;
use \Mwb\Orm\NameingInterface;
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
	public ?\ArrayObject $entities = Null;

	public function __construct(?NameingInterface $nameing=Null) {
		if ($nameing) {
			$this->setNameing($nameing);
		} else {
			$this->setNameing(new NameingSingularize());
		}
	}
	public function setNameing($nameing) {
		$this->nameing = $nameing;
	}
	public function getNameing() {
		return $this->nameing;
	}

	public function __call(string $name, array $arguments) {
		if ($name === 'load') {
		    // Appel de la méthode statique depuis l'instance
		    return self::load(array_pop($arguments), $this);
		}

		//throw new BadMethodCallException("Méthode $name inexistante");
	}

	static function Load($filepath, ?Document $instance=Null) {
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

	function setEntities($entities) {
		$this->entities = $entities;
		return $this;
	}
	function getEntities() {
		return $this->entities;
	}
	function setMwbDocument($mwbDocument) {
		$this->mwb = $mwbDocument;
		return $this;
	}
	function getMwbDocument() {
		return $this->mwb;
	}
}

