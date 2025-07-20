<?php
// listar_respaldo_noticias.php
$dir = __DIR__ . '/respaldos_noticias/';
$archivos = array_diff(scandir($dir, SCANDIR_SORT_DESCENDING), array('..', '.'));
echo json_encode(array_values($archivos));

// restaurar_respaldo_noticia.php
if (isset($_GET['archivo'])) {
  $archivo = basename($_GET['archivo']);
  $origen = __DIR__ . "/respaldos_noticias/$archivo";
  $destino = __DIR__ . "/noticia.json";

  if (file_exists($origen)) {
    copy($origen, $destino);
    echo "Restauración completada.";
  } else {
    http_response_code(404);
    echo "Archivo no encontrado.";
  }
}

// eliminar_respaldo_noticia.php
if (isset($_GET['archivo'])) {
  $archivo = basename($_GET['archivo']);
  $ruta = __DIR__ . "/respaldos_noticias/$archivo";

  if (file_exists($ruta)) {
    unlink($ruta);
    echo "Respaldo eliminado.";
  } else {
    http_response_code(404);
    echo "Archivo no encontrado.";
  }
}
