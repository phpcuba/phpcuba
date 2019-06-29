<?php

namespace phpcuba\strings;

/**
 * Clear string
 *
 * @param String $name
 * @param String $chars
 * @param bool   $direction True for keep, false for delete
 *
 * @param bool   $case_sensitive
 *
 * @return String
 *
 * @author @rafageist
 */
function clear($name, $chars, $direction = true, $case_sensitive = true)
{
  $l = strlen($name);
  $new_str = '';

  for ($i = 0; $i < $l; $i++) {
    $ch = $name[$i];
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