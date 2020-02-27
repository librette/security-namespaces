<?php
namespace Librette\SecurityNamespaces;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;

/**
 * @author David Matejka
 */
class SecurityNamespace implements ISecurityNamespace
{

	/** @var IAuthenticator */
	protected $authenticator;

	/** @var IAuthorizator */
	protected $authorizator;

	/** @var IIdentityInitializer */
	protected $identityInitializer;

	/** @var string */
	protected $name;


	/**
	 * @param string $name
	 * @param IAuthenticator $authenticator
	 * @param IAuthorizator $authorizator
	 * @param \Librette\SecurityNamespaces\Identity\IIdentityInitializer $identityInitializer
	 */
	function __construct($name, IAuthenticator $authenticator = NULL, IAuthorizator $authorizator = NULL, IIdentityInitializer $identityInitializer = NULL)
	{
		$this->name = $name;
		$this->authenticator = $authenticator;
		$this->authorizator = $authorizator;
		$this->identityInitializer = $identityInitializer;
	}


	public function getName()
	{
		return $this->name;
	}


	public function getAuthenticator()
	{
		if (!$this->authenticator) {
			throw new InvalidStateException("Authenticator has not been set.");
		}

		return $this->authenticator;
	}


	public function hasAuthenticator()
	{
		return (bool) $this->authenticator;
	}


	public function getAuthorizator()
	{
		if (!$this->authorizator) {
			throw new InvalidStateException("Authorizator has not been set.");
		}

		return $this->authorizator;
	}


	public function hasAuthorizator()
	{
		return (bool) $this->authorizator;
	}


	public function getIdentityInitializer()
	{
		if (!$this->identityInitializer) {
			throw new InvalidStateException("EntityIdentity initializer has not been set.");
		}

		return $this->identityInitializer;
	}


	public function hasIdentityInitializer()
	{
		return (bool) $this->identityInitializer;
	}
}
