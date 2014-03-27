<?php
namespace Librette\SecurityNamespaces;

use Librette\SecurityNamespaces\Identity\IIdentityInitializer;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;


/**
 * @author David Matejka
 */
interface ISecurityNamespace
{

	/**
	 * @return IAuthenticator
	 * @throws InvalidStateException
	 */
	public function getAuthenticator();


	/**
	 * @return string
	 */
	public function getName();


	/**
	 * @return bool
	 */
	public function hasAuthenticator();


	/**
	 * @return IAuthorizator
	 * @throws InvalidStateException
	 */
	public function getAuthorizator();


	/**
	 * @return bool
	 */
	public function hasAuthorizator();


	/**
	 * @throws InvalidStateException
	 * @return IIdentityInitializer
	 */
	public function getIdentityInitializer();


	/**
	 * @return bool
	 */
	public function hasIdentityInitializer();
}