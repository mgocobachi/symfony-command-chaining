<?php
namespace Gocobachi\ChainCommandBundle\Exceptions;

use Exception;
use Symfony\Component\Console\Exception\ExceptionInterface;

class DependentException extends Exception implements ExceptionInterface
{
}