<?php

declare(strict_types=1);

namespace PHPCuba;

use Exception;

/**
 * Text processing
 *
 * @author @liancastellon
 */
class Text extends Atomic
{

  const ERR_TEXT_IS_NULL = 'Text is null';

  const ALPHA_NUMERIC = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

  const LOWER_ALPHA_NUMERIC = '0123456789abcdefghijklmnopqrstuvwxyz';

  /**
   * @var int
   */
  private $length;

  /**
   * @param string $value
   */
  public function __construct(string $value = '')
  {
    parent::__construct($value);
  }

  /**
   * Set value
   *
   * @param string $value
   *
   * @throws \Exception
   */
  public function set($value)
  {

    if (!is_string($value)) {
      throw new Exception("Value must be a string");
    }

    parent::set($value);

    $this->length = strlen($this->get());
  }

  /**
   * To string
   *
   * @return string
   */
  public function __toString(): string
  {
    return $this->get();
  }

  /**
   * Alias for __toString
   *
   * @return string
   */
  public function asString(): string
  {
    return $this->__toString();
  }

  /**
   * Apply callable function to value
   *
   * @param $callable
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function apply($callable)
  {
    if (!is_callable($callable)) {
      throw new Exception('Not callable');
    }

    $this->set($callable($this->get()));

    return $this;
  }

  /**
   * Text length
   *
   * @return int
   */
  public function length(): int
  {
    return $this->length;
  }

  /**
   * Index of
   *
   * @param string $str
   *
   * @param bool   $caseSensitive
   *
   * @return int
   */
  public function indexOf(string $str, $caseSensitive = false): int
  {
    if ($caseSensitive) {
      $result = stripos($this->get(), $str);
    }
    else {
      $result = strpos($this->get(), $str);
    }

    return $result === false ? -1 : $result;
  }

  /**
   * Last index of
   *
   * @param string $str
   *
   * @return int
   */
  public function lastIndexOf(string $str): int
  {
    $result = strrpos($this->get(), $str);

    return $result === false ? -1 : $result;
  }

  /**
   * Contains substring
   *
   * @param string $subStr
   *
   * @return bool
   */
  public function contains(string $subStr): bool
  {
    return $this->indexOf($subStr) !== -1;
  }

  /**
   *
   * @param string $prefix
   *
   * @return bool
   */
  public function startsWith(string $prefix): bool
  {
    return $this->indexOf($prefix) === 0;
  }

  /**
   * @param string $suffix
   *
   * @return bool
   */
  public function endsWith(string $suffix): bool
  {
    return substr($this->get(), 0, 0 - strlen($suffix)) === $suffix;
  }

  /**
   * @return bool
   */
  public function hasCommas(): bool
  {
    return $this->contains(',');
  }

  /**
   * Append string
   *
   * @param string $text
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function append(string $text): self
  {
    $this->set($this->get() . $text);

    return $this;
  }

  /**
   * Prepend text
   *
   * @param string $text
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function prepend(string $text): self
  {
    $this->set($text . $this->get());

    return $this;
  }

  /**
   * Cut string
   *
   * @param int      $start
   * @param int|null $length
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function cutString(int $start, int $length = null): self
  {
    if ($length === null) {
      $length = strlen($this->get());
    }

    $this->set(substr($this->get(), $start, $length));

    return $this;
  }

  /**
   * Cut text from length
   *
   * @param int $suffixLength
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function suffix(int $suffixLength): self
  {
    return $this->cutString($this->length() - $suffixLength);
  }

  static function instance($value = null): self
  {
    return Objects::cast(parent::getInstance($value), self::class);
  }

  /**
   * @param string $pattern
   * @param string $replacement
   *
   * @return \PHPCuba\Text
   */
  public function replacePattern(string $pattern, string $replacement): self
  {
    return self::instance(preg_replace($pattern, $replacement, $this->get()));
  }

  /**
   * @param string $pattern
   *
   * @return array
   * @throws \Exception
   */
  public function split(string $pattern): array
  {
    $result = preg_split($pattern, $this->get());

    if (is_bool($result)) {
      throw new Exception('Error in preg_split()');
    }

    return $result;
  }

