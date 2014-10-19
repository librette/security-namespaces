<?php
namespace Librette\SecurityNamespaces\Identity;

use Nette\Security\IIdentity;

/**
 * @author David Matejka
 */
class DummyIdentityInitializer implements IIdentityInitializer
{

	public function initialize(IIdentity $identity)
	{
		return $identity;
	}

}
