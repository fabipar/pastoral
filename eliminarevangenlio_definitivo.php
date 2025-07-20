<?php
$archivo = $_GET['archivo'] ?? '';
$ruta = 'papelera_evangelio/' . $archivo;

if (file_exists($ruta)) {
  unlink($ruta);
  echo "❌ Archivo eliminado definitivamente.";
} else {
  echo "❌ Archivo no encontrado en papelera.";
}
