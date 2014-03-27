<?php
namespace Librette\SecurityNamespaces;

use Nette\Object;
use Nette\Security\IAuthorizator;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthorizator extends Object implements IAuthorizator
{

	/** @var ISecurityNamespace */
	protected $namespace;


	/**
	 * @param ISecurityNamespace $namespace
	 */
	public function __construct(ISecurityNamespace $namespace)
	{
		$this->namespace = $namespace;
	}


	function isAllowed($role, $resource, $privilege)
	{
		return $this->namespace->getAuthorizator()->isAllowed($role, $resource, $privilege);
	}

}