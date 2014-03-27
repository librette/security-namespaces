<?php
namespace Librette\SecurityNamespaces;


/**
 * @author David Matejka
 */
interface INamespaceDetector
{

	/**
	 * @return SecurityNamespace current namespace
	 * @throws InvalidStateException
	 */
	public function getNamespace();
}