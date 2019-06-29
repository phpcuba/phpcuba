<?php
declare(strict_types=1);
namespace PHPCuba;

use \InvalidArgumentException;

/**
 * Utilidades de manejo de texto
 *
 * @author lian
 */
class TextUtils
{
  /**
   * Caracteres alfanumericos - usados por #randomAlphaNumeric()
   */
  const ALPHA_NUMERIC = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

  /**
   * Error: Texto es null
   */
  const ERR_TEXT_IS_NULL = 'Text is null';

  public static function startsWith( string $text, string $prefix): bool
  {
    return (new Text( $text))->startsWith( $prefix);
  }

  /**
   * @throws InvalidArgumentException Si csvText es null.
   */
  public static function csvToArray( string $csvText = null): array
  {
    if ($csvText === null)
    {
      throw new InvalidArgumentException( self::ERR_TEXT_IS_NULL);
    }

    return (new Text( $csvText))->csvToArray();
  }

  public static function randomString( string $characters, int $length): string
  {
    $result = '';
    $lastIndex = strlen( $characters) - 1;

    for ($i = 0; $i < $length; $i++)
    {
      $index = mt_rand( 0, $lastIndex);
      $result .= $characters[$index];
    }

    return $result;
  }

  public static function randomAlphaNumeric( int $length): string
  {
    return self::randomString( self::ALPHA_NUMERIC, $length);
  }

  public static function trim( string $text): string
  {
    return trim( $text);
  }
}
