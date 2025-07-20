<?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = basename($data["archivo"]);
$ruta = __DIR__ . "/papeleraevangelio/$archivo";

if (!file_exists($ruta)) {
  http_response_code(404);
  echo "Archivo no encontrado.";
  exit;
}

if (!unlink($ruta)) {
  http_response_code(500);
  echo "Error al eliminar permanentemente.";
  exit;
}

echo "✅ Archivo eliminado permanentemente.";

