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
      if (!is_dir("{$base_dir}$section/$function") && strpos($function, ".php") !== false) {
        $function = str_replace(".php", "", $function);
        $code = "include __DIR__.\"/functions/$section/$function.php\";\n";
        fputs($f, $code);
      }
    }
  }
}

fclose($f);