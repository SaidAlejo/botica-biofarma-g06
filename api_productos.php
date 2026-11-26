<?php
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
require_once 'includes/conexion.php';

try {
    $stmtCat = $pdo->query(
        "SELECT c.id, c.codigo, c.nombre, COUNT(p.id) AS total_productos
         FROM sti_g06_categorias c
         LEFT JOIN sti_g06_productos p ON p.categoria_id = c.id AND p.activo = 1
         WHERE c.activo = 1
         GROUP BY c.id, c.codigo, c.nombre
         ORDER BY c.nombre ASC"
    );
    $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

    $stmtProd = $pdo->query(
        "SELECT p.id, p.sku, p.nombre AS name, p.gramaje, p.precio AS price,
                p.imagen AS image, p.stock, p.requiere_receta, p.activo,
                p.categoria_id, c.nombre AS category_name
         FROM sti_g06_productos p
         INNER JOIN sti_g06_categorias c ON p.categoria_id = c.id
         WHERE p.activo = 1 AND c.activo = 1
         ORDER BY c.nombre ASC, p.nombre ASC"
    );
    $filas = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

    $productos = [];
    foreach ($filas as $p) {
        $productos[] = [
            'id' => (int)$p['id'],
            'sku' => $p['sku'],
            'name' => $p['name'],
            'gramaje' => $p['gramaje'],
            'price' => (float)$p['price'],
            'categoria_id' => (int)$p['categoria_id'],
            'category_name' => $p['category_name'],
            'image' => 'img/' . ($p['image'] ?: 'default.png'),
            'stock' => (int)$p['stock'],
            'requiere_receta' => (int)$p['requiere_receta'],
            'activo' => (int)$p['activo'],
        ];
    }

    echo json_encode([
        'categorias' => array_map(function ($c) {
            return [
                'id' => (int)$c['id'],
                'codigo' => $c['codigo'],
                'nombre' => $c['nombre'],
                'total_productos' => (int)$c['total_productos'],
            ];
        }, $categorias),
        'productos' => $productos,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
