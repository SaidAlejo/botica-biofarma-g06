<?php
require_once 'includes/conexion.php';

// Fetch products where category is Primeros Auxilios
$stmt = $pdo->prepare("SELECT p.*, c.nombre AS categoria_nombre
                      FROM sti_g06_productos p
                      INNER JOIN sti_g06_categorias c ON p.categoria_id = c.id
                      WHERE c.nombre LIKE '%Primeros Auxilios%' AND p.activo = 1
                      ORDER BY p.nombre ASC");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_productos = count($productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeros Auxilios | Botica Biofarma</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Green Banner -->
    <div style="background-color: #00A859; color: white; padding: 40px 0;">
        <div class="container">
            <h2 class="fw-bold mb-2">Primeros Auxilios</h2>
            <p class="mb-0" style="font-size: 14px;">Todo lo necesario para tu botiquín de emergencias</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1" style="background-color: #f9f9f9; padding: 30px 0;">
        <div class="container">
            <p class="text-muted small mb-4">Mostrando <?= $total_productos ?> producto<?= $total_productos !== 1 ? 's' : '' ?></p>
            
            <div class="row g-4">
                <?php if ($total_productos > 0): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card" style="height: 100%; display: flex; flex-direction: column;">
                                <a href="detalles.php?id=<?= $producto['id'] ?>" class="text-decoration-none text-dark" style="flex-grow: 1;">
                                    <div class="text-center mb-3">
                                        <img loading="lazy" src="img/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="height: 120px; max-width: 100%; object-fit: contain;" onerror="this.src='https://placehold.co/150x150/f0f0f0/666?text=Producto'">
                                    </div>
                                    <h5 class="fw-bold mb-1" style="font-size: 15px; height: 40px; overflow: hidden;"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                    <p class="text-success fw-bold fs-5 mb-2">S/. <?= number_format($producto['precio'], 2) ?></p>
                                </a>
                                <?php
                                $mensaje_wa = "Hola, deseo información sobre " . htmlspecialchars($producto['nombre']) . " de la sección Primeros Auxilios.";
                                ?>
                                <a href="https://wa.me/<?= $global_wa ?>?text=<?= rawurlencode($mensaje_wa) ?>" target="_blank" class="btn w-100 mt-auto btn-whatsapp-product" style="border-radius: 8px;">
                                    Consultar vía Whatsapp
                                </a>
                                <?php if ($producto['stock'] == 0): ?>
                                    <div class="text-danger fw-bold mt-2 text-center" style="font-size:12px;"><i class="fa-solid fa-circle-xmark"></i> Sin Stock</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fa-solid fa-briefcase-medical text-muted mb-3" style="font-size: 48px;"></i>
                        <h4 class="text-muted">No hay productos disponibles en esta categoría por el momento.</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
