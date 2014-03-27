<?php
namespace LibretteTests\SecurityNamespace;

use Librette\SecurityNamespaces\UserStorage;
use Nette\Security\Identity;
use Nette\Security\IUserStorage;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/mocks/UserStorageMock.php';


class UserStorageTestCase extends TestCase
{

	/** @var UserStorage */
	protected $userStorage;

	/** @var UserStorageMock */
	protected $innerUserStorage;


	public function setUp()
	{
		$this->innerUserStorage = new UserStorageMock();
		$this->userStorage = new UserStorage($this->innerUserStorage);
	}


	public function testAuthenticated()
	{
		Assert::false($this->userStorage->isAuthenticated());
		$this->innerUserStorage->setAuthenticated(TRUE);
		Assert::true($this->userStorage->isAuthenticated());

		$this->userStorage->setAuthenticated(TRUE);
		Assert::true($this->innerUserStorage->isAuthenticated());
	}


	public function testIdentity()
	{
		$identity = new Identity(1);
		Assert::null($this->userStorage->getIdentity());
		$this->innerUserStorage->setIdentity($identity);
		Assert::same($identity, $this->userStorage->getIdentity());

		$identity = new Identity(2);
		$this->userStorage->setIdentity($identity);
		Assert::same($identity, $this->innerUserStorage->getIdentity());
	}


	public function testLogoutReason()
	{
		Assert::null($this->userStorage->getLogoutReason());
		$this->innerUserStorage->logoutReason = IUserStorage::BROWSER_CLOSED;
		Assert::equal(IUserStorage::BROWSER_CLOSED, $this->userStorage->getLogoutReason());
	}


	public function testExpiration()
	{
		Assert::null($this->innerUserStorage->expiration);
		$this->userStorage->setExpiration(123, 0);
		Assert::equal(array(123, 0), $this->innerUserStorage->expiration);
	}
}


run(new UserStorageTestCase());
