<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubicación | Botica Biofarma</title>
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

    <!-- Location Banner (from footer style) -->
    <div class="bg-info text-white text-center py-4 px-3 px-md-5 d-flex align-items-center justify-content-center flex-column" style="background-color: #63d1f4 !important; position: relative; overflow: hidden;">
        <h3 class="fw-bold mb-4 text-start w-100" style="max-width: 1200px; font-size: clamp(28px, 5vw, 36px); text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">UBICACIÓN <img src="img/serpiente.png" alt="caduceo" style="height: 40px; width: auto;" class="ms-2" onerror="this.style.display='none'"></h3>
        <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-4 gap-lg-5 w-100" style="max-width: 1200px;">
            <div class="text-start fs-6 fs-md-5 w-100 mb-3 mb-lg-0" style="max-width: 500px;">
                <p class="mb-2"><i class="fab fa-whatsapp text-success bg-white rounded-circle p-1"></i> +51 925-835-4599</p>
                <p class="mb-2"><i class="fas fa-map-marker-alt text-danger"></i> <span class="dyn-direccion">Cerca de la Av. Sldo. Estanislao Condor y el sector de Villa Transportista, Tacna, Perú.</span></p>
                <p class="mb-2"><i class="fas fa-clock text-dark"></i> Abierto de 7am a 10pm.</p>
                <div class="text-dark mt-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-3 w-100">
                <img src="img/familia.png" alt="Familia" class="img-fluid" style="max-height: 150px; width: auto;" onerror="this.style.display='none'">
                <img src="img/doctor.png" alt="Doctor" class="img-fluid" style="max-height: 150px; width: auto;" onerror="this.style.display='none'">
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <main class="container py-5 flex-grow-1 d-flex flex-column align-items-center">
        <div class="map-container shadow-lg rounded overflow-hidden" style="width: 100%; max-width: 1000px; height: 500px; border: 4px solid white;">
            <iframe src="https://maps.google.com/maps?q=-18.0651914,-70.2482923&hl=es&z=17&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </main>

    <!-- Professional Footer -->
    <?php include 'includes/footer.php'; ?>

    

</body>
</html>


