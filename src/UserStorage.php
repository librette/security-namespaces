<?php
namespace Librette\SecurityNamespaces;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Nette\Http;
use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;

/**
 * @author David Matejka
 */
class UserStorage implements INamespaceUserStorage
{

	/** @var IIdentityInitializer */
	protected $identityInitializer;

	/** @var \Nette\Security\IUserStorage|INamespaceUserStorage */
	protected $innerUserStorage;

	/** @var string fallback */
	protected $namespace;

	/** @var IIdentity[] */
	protected $initializedIdentities = [];


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
		if ($this->innerUserStorage instanceof INamespaceUserStorage || $this->innerUserStorage instanceof Http\UserStorage) {
			return $this->innerUserStorage->getNamespace();
		}

		return $this->namespace;
	}


	public function setNamespace($namespace)
	{
		if ($this->innerUserStorage instanceof INamespaceUserStorage || $this->innerUserStorage instanceof Http\UserStorage) {
			$this->innerUserStorage->setNamespace($namespace);
		} else {
			$this->namespace = $namespace;
		}

		return $this;
	}


	function setAuthenticated(bool $state)
	{
		$this->innerUserStorage->setAuthenticated($state);

		return $this;
	}


	function isAuthenticated(): bool
	{
		return $this->innerUserStorage->isAuthenticated();
	}


	function setIdentity(IIdentity $identity = NULL)
	{
		$this->innerUserStorage->setIdentity($identity);
	}


	function setExpiration(?string $time, int $flags = 0)
	{
		$this->innerUserStorage->setExpiration($time, $flags);

		return $this;
	}


	function getLogoutReason(): ?int
	{
		return $this->innerUserStorage->getLogoutReason();
	}


	public function getIdentity(): ?IIdentity
	{
		$identity = $this->innerUserStorage->getIdentity();
		if (!$identity || !$this->identityInitializer) {
			return $identity;
		}
		if (!isset($this->initializedIdentities[$hash = spl_object_hash($identity)])) {
			$this->initializedIdentities[$hash] = $this->identityInitializer->initialize($identity);
		}

		return $this->initializedIdentities[$hash];
	}

}
