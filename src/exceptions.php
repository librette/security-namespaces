<?php
namespace Librette\SecurityNamespaces;

interface Exception
{

}

class InvalidStateException extends \RuntimeException implements Exception
{

}