<?php
namespace Librette\SecurityNamespaces;

use Nette\Object;
use Nette\Security\IAuthorizator;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthorizator extends Object implements IAuthorizator
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


	function isAllowed($role, $resource, $privilege)
	{
		$securityNamespace = $this->namespaceDetector->getNamespace();

		return $securityNamespace->getAuthorizator()->isAllowed($role, $resource, $privilege);
	}

}