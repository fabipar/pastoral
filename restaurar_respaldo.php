<?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = basename($data["archivo"]);
$origen = isset($data["origen"]) && $data["origen"] === "papelera" ? "papeleraevangelio" : "respaldoevangelio";

$ruta_origen = __DIR__ . "/$origen/$archivo";
$ruta_destino = __DIR__ . "/evangelio.json";

if (!file_exists($ruta_origen)) {
  http_response_code(404);
  echo "Archivo no encontrado.";
  exit;
}

if (!copy($ruta_origen, $ruta_destino)) {
  http_response_code(500);
  echo "Error al restaurar el archivo.";
  exit;
}

echo "✅ Archivo restaurado exitosamente desde '$origen'.";

