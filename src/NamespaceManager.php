<?php
namespace Librette\SecurityNamespaces;

use Nette\Object;

class NamespaceManager extends Object
{

	/** @var SecurityNamespace[] */
	protected $namespaces;


	public function addNamespace(SecurityNamespace $namespace)
	{
		$this->namespaces[$namespace->getName()] = $namespace;
	}


	public function getNamespace($name)
	{
		if (!isset($this->namespaces[$name])) {
			throw new InvalidStateException("Security namespace $name not found");
		}

		return $this->namespaces[$name];
	}

}
