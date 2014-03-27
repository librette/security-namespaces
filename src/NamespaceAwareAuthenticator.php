<?php
namespace Librette\SecurityNamespaces;

use Nette\Object;
use Nette\Security\IAuthenticator;

/**
 * @author David Matejka
 */
class NamespaceAwareAuthenticator extends Object implements IAuthenticator
{

	/** @var INamespaceDetector */
	protected $namespaceDetector;


	/**
	 * @param INamespaceDetector $namespaceDetector
	 */
	public function __construct(INamespaceDetector $namespaceDetector)
	{
		$this->namespaceDetector = $namespaceDetector;
	}


	function authenticate(array $credentials)
	{
		$namespace = $this->namespaceDetector->getNamespace();

		return $namespace->getAuthenticator()->authenticate($credentials);
	}

}