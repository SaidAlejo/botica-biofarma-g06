<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes | Botica Biofarma</title>
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
<body class="d-flex flex-column min-vh-100" style="background-color: #f5f5f5;">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Green Banner -->
    <div style="background-color: #00A859; color: white; padding: 50px 0; text-align: center;">
        <div class="container">
            <h2 class="fw-bold mb-3" style="font-size: 28px;">Preguntas Frecuentes</h2>
            <p class="mb-0" style="font-size: 15px; opacity: 0.9;">Encuentra respuestas a las dudas más comunes</p>
        </div>
    </div>

    <!-- FAQ Content -->
    <main class="flex-grow-1" style="padding: 40px 0;">
        <div class="container" style="max-width: 800px;">
            
            <div class="accordion" id="faqAccordion">
                
                <!-- FAQ 1 -->
                <div class="accordion-item mb-3" style="border: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 14px;">
                            ¿Hacen delivery a domicilio?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px; line-height: 1.6;">
                            Sí, realizamos delivery a domicilio en La Molina y distritos cercanos. El costo del delivery varía según la zona. Puedes consultarnos por WhatsApp al <span class="dyn-whatsapp-text"></span> para conocer el costo exacto a tu dirección.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="accordion-item mb-3" style="border: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-size: 14px;">
                            ¿Cuál es el horario de atención?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px; line-height: 1.6;">
                            Atendemos todos los días de 7:00 am a 10:00 pm de forma ininterrumpida.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="accordion-item mb-3" style="border: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="font-size: 14px;">
                            ¿Aceptan recetas médicas por foto?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px; line-height: 1.6;">
                            Sí, puedes enviarnos una foto clara de tu receta médica a nuestro WhatsApp y nuestros farmacéuticos se encargarán de prepararte el pedido.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="accordion-item mb-3" style="border: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="font-size: 14px;">
                            ¿Qué métodos de pago aceptan?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px; line-height: 1.6;">
                            Aceptamos efectivo, tarjetas de crédito/débito (Visa, Mastercard), Yape, Plin y transferencias bancarias.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="accordion-item mb-5" style="border: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="font-size: 14px;">
                            ¿Tienen descuentos para adultos mayores?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px; line-height: 1.6;">
                            Sí, ofrecemos un 10% de descuento en medicamentos seleccionados para adultos mayores presentando su DNI.
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact Help Box -->
            <div class="text-center p-5 mt-4" style="background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h5 class="fw-bold text-dark mb-2">¿No encontraste tu respuesta?</h5>
                <p class="text-muted small mb-4">Estamos aquí para ayudarte. Contáctanos directamente</p>
                <a class="dyn-whatsapp-url" href="https://wa.me/<?= $global_wa ?>" target="_blank" class="btn fw-bold text-white px-4 py-2 rounded-pill" style="background-color: #00A859; font-size: 14px;">
                    Chatear por WhatsApp
                </a>
            </div>

        </div>
    </main>

    
    <!-- CSS override to match Figma accordion style -->
    <style>
        .accordion-button:not(.collapsed) {
            background-color: white;
            color: #212529;
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }
        .accordion-button::after {
            background-size: 1rem;
            filter: invert(47%) sepia(87%) saturate(583%) hue-rotate(101deg) brightness(96%) contrast(101%);
        }
    </style>

    <!-- Footer and Scripts -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
