<?php
$archivo = $_GET['archivo'] ?? '';
$ruta_origen = 'respaldos_evangelio/' . $archivo;
$ruta_destino = 'papelera_evangelio/' . $archivo;

if (!file_exists('papelera_evangelio')) {
  mkdir('papelera_evangelio', 0777, true);
}

if (file_exists($ruta_origen)) {
  rename($ruta_origen, $ruta_destino);
  echo "🗑️ Respaldado movido a papelera.";
} else {
  echo "❌ Archivo no encontrado.";
}
