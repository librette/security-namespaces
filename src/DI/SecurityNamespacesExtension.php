<?php
namespace Librette\SecurityNamespaces\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;

/**
 * @author David Matejka
 */
class SecurityNamespacesExtension extends CompilerExtension
{

	const SECURITY_NAMESPACE_TAG = 'librette.security.namespace';


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('namespaceDetector'))
				->setClass('Librette\SecurityNamespaces\NamespaceDetector');

		$builder->addDefinition($this->prefix('namespaceProxy'))
				->setClass('\Librette\SecurityNamespaces\CurrentNamespaceProxy');

		$builder->addDefinition($this->prefix('authenticator'))
				->setClass('Librette\SecurityNamespaces\NamespaceAwareAuthenticator');

		$builder->addDefinition($this->prefix('authorizator'))
				->setClass('Librette\SecurityNamespaces\NamespaceAwareAuthorizator');

		$builder->addDefinition($this->prefix('dummyIdentityInitializer'))
				->setClass('Librette\SecurityNamespaces\Identity\DummyIdentityInitializer')
				->setAutowired(FALSE);

		$builder->addDefinition($this->prefix('identityInitializer'))
				->setClass('Librette\SecurityNamespaces\Identity\IdentityInitializerProxy');

		$builder->addDefinition($this->prefix('identityInitializerAccessor'))
				->setImplement('Librette\SecurityNamespaces\Identity\IIdentityInitializerAccessor')
				->setFactory($this->prefix('@namespaceAwareIdentityInitializer'));

		$builder->addDefinition($this->prefix('namespaceAwareIdentityInitializer'))
				->setClass('Librette\SecurityNamespaces\Identity\NamespaceAwareIdentityInitializer')
				->setAutowired(FALSE);

		$builder->addDefinition($this->prefix('originalUserStorage'), $builder->getDefinition('nette.userStorage'))
				->setAutowired(FALSE);
		$builder->addDefinition($this->prefix('userStorage'))
				->setClass('Librette\SecurityNamespaces\UserStorage', array($this->prefix('@originalUserStorage')));


		$builder->addDefinition($this->prefix('namespaceManager'))
				->setClass('\Librette\SecurityNamespaces\NamespaceManager');
	}


	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$namespaceManager = $builder->getDefinition($this->prefix('namespaceManager'));
		foreach ($builder->findByTag(self::SECURITY_NAMESPACE_TAG) as $name => $null) {
			$nsDefinition = $builder->getDefinition($name);
			$nsDefinition->setAutowired(FALSE);
			$this->normalizeNamespaceArguments($nsDefinition);
			$namespaceManager->addSetup('addNamespace', array($nsDefinition));
		}

		$builder->removeDefinition('nette.userStorage');
		$builder->addDefinition('nette.userStorage')->setFactory($this->prefix('@userStorage'));
	}


	/**
	 * @param ServiceDefinition $namespaceDefinition
	 */
	private function normalizeNamespaceArguments(ServiceDefinition $namespaceDefinition)
	{
		$args = $namespaceDefinition->factory->arguments + array(1 => NULL, NULL, $this->prefix('@dummyIdentityInitializer'));
		ksort($args);
		$namespaceDefinition->factory->arguments = $args;
		$this->disableAutowiring($args);
	}


	/**
	 * @param array $args
	 */
	private function disableAutowiring(array $args)
	{
		$builder = $this->getContainerBuilder();
		foreach ($args as $def) {
			if (is_string($def) && $def[0] == '@' && $builder->hasDefinition($name = substr($def, 1))) {
				$def = $builder->getDefinition($name);
			}
			if ($def instanceof ServiceDefinition) {
				$def->setAutowired(FALSE);
			}
		}
	}

}