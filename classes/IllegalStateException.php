<?php
declare(strict_types=1);
namespace PHPCuba;

use \Exception;
use \Throwable;

/**
 * Exception de estado ilegal
 *
 * @author lian
 */
class IllegalStateException extends Exception
{
  public function __construct( string $message, Throwable $previous = null)
  {
    parent::__construct( $message, 0, $previous);
  }
}
