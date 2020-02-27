<?php
namespace Librette\SecurityNamespaces;

use Nette\Security\IAuthorizator;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthorizator implements IAuthorizator
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


	function isAllowed($role, $resource, $privilege): bool
	{
		return $this->namespace->getAuthorizator()->isAllowed($role, $resource, $privilege);
	}

}
