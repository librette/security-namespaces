<?php
namespace Librette\SecurityNamespaces;


/**
 * @author David Matejka
 */
class NamespaceDetector implements INamespaceDetector
{

	/** @var \Librette\SecurityNamespaces\INamespaceUserStorage */
	protected $userStorage;

	/** @var \Librette\SecurityNamespaces\NamespaceManager */
	protected $namespaceManager;


	/**
	 * @param INamespaceUserStorage $userStorage
	 * @param NamespaceManager $namespaceManager
	 */
	public function __construct(INamespaceUserStorage $userStorage, NamespaceManager $namespaceManager)
	{
		$this->userStorage = $userStorage;
		$this->namespaceManager = $namespaceManager;
	}


	public function getNamespace()
	{
		return $this->namespaceManager->getNamespace($this->userStorage->getNamespace());
	}

}
