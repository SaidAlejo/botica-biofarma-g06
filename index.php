<?php
require_once 'includes/conexion.php';
$stmt_ofertas = $pdo->query("SELECT * FROM sti_g06_productos WHERE activo = 1 ORDER BY precio ASC, id ASC LIMIT 3");
$ofertas = $stmt_ofertas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botica Biofarma | Tu botica de confianza</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section id="inicio" class="hero">
        <div class="hero-overlay"></div>
        <img src="img/PORTADA.png" alt="Interior botica" class="hero-bg" onerror="this.src='https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=2070&auto=format&fit=crop'">
        
        <!-- Top Left Back Arrow -->
        <a href="#" style="position: absolute; top: 20px; left: 30px; color: white; font-size: 24px; text-decoration: none; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); z-index: 10;">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>

        <!-- Top Right Actions -->
        <div style="position: absolute; top: 20px; right: 20px; display: flex; flex-direction: row; gap: 10px; align-items: center; z-index: 10;">
            <!-- Hidden Login (Helmet Person) -->
            <a href="login.php" class="text-decoration-none d-flex align-items-center floating-top-actions" style="color: rgba(255,255,255,0.5) !important; font-size: 22px; transition: color 0.3s; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'" title="Administración">
                <i class="fa-solid fa-helmet-safety"></i>
            </a>
            <!-- FAQ Button -->
            <a href="faq.php" class="text-decoration-none fw-bold d-flex align-items-center" style="color: #ffffff !important; background-color: #1c1c1c; padding: 6px 15px; border-radius: 30px; font-size: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.6);">
                <span style="color: #ff3b3b !important; font-weight: 900; margin-right: 5px; font-size: 20px;">?</span> FAQ
            </a>
        </div>

        <div class="container hero-content">
            <h1 class="hero-title">TU BOTICA DE CONFIANZA<br>EN EL BARRIO</h1>
            <p class="hero-subtitle">Atención personalizada, precios económicos. Abierto de 7am a 10pm.</p>
            <a href="#catalogo" class="btn-primary">Ver Catálogo</a>
        </div>

        <!-- Yape & WhatsApp Floaters -->
        <div class="hero-floaters d-flex flex-column align-items-end gap-2 gap-md-4" style="position: absolute; bottom: 20px; right: 20px; z-index: 10;">
            <div class="whatsapp-float">
                <a href="https://wa.me/<?= $global_wa ?>" target="_blank" class="text-decoration-none shadow" style="display: flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.7); color: white; padding: 8px 16px; border-radius: 30px; backdrop-filter: blur(5px);">
                    <i class="fab fa-whatsapp text-success fs-3"></i>
                    <span class="wa-text d-none d-sm-inline fw-bold">Chatea con nosotros</span>
                </a>
            </div>
            
            <a href="yape.php" class="text-decoration-none" title="Pagar con Yape">
                <img src="img/yape_icon.png" alt="Pagar con Yape" class="shadow-lg" style="width: 55px; height: 55px; border-radius: 14px; animation: float 3s ease-in-out infinite; border: 2px solid white; object-fit: cover; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            </a>
        </div>
    </section>

    <div class="container content-wrapper">
        <!-- Offers Section -->
        <section id="catalogo" class="offers-section">
            <h2 class="section-title">OFERTAS DEL MES</h2>
            <div class="products-grid">
                <?php if (count($ofertas) > 0): ?>
                    <?php foreach ($ofertas as $oferta): ?>
                        <div class="product-card">
                            <div class="product-image-wrapper" style="position: relative;">
                                <span class="badge-oferta">¡Oferta! <i class="fa-solid fa-fire"></i></span>
                                <a href="detalles.php?id=<?= $oferta['id'] ?>">
                                    <img src="img/<?= htmlspecialchars($oferta['imagen']) ?>" alt="<?= htmlspecialchars($oferta['nombre']) ?>" style="width: 100%; height: 180px; object-fit: contain; padding: 15px;" onerror="this.src='https://placehold.co/200x200/FFF/333?text=Sin+Imagen'">
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?= htmlspecialchars($oferta['nombre']) ?></h3>
                                <p class="product-price">S/. <?= number_format($oferta['precio'], 2) ?></p>
                                <?php
                                $mensaje_wa = "Deseo consultar por " . htmlspecialchars($oferta['nombre']);
                                ?>
                                <a class="dyn-whatsapp-url btn-whatsapp" href="https://wa.me/<?= $global_wa ?>?text=<?= rawurlencode($mensaje_wa) ?>" target="_blank">Consultar vía Whatsapp</a>
                                <?php if ($oferta['stock'] == 0 || $oferta['activo'] == 0): ?>
                                    <div class="text-danger fw-bold mt-2 text-center" style="font-size:12px;"><i class="fa-solid fa-circle-xmark"></i> Producto Sin Stock</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                        <i class="fa-solid fa-tags" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 15px;"></i>
                        <p style="font-size: 1.1rem;">Actualmente no tenemos ofertas destacadas.<br>¡Vuelve pronto para ver nuestras promociones!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Categories & Rating Section -->
        <section class="categories-rating-section">
            <div class="categories-area">
                <h2 class="section-title">NUESTRAS CATEGORÍAS</h2>
        <div class="categories-grid">
            <!-- Categoría 1 -->
            <a href="catalogo.php?cat=medicamentos" class="text-decoration-none" style="flex: 1; display: flex;">
                <div class="category-card" style="width: 100%;">
                    <img src="img/medicamentos.png" alt="Medicamentos" class="category-img" onerror="this.src='https://placehold.co/150x150/f0f0f0/666?text=Medicina'">
                    <h3 class="category-name text-dark text-center">Medicamentos</h3>
                </div>
            </a>
            <!-- Categoría 2 -->
            <a href="catalogo.php?cat=cuidado" class="text-decoration-none" style="flex: 1; display: flex;">
                <div class="category-card" style="width: 100%;">
                    <img loading="lazy" src="img/Cuida Personal.png" alt="Cuidado personal" class="category-img" onerror="this.src='https://placehold.co/150x150/f0f0f0/666?text=Cuidado'">
                    <h3 class="category-name text-dark text-center">Cuidado personal</h3>
                </div>
            </a>
            <!-- Categoría 3 -->
            <a href="catalogo.php?cat=perfumeria" class="text-decoration-none" style="flex: 1; display: flex;">
                <div class="category-card" style="width: 100%;">
                    <img loading="lazy" src="img/Perfumeria.png" alt="Perfumería" class="category-img" onerror="this.src='https://placehold.co/150x150/f0f0f0/666?text=Perfume'">
                    <h3 class="category-name text-dark text-center">Perfumería</h3>
                </div>
            </a>
        </div> <!-- End categories-grid -->
            </div> <!-- End categories-area -->
            
            <div class="rating-area" style="padding-top: 40px; margin-right: 12%;">
                <a href="testimonios.php" style="text-decoration: none; cursor: pointer; color: inherit; display: flex; flex-direction: column; align-items: center; gap: 15px; position: relative;">
                    <!-- Botón Verde Testimonios -->
                    <div class="btn-testimonios" style="color: #000; padding: 10px 40px; font-size: 18px; letter-spacing: 1px; width: 100%; text-align: center; border-radius: 12px; margin-bottom: -5px;">
                        TESTIMONIOS
                        <i class="fa-solid fa-arrow-pointer icon-pointer"></i>
                    </div>
                    
                    <div class="rating-badge" style="transform: scale(1.15); transform-origin: top center;">
                        <div class="rating-score">
                            <span class="score">5.0</span>
                            <span class="label">RATING</span>
                        </div>
                        <div class="rating-stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </a>
                
                <!-- Botón Pagar con Yape justo debajo del rating -->
                <div class="mt-3 text-end">
                    <a href="yape.php" class="btn text-white fw-bold px-3 py-2 shadow-sm" style="background-color: #8711c1; border-radius: 8px; font-size: 14px; border: 2px solid #a62fe0; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-qrcode" style="font-size: 18px;"></i> Pagar con Yape
                    </a>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section id="ubicacion" class="location-section">
            <h2 class="section-title">NUESTRA UBICACIÓN</h2>
            <div class="map-container">
                <iframe src="https://maps.google.com/maps?q=-18.0651914,-70.2482923&hl=es&z=17&output=embed" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="map-footer">
                    BOTICA BIOFARMA - TACNA, PERÚ
                </div>
            </div>
        </section>
    </div>

    <!-- Professional Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <!-- Bootstrap JS -->
    

</body>
</html>

