<?php

/**
 * phpcuba index generator
 */

$base_dir = __DIR__ . '/functions/';
$sections = scandir($base_dir);

$f = fopen(__DIR__ . "/phpcuba-index.php", "w");
$readme_new = fopen(__DIR__ . "/readme", "w");
$readme = fopen(__DIR__ . "/README.md", "r");

while (!feof($readme)) {
  $l = fgets($readme);
  fputs($readme_new, $l);
  if (trim($l) == "<reference>") {
    fputs($readme_new, "\n");
    break;
  }
}

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

      if (!is_dir("{$base_dir}$section/$function") && strpos($function, ".md") !== false) {
        fputs($readme_new, "### phpcuba \\ $section \\ " . str_replace('.md', '', $function) . "()\n\n");
        fputs($readme_new, file_get_contents("{$base_dir}$section/$function") . "\n");
      }

    }
  }
}

$start = false;
while (!feof($readme)) {
  $l = fgets($readme);

  if (trim($l) == "</reference>") {
    $start = true;
  }

  if ($start) {
    fputs($readme_new, $l);
  }
}

fclose($readme_new);
fclose($readme);
unlink(__DIR__ . "/README.md");
rename(__DIR__ . "/readme", __DIR__ . "/README.md");
fclose($f);