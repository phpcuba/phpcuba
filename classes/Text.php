<?php
declare(strict_types=1);
namespace PHPCuba;

use \InvalidArgumentException;
use IllegalStateException;

/**
 * Clase de manejo de texto
 *
 * @author lian
 */
class Text
{
  /**
   * Error: Texto es null
   */
  const ERR_TEXT_IS_NULL = 'Text is null';

  /**
   * @var string
   */
  private $value;

  /**
   * @var int
   */
  private $length;

  /**
   * @throws InvalidArgumentException Si el value es null.
   */
  public function __construct( string $value = '')
  {
    if ($value === null)
    {
      throw new InvalidArgumentException( self::ERR_TEXT_IS_NULL);
    }

    $this->value = $value;
    $this->length = strlen( $value);
  }

  public static function from( $value): self
  {
    return new self( SafeValue::string( $value));
  }

  public function __toString(): string
  {
    return $this->value;
  }

  public function asString(): string
  {
    return $this->__toString();
  }

  public function length(): int
  {
    return $this->length;
  }

  public function equals( Text $other): bool
  {
    return $this->asString() === $other->asString();
  }

  public function indexOf( string $str): int
  {
    $result = strpos( $this->value, $str);

    return $result === false ? -1 : $result;
  }

  public function lastIndexOf( string $str): int
  {
    $result = strrpos( $this->value, $str);

    return $result === false ? -1 : $result;
  }

  public function contains( string $subStr): bool
  {
    return $this->indexOf( $subStr) !== -1;
  }

  public function startsWith( string $prefix): bool
  {
    return $this->indexOf( $prefix) === 0;
  }

  public function endsWith( string $suffix): bool
  {
    $index = $this->indexOf( $suffix);
    $suffixLength = strlen( $suffix);

    return ($index === $this->length - $suffixLength);
  }

  public function hasCommas(): bool
  {
    return $this->contains( ',');
  }

  public function append( string $text): self
  {
    return self::from( "{$this->value}{$text}");
  }

  public function prepend( string $text): self
  {
    return self::from( "{$text}{$this->value}");
  }

  public function substring( int $start, int $length = null): self
  {
    if ($length === null)
    {
      $length = strlen( $this->value);
    }

    return self::from( substr( $this->value, $start, $length));
  }

  public function suffix( int $suffixLength): self
  {
    return $this->substring( $this->length() - $suffixLength);
  }

  public function replacePattern( string $pattern, string $replacement): self
  {
    return self::from( preg_replace( $pattern, $replacement, $this->value));
  }

  /**
   * @throws IllegalStateException
   */
  public function split( string $pattern): array
  {
    $result = preg_split( $pattern, $this->value);

    if (is_bool( $result))
    {
      throw new IllegalStateException( 'Error en preg_split()');
    }

    return $result;
  }

  public function stripPrefix( string $prefix): self
  {
    $result = $this;

    if ($result->startsWith( $prefix))
    {
      $result = $this->substring( strlen( $prefix));
    }

    return $result;
  }

  public function stripPrefixesRepeating( array $prefixes): self
  {
    $result = $this;
    $original = new Text();

    while (!$result->equals( $original))
    {
      $original = $result;
      $prefixes = SafeValue::stringArray( $prefixes);

      foreach ($prefixes as $prefix)
      {
        $result = $result->stripPrefix( $prefix);
      }
    }

    return $result->trim();
  }

  public function stripSuffix( string $suffix): self
  {
    $result = $this;

    if ($this->endsWith( $suffix))
    {
      $result = $this->substring( 0, $this->length - strlen( $suffix));
    }

    return $result;
  }

  public function ensureSuffix( string $suffix): self
  {
    $result = $this;

    if (!$this->endsWith( $suffix))
    {
      $result = $this->append( $suffix);
    }

    return $result;
  }

  public function trim(): self
  {
    return self::from( trim( $this->value));
  }

  public function csvToArray(): array
  {
    return array_map(
      function( $value){
        return trim( $value);
      },
      $this->trim()->split( '/,/')
    );
  }

  public function decodeBase64(): self
  {
    return self::from( base64_decode( $this->value));
  }

  /**
   * @throws InvalidArgumentException
   */
  public function matches( string $pattern, array &$matches): bool
  {
    $matchResult = preg_match( $pattern, $this->value, $matches);

    if ($matchResult === false)
    {
      throw new InvalidArgumentException( "Error en expresión regular: '{$pattern}'");
    }

    return $matchResult === 1;
  }

  public function test( string $pattern): bool
  {
    $matches = [];

    return $this->matches( $pattern, $matches);
  }
}
