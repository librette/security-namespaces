<?php
namespace Librette\SecurityNamespaces;


class NamespaceManager
{

	/** @var SecurityNamespace[] */
	protected $namespaces;

	/** @var INamespaceAccessor[] */
	protected $accessors;


	public function addNamespace(SecurityNamespace $namespace)
	{
		$this->namespaces[$namespace->getName()] = $namespace;
	}


	public function addNamespaceAccessor($name, INamespaceAccessor $accessor)
	{
		$this->accessors[$name] = $accessor;
	}


	public function getNamespace($name)
	{
		if (!isset($this->namespaces[$name])) {
			if (isset($this->accessors[$name])) {
				$this->namespaces[$name] = $this->accessors[$name]->get();
			} else {
				throw new InvalidStateException("Security namespace $name not found");
			}
		}

		return $this->namespaces[$name];
	}

}
