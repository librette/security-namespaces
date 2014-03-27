<?php
namespace Librette\SecurityNamespaces\Identity;

use Librette\SecurityNamespaces\INamespaceDetector;
use Nette\Object;
use Nette\Security\IIdentity;

/**
 * @author David Matejka
 */
class NamespaceAwareIdentityInitializer extends Object implements IIdentityInitializer
{

	/** @var INamespaceDetector */
	protected $namespaceDetector;


	/**
	 * @param INamespaceDetector $namespaceDetector
	 */
	public function __construct(INamespaceDetector $namespaceDetector)
	{
		$this->namespaceDetector = $namespaceDetector;
	}


	public function initialize(IIdentity $identity)
	{
		return $this->namespaceDetector->getNamespace()->getIdentityInitializer()->initialize($identity);
	}

}