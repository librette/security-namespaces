<?php
namespace Librette\SecurityNamespaces\Identity;

use Nette\Object;
use Nette\Security\IIdentity;

/**
 * Prevents circular reference
 *
 * @author David Matejka
 */
class IdentityInitializerProxy extends Object implements IIdentityInitializer
{

	/** @var \Librette\SecurityNamespaces\Identity\IIdentityInitializerAccessor */
	protected $initializerAccessor;


	/**
	 * @param IIdentityInitializerAccessor $initializerAccessor
	 */
	public function __construct(IIdentityInitializerAccessor $initializerAccessor)
	{
		$this->initializerAccessor = $initializerAccessor;
	}


	/**
	 * @param IIdentity $identity
	 * @return IIdentity
	 */
	public function initialize(IIdentity $identity)
	{
		return $this->initializerAccessor->get()->initialize($identity);
	}

}