<?php

namespace PHPCuba;

class StringHelper
{

  /**
   * Clear string
   *
   * @param String $string
   * @param String $chars
   * @param bool   $direction True for keep, false for delete
   *
   * @param bool   $case_sensitive
   *
   * @return String
   *
   * @author @rafageist
   */
  public static function clear($string, $chars, $direction = true, $case_sensitive = true)
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
   * @return String
   */
  public static function onlyAlpha($string, $chars = "abcdefghijklmnopqrstuvwxyz1234567890", $case_sensitive = false)
  {
    return self::clear($string, $chars, $case_sensitive);
  }
}