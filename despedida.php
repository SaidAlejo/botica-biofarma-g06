<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Gracias por visitarnos! | Botica Biofarma</title>
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
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Despedida Content -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center" style="background-color: #5ab174; padding: 60px 0;">
        <div class="container">
            <div class="row align-items-center">
                
                <!-- Left Banner -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="promo-banner p-4 text-center rounded shadow-sm" style="background-color: #c9ebd8; border: none; height: 100%;">
                        <div class="d-flex justify-content-center gap-3 mb-2">
                            <i class="fa-solid fa-bolt text-danger fs-4"></i>
                            <i class="fa-solid fa-shield-halved text-success" style="font-size: 40px;"></i>
                            <i class="fa-solid fa-lock text-danger fs-4"></i>
                        </div>
                        <h5 class="text-success fw-bold mt-3" style="font-size: 16px;">¡NAVEGA MÁS<br>RÁPIDO Y SEGURO!</h5>
                        <p class="small text-dark fw-bold mt-3" style="font-size: 10px; line-height: 1.4;">Bloquea anuncios y<br>rastreadores intrusivos...</p>
                        <p class="text-muted mt-2" style="font-size: 9px;">Descarga gratuita para PC, Mac, iOS y Android.</p>
                        <button class="btn w-100 rounded-pill fw-bold text-white mt-2" style="background-color: #1b8a53; font-size: 12px; padding: 10px;">DESCARGAR GRATIS</button>
                    </div>
                </div>

                <!-- Center Text -->
                <div class="col-md-6 text-center text-white my-5 my-md-0">
                    <h1 class="fw-bold" style="font-size: 48px; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); line-height: 1.2;">
                        GRACIAS POR<br>VISITARNOS!!!
                    </h1>
                </div>

                <!-- Right Banner -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="promo-banner p-4 text-center rounded shadow-sm" style="background-color: #c9ebd8; border: none; height: 100%;">
                        <i class="fa-solid fa-basket-shopping text-success mb-2" style="font-size: 40px;"></i>
                        <h5 class="text-success fw-bold mt-2" style="font-size: 16px;">¡BIENVENIDO!</h5>
                        <p class="small fw-bold text-dark mt-3" style="font-size: 11px; line-height: 1.4;">APROVECHA UN 15% DE<br>DESCUENTO ADICIONAL EN<br>TU PRIMERA COMPRA DE<br>CUIDADO PERSONAL Y<br>PERFUMERÍA.</p>
                        <p class="text-muted mt-3 mb-4" style="font-size: 9px;">Válido en la web. Hasta fin de mes.</p>
                        <a href="catalogo.php" class="btn w-100 rounded-pill fw-bold text-white" style="background-color: #1b8a53; font-size: 12px; padding: 10px;">VER OFERTAS</a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Contact Footer -->
    <div class="contact-footer bg-info text-white text-center py-4 d-flex align-items-center justify-content-center flex-column mt-auto" style="background-color: #63d1f4 !important; position: relative; overflow: hidden;">
        <h4 class="fw-bold mb-3 text-start w-100 ps-5" style="max-width: 1200px;">UBICACION</h4>
        <div class="d-flex justify-content-center align-items-center gap-5 w-100" style="max-width: 1200px;">
            <div class="text-start">
                <p class="mb-1"><i class="fab fa-whatsapp"></i> +51 925-835-4599</p>
                <p class="mb-1"><i class="fas fa-map-marker-alt"></i> Av. Providencia 1234, Oficina 501.</p>
                <p class="mb-1"><i class="fas fa-clock"></i> Abierto de 7am a 10pm.</p>
                <div class="text-dark">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            <img src="img/familia.png" alt="Familia" style="height: 150px; width: auto;" onerror="this.style.display='none'">
            <img src="img/doctor.png" alt="Doctor" style="height: 150px; width: auto;" onerror="this.style.display='none'">
        </div>
    </div>

    
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 1500);
    </script>

</body>
</html>

