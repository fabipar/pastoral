<?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = basename($data["archivo"]);
$origen = __DIR__ . "/respaldoevangelio/$archivo";
$destino = __DIR__ . "/papeleraevangelio/$archivo";

if (!file_exists($origen)) {
  http_response_code(404);
  echo "Archivo no encontrado.";
  exit;
}

if (!is_dir(__DIR__ . "/papeleraevangelio")) {
  mkdir(__DIR__ . "/papeleraevangelio", 0777, true);
}

if (!rename($origen, $destino)) {
  http_response_code(500);
  echo "Error al mover el archivo a la papelera.";
  exit;
}

echo "🗑️ Archivo movido a la papelera correctamente.";
