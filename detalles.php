<?php
require_once 'includes/conexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: catalogo.php');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT p.*, c.nombre AS categoria_nombre, c.descripcion AS categoria_descripcion,
            pr.nombre_comercial AS proveedor_nombre
     FROM sti_g06_productos p
     INNER JOIN sti_g06_categorias c ON p.categoria_id = c.id
     INNER JOIN sti_g06_proveedores pr ON p.proveedor_id = pr.id
     WHERE p.id = ? AND p.activo = 1"
);
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header('Location: catalogo.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($producto['nombre']) ?> | Botica Biofarma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php include 'includes/header.php'; ?>

    <section class="hero" style="height: 250px; min-height: 250px;">
        <div class="hero-overlay"></div>
        <img src="img/PORTADA.png" alt="Interior botica" class="hero-bg" onerror="this.src='https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=2070&auto=format&fit=crop'">

        <div class="hero-top-bar">
            <a href="catalogo.php" class="back-arrow"><i class="fa-solid fa-arrow-left-long"></i></a>
            <div class="right-actions">
                <a href="faq.php" class="btn-faq text-decoration-none">
                    <span class="faq-q">?</span> FAQ
                </a>
            </div>
        </div>

        <div class="container hero-content" style="top: 30%;">
            <h1 class="hero-title" style="font-size: 32px;">DETALLES DEL PRODUCTO</h1>
        </div>
    </section>

    <main class="flex-grow-1" style="background-color: #d4eedd; padding: 40px 0;">
        <div class="container" style="max-width: 900px;">
            <div class="d-flex flex-column flex-md-row gap-4 align-items-start bg-white p-4" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="flex-shrink: 0; width: 100%; max-width: 300px; aspect-ratio: 1/1; background: white; border: 2px solid #eaeaea; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px; margin: 0 auto;">
                    <img src="img/<?= htmlspecialchars($producto['imagen'] ?: 'default.png') ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;" loading="lazy" onerror="this.src='https://placehold.co/300x300/FFF/00A859?text=Producto'">
                </div>
                <div class="text-dark w-100" style="font-size: 15px; line-height: 1.6;">
                    <span class="badge bg-success mb-2"><?= htmlspecialchars($producto['categoria_nombre']) ?></span>
                    <?php if (!empty($producto['requiere_receta'])): ?>
                        <span class="badge bg-warning text-dark mb-2 ms-1">Requiere receta médica</span>
                    <?php endif; ?>

                    <h2 class="mb-2 fw-bold" style="color: #00A859; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($producto['nombre']) ?></h2>
                    <p class="text-muted small mb-3">
                        SKU: <strong><?= htmlspecialchars($producto['sku']) ?></strong> ·
                        Presentación: <strong><?= htmlspecialchars($producto['gramaje']) ?></strong> ·
                        Laboratorio: <strong><?= htmlspecialchars($producto['proveedor_nombre']) ?></strong>
                    </p>

                    <p class="fs-4 fw-bold text-dark mb-3">S/ <?= number_format((float)$producto['precio'], 2) ?></p>

                    <div class="mb-4">
                        <strong class="d-block mb-1">Información de la categoría:</strong>
                        <p class="text-muted mb-0"><?= htmlspecialchars($producto['categoria_descripcion']) ?></p>
                    </div>

                    <?php
                    $mensaje_wa = "Hola, deseo consultar sobre el producto: " . $producto['nombre'] . " (" . $producto['sku'] . ")";
                    ?>
                    <a href="https://wa.me/<?= $global_wa ?>?text=<?= rawurlencode($mensaje_wa) ?>" target="_blank" class="btn w-100 fw-bold text-white py-3 d-flex align-items-center justify-content-center gap-2" style="background-color: #00A859; font-size: 16px; border-radius: 8px;">
                        <i class="fab fa-whatsapp fs-5"></i> Consultar vía Whatsapp
                    </a>

                    <?php if ((int)$producto['stock'] === 0): ?>
                        <div class="text-danger fw-bold mt-3 text-center"><i class="fa-solid fa-circle-xmark"></i> Producto Sin Stock Temporalmente</div>
                    <?php else: ?>
                        <div class="text-success fw-semibold mt-3 text-center small"><i class="fa-solid fa-circle-check"></i> Disponible en botica (<?= (int)$producto['stock'] ?> unidades)</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