  /**
   * @param string $prefix
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function stripPrefix(string $prefix): self
  {
    if ($this->startsWith($prefix)) {
      return $this->cutString(strlen($prefix));
    }

    return $this;
  }

  /**
   * Prefixes repeating
   *
   * @param array $prefixes
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function stripPrefixesRepeating(array $prefixes): self
  {
    $result = $this;
    $original = new Text();

    while (!$result->equals($original)) {
      $original = $result;
      $prefixes = Type::forceArrayOfStrings($prefixes);

      foreach ($prefixes as $prefix) {
        $result = $result->stripPrefix($prefix);
      }
    }

    return $result->apply('trim');
  }

  /**
   * Strip suffix
   *
   * @param string $suffix
   *
   * @return \PHPCuba\Text
   */
  public function stripSuffix(string $suffix): self
  {
    $result = $this;

    if ($this->endsWith($suffix)) {
      $result = substr($this->get(), 0, 0 - strlen($suffix));
    }

    return $result;
  }

  /**
   * Ensure with suffix
   *
   * @param string $suffix
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function ensureSuffix(string $suffix): self
  {
    if (!$this->endsWith($suffix)) {
      $this->append($suffix);
    }

    return $this;
  }

  /**
   * CSV to array
   *
   * @return array
   * @throws \Exception
   */
  public function csvToArray(): array
  {
    return array_map(
      function ($value) {
        return trim($value);
      },
      $this->aplly('trim')->split('/,/')
    );
  }

  /**
   * Decode from base64
   *
   * @return \PHPCuba\Text
   * @throws \Exception
   */
  public function decodeBase64(): self
  {
    return $this->append('base64_decode');
  }

  /**
   * Matches
   *
   * @param string $pattern
   * @param array  $matches
   *
   * @return bool
   * @throws \Exception
   */
  public function match(string $pattern, array &$matches): bool
  {
    $matchResult = preg_match($pattern, $this->get(), $matches);

    if ($matchResult === false) {
      throw new Exception("Error in regular expression: '{$pattern}'");
    }

    return $matchResult === 1;
  }

  /**
   * Test string with pattern
   *
   * @param string $pattern
   *
   * @return bool
   * @throws \Exception
   */
  public function testRegularExpression(string $pattern): bool
  {
    $matches = [];

    return $this->match($pattern, $matches);
  }

  /**
   * Build with prefix
   *
   * @param string $text
   * @param string $prefix
   *
   * @return bool
   */
  public static function buildWithPrefix(string $text, string $prefix): bool
  {
    return (new self($text))->startsWith($prefix);
  }

  /**
   * Build CSV and convert to array
   *
   * @param string|null $csvText
   *
   * @return array
   * @throws \Exception
   */
  public static function buildCSVToArray(string $csvText = null): array
  {
    if (is_null($csvText)) {
      throw new Exception(self::ERR_TEXT_IS_NULL);
    }

    return (new self($csvText))->csvToArray();
  }

  /**
   * Apply callable to each character
   *
   * @param $callable
   *
   * @throws \Exception
   */
  public function each($callable)
  {
    $currentValue = $this->get();
    $newValue = '';
    for ($i = 0; $i < $this->length(); $i++) {
      $newValue .= $callable[$currentValue[$i]];
    }
    $this->set($newValue);

    return;
  }

  /**
   * @param string $characters
   * @param int    $length
   *
   * @return string
   */
  public static function random(string $characters, int $length): string
  {
    $result = '';
    $lastIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
      $index = mt_rand(0, $lastIndex);
      $result .= $characters[$index];
    }

    return $result;
  }

  /**
   * Random alpha numeric string
   *
   * @param int $length
   *
   * @return string
   */
  public static function randomAlphaNumeric(int $length): string
  {
    return self::random(self::ALPHA_NUMERIC, $length);
  }

  /**
   * Clear string
   *
   * @param string $string
   * @param string $chars
   * @param bool   $direction True for keep, false for delete
   *
   * @param bool   $case_sensitive
   *
   * @return string
   *
   * @author @rafageist
   */
  public static function clear(string $string, string $chars, $direction = true, $case_sensitive = true): string
  {
    $l = strlen($string);
    $new_str = '';

    for ($i = 0; $i < $l; $i++) {
      $ch = $string[$i];
      if ($case_sensitive) {
        if (strpos($chars, $ch) === $direction) {
          $new_str .= $ch;
        }
      }
      else {
        if (stripos($chars, $ch) === $direction) {
          $new_str .= $ch;
        }
      }
    }

    return $new_str;
  }

  /**
   * Only alpha numeric
   *
   * @param        $string
   * @param string $chars
   * @param bool   $case_sensitive
   *
   * @return string
   */
  public static function onlyAlpha(string $string, string $chars = self::LOWER_ALPHA_NUMERIC, $case_sensitive = false): string
  {
    return self::clear($string, $chars, $case_sensitive);
  }
}
