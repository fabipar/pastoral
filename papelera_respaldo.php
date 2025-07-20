<?php
$dir = __DIR__ . "/papeleraevangelio/";
$archivos = [];

if (is_dir($dir)) {
  foreach (scandir($dir) as $archivo) {
    if (is_file($dir . $archivo) && pathinfo($archivo, PATHINFO_EXTENSION) === "json") {
      $archivos[] = $archivo;
    }
  }

  usort($archivos, function($a, $b) use ($dir) {
    return filemtime($dir . $b) - filemtime($dir . $a);
  });
}

header("Content-Type: application/json");
echo json_encode($archivos);
