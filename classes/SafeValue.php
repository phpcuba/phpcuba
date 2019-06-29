<?php
declare(strict_types=1);
namespace PHPCuba;

use \DateTime;
use \InvalidArgumentException;

/**
 * Para asegurar values de un tipo específico
 *
 * @author lian
 */
class SafeValue
{
  public static function string( $value): string
  {
    $value = self::nonNull( $value);

    self::checkIsString( $value, 'value');

    return (string)$value;
  }

  public static function float( $value): float
  {
    $value = self::nonNull( $value);

    self::check( is_float( $value) && is_int( $value), 'value no es float');

    return (float)$value;
  }

  public static function integer( $value): int
  {
    $value = self::nonNull( $value);

    self::check( is_int( $value), 'value no es integer');

    return (int)$value;
  }

  public static function positiveInteger( $value): int
  {
    $value = self::integer( $value);

    self::check( $value > 0, 'value no es mayor que 0');

    return $value;
  }

  public static function boolean( $value): bool
  {
    $value = self::nonNull( $value);

    self::check( is_bool( $value), 'value no es boolean');

    return (bool)$value;
  }

  public static function dateTime( $value): DateTime
  {
    $value = self::nonNull( $value);

    self::check( $value instanceof DateTime, 'value no es un DateTime');

    return $value;
  }

  /**
   * @return mixed
   */
  public static function nonNull( $value = null)
  {
    self::check( $value !== null, 'value es null');

    return $value;
  }

  /**
   * @return resource
   */
  public static function resource( $value)
  {
    $value = self::nonNull( $value);

    self::check( is_resource( $value), 'value no es un resource');

    return $value;
  }

  /**
   * @param mixed $value
   * @return object
   */
  public static function object( $value, string $class = null)
  {
    $value = self::nonNull( $value);

    if ($class !== null)
    {
      self::check( $value instanceof $class, "value no es una instancia de {$class}");
    }
    else
    {
      self::check( is_object( $value), "value no es un objeto");
    }

    return $value;
  }

  public static function array( $value): array
  {
    $value = self::nonNull( $value);

    self::checkIsArray( $value, 'value');

    return $value;
  }

  /**
   * @return array<array>
   */
  public static function arrayOfArray( array $values)
  {
    foreach ($values as $value)
    {
      self::checkIsArray( $value, 'value');
    }

    return $values;
  }

  /**
   * @return array<string>
   */
  public static function stringArray( array $values)
  {
    foreach ($values as $value)
    {
      self::checkIsString( $value, 'value');
    }

    return $values;
  }

  /**
   * @return array<int>
   */
  public static function intArray( array $values)
  {
    foreach ($values as $value)
    {
      self::checkIsInteger( $value, 'value');
    }

    return $values;
  }

  /**
   * @return array<object>
   */
  public static function objectArray( array $values, string $class = null)
  {
    foreach ($values as $value)
    {
      SafeValue::object( $value, $class);
    }

    return $values;
  }

  /**
   * @return array<string,mixed>
   */
  public static function map( array $values)
  {
    foreach (array_keys( $values) as $key)
    {
      self::checkIsString( $key, 'key');
    }

    return $values;
  }

  /**
   * @return array<string,string>
   */
  public static function stringMap( array $values)
  {
    foreach ($values as $key => $value)
    {
      self::checkIsString( $key, 'key');
      self::checkIsString( $value, 'value');
    }

    return $values;
  }

  /**
   * @return array<string,string[]>
   */
  public static function stringArrayMap( array $values)
  {
    foreach ($values as $key => $value)
    {
      self::checkIsString( $key, 'key');
      self::checkIsStringArray( $value, 'value');
    }

    return $values;
  }

  private static function checkIsString( $value, string $varName)
  {
    self::check( is_string( $value), "{$varName} no es string: '{$value}'");
  }

  private static function checkIsArray( $value, string $varName)
  {
    self::check( is_array( $value), "{$varName} no es un array: '{$value}'");
  }

  private static function checkIsStringArray( $value, string $varName)
  {
    self::checkIsArray( $value, $varName);

    foreach ($value as $item)
    {
      self::checkIsString( $item, $varName);
    }
  }

  private static function checkIsInteger( $value, string $varName)
  {
    self::check( is_int( $value), "{$varName} no es string: '{$value}'");
  }

  /**
   * @throws InvalidArgumentException
   */
  private static function check( bool $condition, string $message)
  {
    if (!$condition)
    {
      throw new InvalidArgumentException( $message);
    }
  }
}
