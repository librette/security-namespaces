<?php
namespace Librette\SecurityNamespaces;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Nette\Object;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;

/**
 * @author David Matejka
 */
class SecurityNamespace extends Object
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


	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return IAuthenticator
	 * @throws InvalidStateException
	 */
	public function getAuthenticator()
	{
		if(!$this->authenticator) {
			throw new InvalidStateException("Authenticator has not been set.");
		}

		return $this->authenticator;
	}


	/**
	 * @return bool
	 */
	public function hasAuthenticator()
	{
		return (bool) $this->authenticator;
	}


	/**
	 * @return IAuthorizator
	 * @throws InvalidStateException
	 */
	public function getAuthorizator()
	{
		if (!$this->authorizator) {
			throw new InvalidStateException("Authorizator has not been set.");
		}

		return $this->authorizator;
	}


	/**
	 * @return bool
	 */
	public function hasAuthorizator()
	{
		return (bool) $this->authorizator;
	}


	/**
	 * @throws InvalidStateException
	 * @return IIdentityInitializer
	 */
	public function getIdentityInitializer()
	{
		if(!$this->identityInitializer) {
			throw new InvalidStateException("EntityIdentity initializer has not been set.");
		}

		return $this->identityInitializer;
	}


	/**
	 * @return bool
	 */
	public function hasIdentityInitializer()
	{
		return (bool) $this->identityInitializer;
	}
}