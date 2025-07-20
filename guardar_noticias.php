<?php
header('Content-Type: application/json');

$archivo_json = 'evangelio.json';
$directorio_respaldo = 'respaldos_evangelio';

if (!file_exists($directorio_respaldo)) {
  mkdir($directorio_respaldo, 0777, true);
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos || !isset($datos['fecha'], $datos['titulo'], $datos['contenido'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Datos incompletos.']);
  exit;
}

// Hacer respaldo automático
if (file_exists($archivo_json)) {
  $respaldo_nombre = $directorio_respaldo . '/evangelio_' . date('Ymd_His') . '.json';
  copy($archivo_json, $respaldo_nombre);
}

// Guardar nuevo contenido
file_put_contents($archivo_json, json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode(['mensaje' => 'Evangelio guardado correctamente.']);





