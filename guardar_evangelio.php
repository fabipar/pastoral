<?php
// Ruta del archivo principal
$archivo = 'evangelio.json';
$respaldoDir = 'respaldo_evangelio';

// Crear carpeta de respaldo si no existe
if (!file_exists($respaldoDir)) {
    mkdir($respaldoDir, 0777, true);
}

// Recibir los datos del formulario
$fecha = $_POST['fecha'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$contenido = $_POST['contenido'] ?? '';

if ($fecha && $titulo && $contenido) {
    // Respaldar el archivo actual si existe
    if (file_exists($archivo)) {
        $timestamp = date('Ymd_His');
        copy($archivo, "$respaldoDir/evangelio_$timestamp.json");
    }

    // Guardar los nuevos datos
    $datos = [
        'fecha' => $fecha,
        'titulo' => $titulo,
        'contenido' => $contenido
    ];

    file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "✅ Evangelio actualizado correctamente.";
} else {
    echo "❌ Todos los campos son obligatorios.";
}
?>

