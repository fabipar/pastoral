<?php
$testArchivo = "prueba_guardado.txt";
$contenido = "Esto es una prueba de escritura desde PHP.";

if (file_put_contents($testArchivo, $contenido)) {
  echo "✅ PHP puede escribir archivos correctamente.";
} else {
  $error = error_get_last();
  echo "❌ No se pudo escribir el archivo. Error: " . $error['message'];
}
?>
