<?php
namespace Librette\SecurityNamespaces;

/**
 * @author David Matejka
 */
class CurrentNamespaceProxy implements ISecurityNamespace
{

	/** @var \Librette\SecurityNamespaces\INamespaceDetector */
	protected $namespaceDetector;


	/**
	 * @param INamespaceDetector $namespaceDetector
	 */
	public function __construct(INamespaceDetector $namespaceDetector)
	{
		$this->namespaceDetector = $namespaceDetector;
	}


	public function getName()
	{
		return $this->namespaceDetector->getNamespace()->getName();
	}


	public function getAuthenticator()
	{
		return $this->namespaceDetector->getNamespace()->getAuthenticator();
	}


	public function hasAuthenticator()
	{
		return $this->namespaceDetector->getNamespace()->hasAuthenticator();
	}


	public function getAuthorizator()
	{
		return $this->namespaceDetector->getNamespace()->getAuthorizator();
	}


	public function hasAuthorizator()
	{
		return $this->namespaceDetector->getNamespace()->hasAuthorizator();
	}


	public function getIdentityInitializer()
	{
		return $this->namespaceDetector->getNamespace()->getIdentityInitializer();
	}


	public function hasIdentityInitializer()
	{
		return $this->namespaceDetector->getNamespace()->hasIdentityInitializer();
	}

}
