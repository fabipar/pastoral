<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Bogota');
$archivoJSON = 'noticias.json';
$carpetaImagenes = 'IMAGENES_NOTICIAS/';
$carpetaRespaldo = 'RESPALDO_NOTICIAS/';

if (
  !isset($_POST['fecha'], $_POST['titulo'], $_POST['ubicacion'], $_POST['contenido']) ||
  !isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0
) {
  http_response_code(400);
  echo "❌ Faltan campos requeridos o hubo error al subir la imagen.<br>";
  echo "<pre>_POST:\n" . print_r($_POST, true) . "</pre>";
  echo "<pre>_FILES:\n" . print_r($_FILES, true) . "</pre>";
  exit;
}

if (!file_exists($carpetaImagenes)) mkdir($carpetaImagenes, 0777, true);
if (!file_exists($carpetaRespaldo)) mkdir($carpetaRespaldo, 0777, true);

$imagen = $_FILES['imagen'];
$nombreSeguro = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($imagen['name']));
$rutaImagen = $carpetaImagenes . $nombreSeguro;

$tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($imagen['type'], $tiposPermitidos)) {
  echo "❌ Tipo de imagen no permitido: " . $imagen['type'];
  exit;
}

if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
  $error = error_get_last();
  echo "❌ No se pudo guardar la imagen. " . ($error['message'] ?? 'Desconocido');
  exit;
}

$noticias = [];
if (file_exists($archivoJSON)) {
  $contenido = file_get_contents($archivoJSON);
  $noticias = json_decode($contenido, true);
  if (!is_array($noticias)) $noticias = [];
}

$nuevaNoticia = [
  'fecha'     => $_POST['fecha'],
  'titulo'    => $_POST['titulo'],
  'ubicacion' => $_POST['ubicacion'],
  'contenido' => $_POST['contenido'],
  'imagen'    => $rutaImagen
];

array_unshift($noticias, $nuevaNoticia);

$fechaBackup = date("Ymd_His");
file_put_contents($carpetaRespaldo . "respaldo_$fechaBackup.json", json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if (file_put_contents($archivoJSON, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
  echo "✅ Noticia guardada correctamente.<br>";
  echo "<strong>Imagen:</strong> $rutaImagen<br>";
  echo "<strong>Total noticias:</strong> " . count($noticias);
} else {
  $error = error_get_last();
  echo "❌ Error al guardar el archivo JSON: " . ($error['message'] ?? 'Desconocido');
}
?>







