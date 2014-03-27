<?php
namespace LibretteTests\SecurityNamespace;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Librette\SecurityNamespaces\UserStorage;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/mocks/UserStorageMock.php';

class MyInitializer implements IIdentityInitializer
{

	public $counter = 0;

	public function initialize(IIdentity $identity)
	{
		$this->counter++;

		return $identity;
	}

}

class IdentityInitializerTestCase extends TestCase
{

	/** @var UserStorage */
	protected $userStorage;

	/** @var UserStorageMock */
	protected $innerUserStorage;

	/** @var MyInitializer */
	protected $initializer;

	public function setUp()
	{
		$this->innerUserStorage = new UserStorageMock();
		$this->userStorage = new UserStorage($this->innerUserStorage, $this->initializer = new MyInitializer());
	}

	public function testInvocationCount()
	{
		Assert::equal(0, $this->initializer->counter);
		$this->userStorage->getIdentity();
		Assert::equal(0, $this->initializer->counter);
		$this->userStorage->setIdentity(new Identity(1));
		$this->userStorage->getIdentity();
		Assert::equal(1, $this->initializer->counter);
		$this->userStorage->getIdentity();
		Assert::equal(1, $this->initializer->counter);
		$this->userStorage->setIdentity(new Identity(2));
		$this->userStorage->getIdentity();
		Assert::equal(2, $this->initializer->counter);
		$this->userStorage->getIdentity();
		Assert::equal(2, $this->initializer->counter);
	}

}


run(new IdentityInitializerTestCase());
