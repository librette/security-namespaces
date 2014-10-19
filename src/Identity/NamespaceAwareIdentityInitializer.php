<?php
namespace Librette\SecurityNamespaces\Identity;

use Librette\SecurityNamespaces\ISecurityNamespace;
use Nette\Object;
use Nette\Security\IIdentity;

/**
 * @author David Matejka
 */
class NamespaceAwareIdentityInitializer extends Object implements IIdentityInitializer
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


	public function initialize(IIdentity $identity)
	{
		return $this->namespace->getIdentityInitializer()->initialize($identity);
	}

}
