<?php
namespace Librette\SecurityNamespaces;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Nette\Http;
use Nette\Object;
use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;

/**
 * @author David Matejka
 */
class UserStorage extends Object implements INamespaceUserStorage
{

	/** @var IIdentityInitializer */
	protected $identityInitializer;

	/** @var \Nette\Security\IUserStorage|INamespaceUserStorage */
	protected $innerUserStorage;

	/** @var string fallback */
	protected $namespace;


	/**
	 * @param \Nette\Security\IUserStorage $userStorage
	 * @param IIdentityInitializer $identityInitializer
	 */
	public function __construct(IUserStorage $userStorage, IIdentityInitializer $identityInitializer = NULL)
	{
		$this->innerUserStorage = $userStorage;
		$this->identityInitializer = $identityInitializer;
	}


	public function getNamespace()
	{
		if ($this->innerUserStorage instanceof INamespaceUserStorage) {
			return $this->innerUserStorage->getNamespace();
		}

		return $this->namespace;
	}


	public function setNamespace($namespace)
	{
		if ($this->innerUserStorage instanceof INamespaceUserStorage) {
			$this->innerUserStorage->setNamespace($namespace);
		} else {
			$this->namespace = $namespace;
		}

		return $this;
	}


	function setAuthenticated($state)
	{
		$this->innerUserStorage->setAuthenticated($state);

		return $this;
	}


	function isAuthenticated()
	{
		return $this->innerUserStorage->isAuthenticated();
	}


	function setIdentity(IIdentity $identity = NULL)
	{
		$this->innerUserStorage->setIdentity($identity);
	}


	function setExpiration($time, $flags = 0)
	{
		$this->innerUserStorage->setExpiration($time, $flags);

		return $this;
	}


	function getLogoutReason()
	{
		return $this->innerUserStorage->getLogoutReason();
	}


	/**
	 * @return IIdentity|NULL
	 */
	public function getIdentity()
	{
		$identity = $this->innerUserStorage->getIdentity();
		if ($identity && $this->identityInitializer) {
			$identity = $this->identityInitializer->initialize($identity);
		}

		return $identity;
	}

}