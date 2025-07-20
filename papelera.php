<?php
$directorio = 'papelera_evangelio';
$resultado = [];

if (is_dir($directorio)) {
  $archivos = scandir($directorio);
  foreach ($archivos as $archivo) {
    if ($archivo !== '.' && $archivo !== '..' && pathinfo($archivo, PATHINFO_EXTENSION) === 'json') {
      $resultado[] = $archivo;
    }
  }
}

header('Content-Type: application/json');
echo json_encode($resultado);