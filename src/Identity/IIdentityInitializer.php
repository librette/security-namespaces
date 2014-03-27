<?php
namespace Librette\SecurityNamespaces\Identity;

use Nette\Security\IIdentity;

/**
 * @author David Matejka
 */
interface IIdentityInitializer
{

	/**
	 * Initializes identity
	 *
	 * @param IIdentity $identity
	 * @return IIdentity initialized entity
	 */
	public function initialize(IIdentity $identity);

}