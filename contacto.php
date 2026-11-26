<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Botica Biofarma</title>
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
    <style>
        .error-border {
            border-color: #dc3545 !important;
        }
        .error-text {
            color: #dc3545;
            font-size: 11px;
            margin-top: 4px;
            display: none;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #f9f9f9;">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Dynamic Header Banner -->
    <div id="contact-banner" style="background-color: #00A859; color: white; padding: 40px 0; text-align: center;">
        <div class="container">
            <h2 id="banner-title" class="fw-bold mb-2">Contáctanos</h2>
            <p id="banner-subtitle" class="mb-0" style="font-size: 14px;">Estamos aquí para ayudarte. Envíanos tu consulta</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container" style="max-width: 900px;">
            
            <!-- Default Form Layout -->
            <div id="form-layout" class="row g-4">
                
                <!-- Left: Form -->
                <div class="col-md-7">
                    <div style="background-color: white; border-radius: 12px; padding: clamp(15px, 5vw, 30px); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h5 class="fw-bold text-dark mb-4">Envíanos un Mensaje</h5>
                        
                        <!-- Error Alert Box (Hidden by default) -->
                        <div id="error-alert" style="display: none; background-color: #fceceb; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                            <div class="d-flex gap-2">
                                <i class="fa-solid fa-circle-exclamation" style="color: #dc3545; margin-top: 3px;"></i>
                                <div>
                                    <p class="fw-bold mb-1" style="color: #dc3545; font-size: 13px;">Por favor, corrige los siguientes errores:</p>
                                    <ul id="error-list" class="mb-0 ps-3" style="color: #dc3545; font-size: 11px;">
                                        <!-- Errors injected here -->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <form id="contactForm">
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold" style="font-size: 12px;">Nombre Completo</label>
                                <input type="text" id="nombre" class="form-control" placeholder="Ingresa tu nombre" style="font-size: 13px; padding: 10px;">
                                <div id="error-nombre" class="error-text"><i class="fa-solid fa-circle-exclamation"></i> Este campo es obligatorio</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold" style="font-size: 12px;">Celular</label>
                                <input type="tel" id="celular" class="form-control" placeholder="999 999 999" style="font-size: 13px; padding: 10px;" maxlength="15" oninput="this.value = this.value.replace(/[^0-9+ ]/g, '')" title="Solo números permitidos" required>
                                <div id="error-celular" class="error-text"><i class="fa-solid fa-circle-exclamation"></i> Este campo es obligatorio</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold" style="font-size: 12px;">Correo Electrónico</label>
                                <input type="email" id="correo" class="form-control" placeholder="tucorreo@ejemplo.com" style="font-size: 13px; padding: 10px;">
                                <!-- Correo is technically optional based on the screenshots which only complain about nombre, celular, mensaje, but we can make it optional -->
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold" style="font-size: 12px;">Mensaje</label>
                                <textarea id="mensaje" class="form-control" rows="4" placeholder="Escribe tu consulta aquí..." style="font-size: 13px; padding: 10px;"></textarea>
                                <div id="error-mensaje" class="error-text"><i class="fa-solid fa-circle-exclamation"></i> Este campo es obligatorio</div>
                            </div>

                            <button type="submit" class="btn w-100 fw-bold text-white" style="background-color: #00A859; padding: 12px; border-radius: 8px;">Enviar Consulta</button>
                        </form>
                    </div>
                </div>

                <!-- Right: Contact Info Cards -->
                <div class="col-md-5">
                    
                    <div class="mb-3" style="background-color: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: flex-start; gap: 15px;">
                        <div style="background-color: #f0fdf4; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-phone text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Teléfono</h6>
                            <p class="text-muted mb-1" style="font-size: 12px;"><span>+51 925 835 4599</span></p>
                            <p class="text-muted mb-0" style="font-size: 10px;">Lunes a Domingo: 7:00 AM - 10:00 PM</p>
                        </div>
                    </div>

                    <div class="mb-3" style="background-color: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: flex-start; gap: 15px;">
                        <div style="background-color: #f0fdf4; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-envelope text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Email</h6>
                            <p class="text-muted mb-1" style="font-size: 12px;"><span class="dyn-email">contacto@biofarma.pe</span></p>
                            <p class="text-muted mb-0" style="font-size: 10px;">Respuesta en menos de 24 horas</p>
                        </div>
                    </div>

                    <div style="background-color: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: flex-start; gap: 15px;">
                        <div style="background-color: #f0fdf4; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-comment text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">WhatsApp</h6>
                            <p class="text-muted mb-2" style="font-size: 10px;">Respuesta inmediata</p>
                            <a href="https://wa.me/<?= $global_wa ?>" target="_blank" class="btn text-white fw-bold py-1 px-3" style="background-color: #00A859; font-size: 11px; border-radius: 6px;">Chatear Ahora</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Success Layout (Hidden by default) -->
            <div id="success-layout" style="display: none; max-width: 500px; margin: 0 auto;">
                <div style="background-color: white; border-radius: 12px; padding: 40px 30px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); text-align: center;">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background-color: #e6f6ec; border: 3px solid #00A859; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fa-solid fa-check text-success" style="font-size: 30px;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">¡Mensaje enviado correctamente!</h4>
                    <p class="text-muted mb-4" style="font-size: 12px; line-height: 1.5; padding: 0 20px;">
                        Hemos recibido tu consulta y te responderemos a la brevedad posible. Normalmente respondemos en menos de 24 horas.
                    </p>
                    
                    <a href="index.php" class="btn w-100 fw-bold text-white mb-3 d-flex align-items-center justify-content-center gap-2" style="background-color: #00A859; border-radius: 8px; padding: 12px;">
                        <i class="fa-solid fa-house"></i> Volver al Inicio
                    </a>
                    
                    <a href="https://wa.me/<?= $global_wa ?>" target="_blank" class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: white; color: #00A859; border: 1px solid #00A859; border-radius: 8px; padding: 12px;">
                        <i class="fa-regular fa-comment"></i> O escríbenos por WhatsApp
                    </a>

                    <hr style="margin: 30px 0; border-color: #eaeaea;">
                    <p class="text-muted mb-0" style="font-size: 10px;">
                        Si necesitas atención inmediata, no dudes en llamarnos al <strong style="color: #00A859;"><span>+51 925 835 4599</span></strong>
                    </p>
                </div>
            </div>

        </div>
    </main>

    <!-- Professional Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Logic for Form Validation & Success -->
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent page reload

            // Inputs
            const inputNombre = document.getElementById('nombre');
            const inputCelular = document.getElementById('celular');
            const inputMensaje = document.getElementById('mensaje');

            // Error displays
            const errorAlert = document.getElementById('error-alert');
            const errorList = document.getElementById('error-list');
            const errNombre = document.getElementById('error-nombre');
            const errCelular = document.getElementById('error-celular');
            const errMensaje = document.getElementById('error-mensaje');

            // Reset errors
            errorList.innerHTML = '';
            errorAlert.style.display = 'none';
            inputNombre.classList.remove('error-border');
            inputCelular.classList.remove('error-border');
            inputMensaje.classList.remove('error-border');
            errNombre.style.display = 'none';
            errCelular.style.display = 'none';
            errMensaje.style.display = 'none';

            let hasErrors = false;
            let errors = [];

            if (inputNombre.value.trim() === '') {
                hasErrors = true;
                inputNombre.classList.add('error-border');
                errNombre.style.display = 'block';
                errors.push('El nombre es obligatorio');
            }

            if (inputCelular.value.trim() === '') {
                hasErrors = true;
                inputCelular.classList.add('error-border');
                errCelular.style.display = 'block';
                errors.push('El celular es obligatorio');
            }

            if (inputMensaje.value.trim() === '') {
                hasErrors = true;
                inputMensaje.classList.add('error-border');
                errMensaje.style.display = 'block';
                errors.push('El mensaje es obligatorio');
            }

            if (hasErrors) {
                // Show errors
                errors.forEach(err => {
                    let li = document.createElement('li');
                    li.textContent = err;
                    errorList.appendChild(li);
                });
                errorAlert.style.display = 'block';
            } else {
                // Prepare data
                const formData = {
                    nombre: inputNombre.value.trim(),
                    celular: inputCelular.value.trim(),
                    correo: document.getElementById('correo').value.trim(),
                    mensaje: inputMensaje.value.trim()
                };

                // Disable submit button while sending
                const submitBtn = document.querySelector('#contactForm button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Enviando...';
                submitBtn.disabled = true;

                // Send to API
                fetch('api_contacto.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success
                        document.getElementById('form-layout').style.display = 'none';
                        
                        // Update Banner
                        document.getElementById('banner-title').textContent = 'Mensaje Enviado';
                        document.getElementById('banner-subtitle').textContent = 'Gracias por contactarnos';

                        // Show Success Layout
                        document.getElementById('success-layout').style.display = 'block';
                    } else {
                        // Show error from API
                        errorList.innerHTML = `<li>${data.error || 'Error al enviar el mensaje'}</li>`;
                        errorAlert.style.display = 'block';
                    }
                })
                .catch(err => {
                    errorList.innerHTML = '<li>Error de conexión. Inténtalo de nuevo.</li>';
                    errorAlert.style.display = 'block';
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
            }
        });
    </script>

    

</body>
</html>

