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

	public static function __callStatic($name, $arguments)
	{
		if ('Load'==$name) {
			$instance = new self();
			$instance->_load(...$arguments);
			return $instance;
		} else {
		}
	}

	public function __call($name, $arguments)
	{
		if ('load'==$name) {
			return $this->_load(...$arguments);
		} else {
		}
	}

	private function _load($filepath)
	{
		if (!realpath($filepath)) {
			throw new \Exception("File not found '$filepath'");
		}
		$this->mwb = MwbDocument::Load($filepath);

		return $this;
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

