<?php
namespace Librette\SecurityNamespaces;

/**
 * @author David Matejka
 */
interface INamespaceAccessor
{

	/**
	 * @return ISecurityNamespace
	 */
	public function get();
}