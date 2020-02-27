<?php
namespace Librette\SecurityNamespaces;

use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthenticator implements IAuthenticator
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


	function authenticate(array $credentials): IIdentity
	{
		return $this->namespace->getAuthenticator()->authenticate($credentials);
	}

}
