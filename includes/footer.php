<footer class="prof-footer mt-auto">
    <div class="container">
        <div class="row">
            <!-- Columna 1 -->
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
            
            <!-- Columna 2 -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 prof-footer-col">
                <h4>Nuestros servicios</h4>
                <ul class="prof-footer-list">
                    <li><a href="#">Delivery</a></li>
                    <li><a href="#">Venta corporativa</a></li>
                    <li><a href="#">Atención farmacéutica</a></li>
                    <li><a href="catalogo.php">Promociones</a></li>
                    <li><a href="#">Sorteos</a></li>
                </ul>
            </div>
            
            <!-- Columna 3 -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 prof-footer-col">
                <h4>Usuarios</h4>
                <ul class="prof-footer-list">
                    <li><a href="login.php">Mi cuenta</a></li>
                    <li><a href="login.php">Mi carrito</a></li>
                    <li><a href="login.php">Entrar / Registrar</a></li>
                </ul>
            </div>
            
            <!-- Columna 4 -->
            <div class="col-lg-3 col-md-6 prof-footer-col">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <img src="img/Logo.png" alt="Biofarma" style="height: 40px; filter: brightness(0) invert(1);">
                    <span style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; color: white; letter-spacing: 1px;">BIOFARMA</span>
                </div>
                
                <div class="prof-social-icons">
                    <a href="#" class="dyn-facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="dyn-instagram"><i class="fa-brands fa-instagram"></i></a>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('api_config.php')
      .then(res => res.json())
      .then(data => {
          if(!data.error) {
              document.querySelectorAll('.dyn-whatsapp-text').forEach(el => el.textContent = data.whatsapp);
              document.querySelectorAll('.dyn-email').forEach(el => el.textContent = data.email);
              document.querySelectorAll('.dyn-direccion').forEach(el => el.textContent = data.direccion);
              document.querySelectorAll('.dyn-facebook').forEach(el => el.href = data.facebook);
              document.querySelectorAll('.dyn-instagram').forEach(el => el.href = data.instagram);
              document.querySelectorAll('.dyn-qr-image').forEach(el => el.src = 'img/' + data.yape_qr);
          }
      }).catch(err => console.error("Error fetching config:", err));
});
</script>
