<?php
namespace LibretteTests\SecurityNamespace;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Librette\SecurityNamespaces\SecurityNamespace;
use Nette\Security\IIdentity;
use Nette\Security\Permission;
use Nette\Security\SimpleAuthenticator;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class IdentityInitializer implements IIdentityInitializer
{

	public function initialize(IIdentity $identity)
	{
		return $identity;
	}

}

class SecurityNamespaceTestCase extends TestCase
{
	public function testEmpty()
	{
		$securityNamespace = new SecurityNamespace('foo');

		Assert::exception(function() use($securityNamespace) {
			$securityNamespace->getAuthorizator();
		}, 'Librette\SecurityNamespaces\InvalidStateException', 'Authorizator has not been set.');

		Assert::exception(function () use ($securityNamespace) {
			$securityNamespace->getAuthenticator();
		}, 'Librette\SecurityNamespaces\InvalidStateException', 'Authenticator has not been set.');

		Assert::exception(function () use ($securityNamespace) {
			$securityNamespace->getIdentityInitializer();
		}, 'Librette\SecurityNamespaces\InvalidStateException', 'EntityIdentity initializer has not been set.');
	}

	public function testBasic()
	{
		$authenticator = new SimpleAuthenticator(array());
		$authorizator = new Permission();
		$initializer = new IdentityInitializer();

		$securityNamespace = new SecurityNamespace('foo', $authenticator, $authorizator, $initializer);

		Assert::same('foo', $securityNamespace->getName());
		Assert::same($authenticator, $securityNamespace->getAuthenticator());
		Assert::same($authorizator, $securityNamespace->getAuthorizator());
		Assert::same($initializer, $securityNamespace->getIdentityInitializer());
	}

}

run(new SecurityNamespaceTestCase());