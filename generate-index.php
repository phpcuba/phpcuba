<?php

/**
 * phpcuba index generator
 */

$base_dir = __DIR__ . '/functions/';
$sections = scandir($base_dir);

$f = fopen("phpcuba-index.php", "w");

fputs($f, "<?php\n\n");

foreach ($sections as $section) {
  if ($section != "." && $section != ".." && is_dir("{$base_dir}$section")) {
    $functions = scandir("{$base_dir}$section/");
    foreach ($functions as $function) {
      if ($function != '.' && $function != ".." && !is_dir("{$base_dir}$section/$function")) {
        $function = str_replace(".php", "", $function);
        $code = "if (!function_exists('$function'))\n" .
          "include __DIR__.\"/functions/$section/$function.php\";\n" .
          "else phpcuba\\error(100, \"LOADING: Function $function() already exists\");\n\n";

        fputs($f, $code);
      }
    }
  }
}

fclose($f);