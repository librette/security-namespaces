<?php
namespace Librette\SecurityNamespaces\Identity;

/**
 * @author David Matejka
 */
interface IIdentityInitializerAccessor
{

	/**
	 * @return IIdentityInitializer
	 */
	public function get();
}
