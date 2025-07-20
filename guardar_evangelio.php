<?php
$archivo = 'evangelios.json';

// Leer entradas existentes
$historial = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Datos nuevos desde el formulario
$fecha = $_POST['fecha'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$contenido = $_POST['contenido'] ?? '';

if ($fecha && $titulo && $contenido) {
    // Agregar nuevo evangelio al inicio del array (para que el más reciente aparezca primero)
    array_unshift($historial, [
        'fecha' => $fecha,
        'titulo' => $titulo,
        'contenido' => $contenido
    ]);

    file_put_contents($archivo, json_encode($historial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "✅ Evangelio agregado correctamente.";
} else {
    echo "❌ Todos los campos son obligatorios.";
}
?>


