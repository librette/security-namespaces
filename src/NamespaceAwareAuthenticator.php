<?php
namespace Librette\SecurityNamespaces;

use Nette\Object;
use Nette\Security\IAuthenticator;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthenticator extends Object implements IAuthenticator
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


	function authenticate(array $credentials)
	{
		return $this->namespace->getAuthenticator()->authenticate($credentials);
	}

}