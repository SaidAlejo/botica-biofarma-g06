<?php
header('Content-Type: application/json');
require_once 'includes/conexion.php';

$defaults = [
    'whatsapp' => '+51 925 835 459',
    'whatsapp_clean' => '51925835459',
    'email' => 'contacto@boticabiofarma.pe',
    'direccion' => 'Av. Bolognesi 842, Tacna',
    'facebook' => 'https://facebook.com',
    'instagram' => 'https://instagram.com',
    'yape_qr' => 'qr.png',
];

try {
    $stmt = $pdo->query("SELECT * FROM configuracion WHERE id = 1");
    $config = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($config) {
        $config['whatsapp_clean'] = preg_replace('/[^0-9]/', '', $config['whatsapp']);
        echo json_encode($config);
    } else {
        echo json_encode($defaults);
    }
} catch (Throwable $e) {
    echo json_encode($defaults);
}
?>
