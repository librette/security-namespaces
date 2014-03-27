<?php
namespace LibretteTests\SecurityNamespace;

use Librette\SecurityNamespaces\Identity\DummyIdentityInitializer;
use Librette\SecurityNamespaces\NamespaceManager;
use Nette\Configurator;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class MyInitializer extends DummyIdentityInitializer
{

}

class ExtensionTestCase extends TestCase
{

	/** @var Container */
	protected $container;

	public function setUp()
	{
		$configurator = new Configurator();
		$configurator->addConfig(__DIR__ . '/config/securityExtension.neon');
		$configurator->setTempDirectory(TEMP_DIR);
		$this->container = $configurator->createContainer();
	}

	public function testNamespaceManager()
	{
		/** @var NamespaceManager $namespaceManager */
		$namespaceManager = $this->container->getByType('Librette\SecurityNamespaces\NamespaceManager');
		Assert::type('\Librette\SecurityNamespaces\NamespaceManager', $namespaceManager);
		
		$fooNamespace = $namespaceManager->getNamespace('foo');
		Assert::type('\Librette\SecurityNamespaces\SecurityNamespace', $fooNamespace);
		Assert::equal('foo', $fooNamespace->getName());
		Assert::type('LibretteTests\SecurityNamespace\MyInitializer', $fooNamespace->getIdentityInitializer());

		$barNamespace = $namespaceManager->getNamespace('bar');
		Assert::type('\Librette\SecurityNamespaces\SecurityNamespace', $barNamespace);
		Assert::equal('bar', $barNamespace->getName());
		Assert::type('Librette\SecurityNamespaces\Identity\DummyIdentityInitializer', $barNamespace->getIdentityInitializer());
	}

}

run(new ExtensionTestCase());
