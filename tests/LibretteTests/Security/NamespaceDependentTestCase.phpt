<?php
namespace LibretteTests\SecurityNamespace;

use Librette\SecurityNamespaces\CurrentNamespaceProxy;
use Librette\SecurityNamespaces\Identity\IdentityInitializerProxy;
use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Librette\SecurityNamespaces\Identity\IIdentityInitializerAccessor;
use Librette\SecurityNamespaces\Identity\NamespaceAwareIdentityInitializer;
use Librette\SecurityNamespaces\NamespaceAwareAuthenticator;
use Librette\SecurityNamespaces\NamespaceAwareAuthorizator;
use Librette\SecurityNamespaces\NamespaceDetector;
use Librette\SecurityNamespaces\NamespaceManager;
use Librette\SecurityNamespaces\SecurityNamespace;
use Librette\SecurityNamespaces\UserStorage;
use Nette\Http;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\User;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/mocks/UserStorageMock.php';


class AuthenticatorMock implements IAuthenticator
{

	public $result;


	function authenticate(array $credentials)
	{
		return $this->result;
	}

}


class AuthorizatorMock implements IAuthorizator
{

	public $result;


	function isAllowed($role, $resource, $privilege)
	{
		return $this->result;
	}

}

class InitializerMock implements IIdentityInitializer
{

	public $result;


	public function initialize(IIdentity $identity)
	{
		return $this->result;
	}

}

class InitializerAccessorMock implements IIdentityInitializerAccessor
{

	public $initializer;


	public function get()
	{
		return $this->initializer;
	}

}


class NamespaceAwareTestCase extends TestCase
{

	public function testAuthenticator()
	{
		$userStorage = new UserStorageMock();
		$namespaceManager = new NamespaceManager();
		$fooAuthenticator = new AuthenticatorMock();
		$fooAuthenticator->result = $fooIdentity = new Identity('john');
		$namespaceManager->addNamespace(new SecurityNamespace('foo', $fooAuthenticator));
		$barAuthenticator = new AuthenticatorMock();
		$barAuthenticator->result = $barIdentity = new Identity('admin');
		$namespaceManager->addNamespace(new SecurityNamespace('bar', $barAuthenticator));
		$namespaceDetector = new NamespaceDetector($userStorage, $namespaceManager);
		$namespaceProxy = new CurrentNamespaceProxy($namespaceDetector);
		$namespaceAwareAuthenticator = new NamespaceAwareAuthenticator($namespaceProxy);
		$user = new User($userStorage, $namespaceAwareAuthenticator);

		$userStorage->setNamespace('foo');
		$user->login();
		Assert::same($fooIdentity, $user->getIdentity());

		$userStorage->setNamespace('bar');
		$user->login();
		Assert::same($barIdentity, $user->getIdentity());

	}


	public function testAuthorizator()
	{
		$userStorage = new UserStorageMock();
		$namespaceManager = new NamespaceManager();
		$fooAuthorizator = new AuthorizatorMock();
		$fooAuthorizator->result = FALSE;
		$namespaceManager->addNamespace(new SecurityNamespace('foo', NULL, $fooAuthorizator));
		$barAuthorizator = new AuthorizatorMock();
		$barAuthorizator->result = TRUE;
		$namespaceManager->addNamespace(new SecurityNamespace('bar', NULL, $barAuthorizator));
		$namespaceDetector = new NamespaceDetector($userStorage, $namespaceManager);
		$namespaceProxy = new CurrentNamespaceProxy($namespaceDetector);
		$namespaceAwareAuthorizator = new NamespaceAwareAuthorizator($namespaceProxy);
		$user = new User($userStorage, NULL, $namespaceAwareAuthorizator);

		$userStorage->setNamespace('foo');
		Assert::false($user->isAllowed());

		$userStorage->setNamespace('bar');
		Assert::true($user->isAllowed());
	}
	
	public function testInitializer()
	{
		$accessor = new InitializerAccessorMock();
		$initializerProxy = new IdentityInitializerProxy($accessor);

		$userStorage = new UserStorage(new UserStorageMock(), $initializerProxy);
		$namespaceManager = new NamespaceManager();
		
		$fooInitializer = new InitializerMock();
		$fooInitializer->result = $fooIdentity = new Identity(1);
		$namespaceManager->addNamespace(new SecurityNamespace('foo', NULL, NULL, $fooInitializer));
		$barInitializer = new InitializerMock();
		$barInitializer->result = $barIdentity = new Identity(2);
		$namespaceManager->addNamespace(new SecurityNamespace('bar', NULL, NULL, $barInitializer));
		$namespaceDetector = new NamespaceDetector($userStorage, $namespaceManager);
		$namespaceProxy = new CurrentNamespaceProxy($namespaceDetector);
		$accessor->initializer = $namespaceAwareInitializer = new NamespaceAwareIdentityInitializer($namespaceProxy);

		$userStorage->identity = new Identity(3);
		$userStorage->setNamespace('foo');
		Assert::same($fooIdentity, $userStorage->getIdentity());
		$userStorage->identity = new Identity(4);
		$userStorage->setNamespace('bar');
		Assert::same($barIdentity, $userStorage->getIdentity());
	}
}


run(new NamespaceAwareTestCase());