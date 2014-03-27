<?php
namespace Librette\SecurityNamespaces;


/**
 * @author David Matejka
 */
interface INamespaceDetector
{

	/**
	 * @return SecurityNamespace
	 * @throws InvalidStateException
	 */
	public function getNamespace();
}