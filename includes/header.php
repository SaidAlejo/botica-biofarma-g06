<?php
require_once __DIR__ . '/conexion.php';
$global_config = null;
try {
    $stmt_config = $pdo->query("SELECT * FROM configuracion WHERE id = 1");
    $global_config = $stmt_config->fetch(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    $global_config = null;
}
$global_wa_raw = $global_config['whatsapp'] ?? '519258354599';

// Limpiar el número para los links (solo números puros para wa.me)
$wa_clean = preg_replace('/[^0-9]/', '', $global_wa_raw);

// Asegurar que visualmente solo tenga un "+" al inicio
$wa_display = '+' . ltrim(trim($global_wa_raw), '+');

// Mantenemos esta variable con el número limpio porque los demás archivos .php la usan para los links
$global_wa = $wa_clean; 

$current_page = basename($_SERVER['PHP_SELF']);
?>
<script>
    // Hacer disponible el número de WhatsApp a JavaScript (solo números)
    const globalWhatsApp = "<?= $wa_clean ?>";
</script>
<header class="main-header" style="background-color: #00A859;">
    <nav class="navbar navbar-expand-lg navbar-dark container py-2">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center text-decoration-none m-0 p-0" href="index.php">
            <img src="img/Logo.png" alt="Biofarma Logo" style="height: 60px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" class="me-2" onerror="this.src='https://placehold.co/60x60/00A859/FFF?text=Icono'">
            <div class="d-flex flex-column justify-content-center">
                <span style="color: white; font-weight: 800; font-size: 24px; letter-spacing: 1px; line-height: 1;">BIOFARMA</span>
                <span style="color: white; font-size: 14px; font-weight: 500;">Tu botica de confianza</span>
            </div>
        </a>

        <!-- Hamburger Button -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Links and Actions -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mt-3 mt-lg-0 gap-lg-4 text-center">
                <li class="nav-item">
                    <a class="nav-link text-white px-0 <?= $current_page == 'index.php' ? 'fw-bold border-bottom border-2' : '' ?>" href="index.php">INICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-0 <?= $current_page == 'catalogo.php' ? 'fw-bold border-bottom border-2' : '' ?>" href="catalogo.php">CATÁLOGO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-0 <?= $current_page == 'ubicacion.php' ? 'fw-bold border-bottom border-2' : '' ?>" href="ubicacion.php">UBICACIÓN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-0 <?= $current_page == 'nosotros.php' ? 'fw-bold border-bottom border-2' : '' ?>" href="nosotros.php">NOSOTROS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-0 <?= $current_page == 'contacto.php' ? 'fw-bold border-bottom border-2' : '' ?>" href="contacto.php">CONTACTO</a>
                </li>
            </ul>
            
            <div class="mt-3 mt-lg-0 text-center">
                <a href="https://wa.me/<?= $global_wa ?>" target="_blank" class="text-decoration-none bg-white d-inline-flex align-items-center justify-content-center px-4 py-2 rounded-pill shadow-sm transition" style="gap: 10px; color: #111;">
                    <div style="background: #25D366; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <span class="fw-bold" style="font-size: 16px;"><?= htmlspecialchars($wa_display) ?></span>
                </a>
            </div>
        </div>
    </nav>
</header>
