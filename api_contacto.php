<?php
header('Content-Type: application/json');
require_once 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

$nombre = trim($data['nombre'] ?? '');
$celular = trim($data['celular'] ?? '');
$correo = trim($data['correo'] ?? '');
$mensaje = trim($data['mensaje'] ?? '');

if (empty($nombre) || empty($celular) || empty($mensaje)) {
    http_response_code(400);
    echo json_encode(['error' => 'Por favor completa todos los campos obligatorios.']);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO sti_g06_mensajes (nombre, celular, correo, mensaje)
         VALUES (:nombre, :celular, :correo, :mensaje)"
    );
    $stmt->execute([
        ':nombre' => $nombre,
        ':celular' => $celular,
        ':correo' => $correo !== '' ? $correo : null,
        ':mensaje' => $mensaje,
    ]);

    echo json_encode(['success' => true, 'message' => 'Mensaje guardado correctamente']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el mensaje: ' . $e->getMessage()]);
}
?>
