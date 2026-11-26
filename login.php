<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Botica Biofarma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .login-hero {
            position: relative;
            height: calc(100vh - 350px);
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .login-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            filter: blur(2px);
        }
        .login-form-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }
        .login-input {
            background: transparent;
            border: none;
            border-bottom: 2px solid white;
            border-radius: 0;
            color: white;
            padding-left: 0;
        }
        .login-input:focus {
            background: transparent;
            color: white;
            box-shadow: none;
            border-bottom-color: #00A859;
        }
        .login-input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .login-label {
            color: white;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            width: 180px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header class="main-header">
        <div class="container header-container">
            <a href="index.php" class="logo-link text-decoration-none">
                <img src="img/Logo.png" alt="Biofarma Logo" class="logo" onerror="this.src='https://placehold.co/70x70/00A859/FFF?text=Icono'">
                <div class="logo-text">
                    <span class="logo-title">BIOFARMA</span>
                    <span class="logo-subtitle">Tu botica de confianza</span>
                </div>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">INICIO</a></li>
                    <li><a href="catalogo.php">CATÁLOGO</a></li>
                    <li><a href="ubicacion.php">UBICACIÓN</a></li>
                    <li><a href="nosotros.php">NOSOTROS</a></li>
                    <li><a href="contacto.php">CONTACTO</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <a href="https://wa.me/519258354599" class="whatsapp-header text-decoration-none" target="_blank">
                    <div class="whatsapp-icon-bg">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <span class="whatsapp-number">+51 925-835-4599</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Login Section -->
    <section class="login-hero flex-grow-1">
        <img src="img/PORTADA.png" alt="Fondo" class="login-bg" onerror="this.src='https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=2070&auto=format&fit=crop'">
        <div class="login-overlay"></div>

        <div class="login-form-container">
            <div id="login-alert" class="alert d-none" role="alert"></div>

            <form id="form-login" novalidate>
                <div class="d-flex align-items-end mb-4">
                    <label for="usuario" class="login-label fs-5 mb-1">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control login-input flex-grow-1" autocomplete="username">
                </div>
                <div class="d-flex align-items-end mb-4 position-relative">
                    <label for="password" class="login-label fs-5 mb-1">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control login-input flex-grow-1" autocomplete="current-password" style="padding-right: 35px;">
                    <i class="fa-solid fa-eye-slash position-absolute" id="togglePassword" style="right: 5px; bottom: 8px; cursor: pointer; color: rgba(255,255,255,0.7); font-size: 1.2rem;"></i>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-5">
                    <button type="submit" id="btn-entrar" class="btn btn-success px-5 py-2 fw-bold rounded-pill shadow">Entrar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="prof-footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 prof-footer-col">
                    <h4>Información</h4>
                    <ul class="prof-footer-list">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="nosotros.php">Nosotros</a></li>
                        <li><a href="politicas.php">Términos y condiciones</a></li>
                        <li><a href="politicas.php">Política de privacidad</a></li>
                        <li><a href="ubicacion.php">Locales</a></li>
                        <li><a href="contacto.php">Contáctanos</a></li>
                        <li><a href="catalogo.php">Catálogo digital</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 prof-footer-col">
                    <h4>Nuestros servicios</h4>
                    <ul class="prof-footer-list">
                        <li><a href="#">Delivery</a></li>
                        <li><a href="#">Venta corporativa</a></li>
                        <li><a href="#">Atención farmacéutica</a></li>
                        <li><a href="catalogo.php">Promociones</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 prof-footer-col">
                    <h4>Usuarios</h4>
                    <ul class="prof-footer-list">
                        <li><a href="login.php">Mi cuenta</a></li>
                        <li><a href="catalogo.php">Catálogo</a></li>
                        <li><a href="login.php">Iniciar sesión</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 prof-footer-col">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <img src="img/Logo.png" alt="Biofarma" style="height: 40px; filter: brightness(0) invert(1);">
                        <span style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; color: white; letter-spacing: 1px;">BIOFARMA</span>
                    </div>
                    <div class="prof-social-icons">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                    <a href="#" class="prof-libro-rec">
                        <i class="fa-solid fa-book-open"></i> Libro de reclamaciones
                    </a>
                    <div class="prof-payment-icons mt-3">
                        <img src="img/yape.png" alt="Yape" style="height: 28px; background: white; border-radius: 4px; padding: 2px 6px; object-fit: contain;">
                        <i class="fa-brands fa-cc-visa" style="font-size: 32px; color: white;"></i>
                        <i class="fa-brands fa-cc-mastercard" style="font-size: 32px; color: white;"></i>
                    </div>
                </div>
            </div>

            <div class="prof-footer-bottom">
                Botica Biofarma &copy; 2026 - Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/api_admin.js"></script>
    <script>
        if (BIOFARMA_API.getToken()) {
            window.location.href = "admin.php";
        }

        const alertBox = document.getElementById("login-alert");
        function mostrarMensajeLogin(texto, tipo) {
            alertBox.className = `alert alert-${tipo}`;
            alertBox.textContent = texto;
        }

        const params = new URLSearchParams(window.location.search);
        if (params.get("expired") === "1") {
            mostrarMensajeLogin("Tu sesión ha expirado. Inicia sesión nuevamente.", "warning");
        }

        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        document.getElementById("form-login").addEventListener("submit", async (e) => {
            e.preventDefault();
            const btn = document.getElementById("btn-entrar");
            btn.disabled = true;

            const usuario = document.getElementById("usuario").value.trim();
            const password = passwordInput.value;

            const res = await BIOFARMA_API.request("/auth/login", {
                method: "POST",
                permitir401: true,
                body: JSON.stringify({ usuario, password }),
            });

            btn.disabled = false;

            if (!res.ok) {
                const msg = BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo iniciar sesión");
                mostrarMensajeLogin(res.status ? `${msg} (${res.status})` : msg, "danger");
                return;
            }

            BIOFARMA_API.guardarSesion(res.datos);
            window.location.href = "admin.php";
        });
    </script>
</body>
</html>
