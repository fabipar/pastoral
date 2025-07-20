<?php
$archivo = $_GET['archivo'] ?? '';
$desdePapelera = isset($_GET['papelera']);

$ruta_origen = $desdePapelera ? 'papelera_evangelio/' . $archivo : 'respaldos_evangelio/' . $archivo;
$ruta_destino = 'evangelio.json';

if (file_exists($ruta_origen)) {
  copy($ruta_origen, $ruta_destino);
  echo "✅ Evangelio restaurado desde " . ($desdePapelera ? 'papelera' : 'respaldos') . ".";
} else {
  echo "❌ Archivo no encontrado.";
}
