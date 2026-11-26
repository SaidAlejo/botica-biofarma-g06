<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yape | Botica Biofarma</title>
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

    <!-- Yape Content -->
    <main class="flex-grow-1 d-flex align-items-center" style="background: linear-gradient(135deg, #dfa9ff, #8711c1); min-height: 500px; padding: 40px 0;">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center text-md-start">
                <div class="col-md-6 mb-5 mb-md-0 d-flex flex-column align-items-center align-items-md-end pe-md-5">
                    <div style="background-color: #00d9a6; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; margin-bottom: -20px; z-index: 1;">
                        <span class="fw-bold text-white" style="font-size: 40px; font-style: italic;">S/</span>
                        <div style="position: absolute; bottom: -5px; left: 10px; width: 20px; height: 20px; background-color: #00d9a6; transform: rotate(45deg);"></div>
                    </div>
                    <img src="img/yape_logo.png" alt="Yape" style="max-width: 300px; filter: drop-shadow(0px 10px 10px rgba(0,0,0,0.2));" onerror="this.src='https://placehold.co/300x150/8711c1/FFF?text=yape'">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center justify-content-md-start ps-md-5">
                    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); text-align: center; max-width: 320px;">
                        <h4 class="fw-bold text-dark mb-3" style="color: #002d40 !important;">ESCANÉAME</h4>
                        <img src="img/<?= htmlspecialchars($global_config['yape_qr'] ?? 'qr_yape.png') ?>" alt="Código QR Yape" style="max-width: 100%; border: 2px solid #00d9a6; border-radius: 10px; padding: 10px;" onerror="this.src='https://placehold.co/200x200/FFF/00d9a6?text=QR'">
                        <p class="small fw-bold text-muted mt-3 mb-0" style="font-size: 11px;">PARA OBTENER UN NÚMERO<br>ALEATORIO AL ESCANEAR</p>
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
                <p class="mb-1"><i class="fas fa-map-marker-alt"></i> <span class="dyn-direccion">Av. Providencia 1234, Oficina 501.</span></p>
                <p class="mb-1"><i class="fas fa-clock"></i> Abierto de 7am a 10pm.</p>
                <div class="text-dark">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            <img src="img/familia.png" alt="Familia" style="height: 150px; width: auto;" onerror="this.style.display='none'">
            <img src="img/doctor.png" alt="Doctor" style="height: 150px; width: auto;" onerror="this.style.display='none'">
        </div>
    </div>

    

</body>
</html>

