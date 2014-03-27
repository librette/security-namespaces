<?php
namespace Librette\SecurityNamespaces;

use Nette\Security\IUserStorage;

/**
 * @author David Matejka
 */
interface INamespaceUserStorage extends IUserStorage
{

	/**
	 * @return string
	 */
	public function getNamespace();


	/**
	 * @param string $namespace
	 * @return void
	 */
	public function setNamespace($namespace);
}