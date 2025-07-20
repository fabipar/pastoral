<?php
// Configuración general
date_default_timezone_set('America/Bogota');
$archivoJSON = 'noticias.json';
$carpetaImagenes = 'IMAGENES_NOTICIAS/';
$carpetaRespaldo = 'RESPALDO_NOTICIAS/';

// Validar existencia de datos
if (
  !isset($_POST['fecha'], $_POST['titulo'], $_POST['ubicacion'], $_POST['contenido']) ||
  !isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0
) {
  http_response_code(400);
  echo "❌ Faltan campos requeridos o hubo error al subir la imagen.";
  exit;
}

// Crear carpetas si no existen
if (!file_exists($carpetaImagenes)) mkdir($carpetaImagenes, 0777, true);
if (!file_exists($carpetaRespaldo)) mkdir($carpetaRespaldo, 0777, true);

// Procesar imagen
$imagen = $_FILES['imagen'];
$nombreSeguro = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($imagen['name']));
$rutaImagen = $carpetaImagenes . $nombreSeguro;

// Mover imagen al destino
if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
  http_response_code(500);
  echo "❌ No se pudo guardar la imagen.";
  exit;
}

// Cargar contenido actual de noticias.json
$noticias = [];
if (file_exists($archivoJSON)) {
  $contenido = file_get_contents($archivoJSON);
  $noticias = json_decode($contenido, true);
  if (!is_array($noticias)) $noticias = [];
}

// Crear nueva noticia
$nuevaNoticia = [
  'fecha'     => $_POST['fecha'],
  'titulo'    => $_POST['titulo'],
  'ubicacion' => $_POST['ubicacion'],
  'contenido' => $_POST['contenido'],
  'imagen'    => $rutaImagen
];

// Agregar al inicio del array
array_unshift($noticias, $nuevaNoticia);

// Hacer respaldo
$fechaBackup = date("Ymd_His");
file_put_contents($carpetaRespaldo . "respaldo_$fechaBackup.json", json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Guardar nuevo archivo noticias.json
if (file_put_contents($archivoJSON, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
  echo "✅ Noticia guardada correctamente.";
} else {
  http_response_code(500);
  echo "❌ Error al guardar la noticia.";
}
?>





