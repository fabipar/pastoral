<?php
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["fecha"], $data["titulo"], $data["contenido"])) {
  http_response_code(400);
  echo "Faltan campos requeridos.";
  exit;
}

$evangelio = [
  "fecha" => $data["fecha"],
  "titulo" => $data["titulo"],
  "contenido" => $data["contenido"]
];

// Guardar archivo principal
file_put_contents("evangelio.json", json_encode($evangelio, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Crear respaldo con fecha y hora
if (!is_dir("respaldoevangelio")) {
  mkdir("respaldoevangelio", 0777, true);
}

$timestamp = date("Ymd_His");
$respaldoNombre = "evangelio_$timestamp.json";
file_put_contents("respaldoevangelio/$respaldoNombre", json_encode($evangelio, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "✅ Evangelio guardado y respaldo creado como '$respaldoNombre'.";
?>



