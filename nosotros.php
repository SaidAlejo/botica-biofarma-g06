<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros | Botica Biofarma</title>
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
<body>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 400px; min-height: 400px;">
        <div class="hero-overlay"></div>
        <img src="img/PORTADA.png" alt="Interior botica" class="hero-bg" onerror="this.src='https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=2070&auto=format&fit=crop'">
        
        <div class="hero-top-bar">
            <a href="index.php" class="back-arrow"><i class="fa-solid fa-arrow-left-long"></i></a>
            <div class="right-actions">

                <a href="faq.php" class="btn-faq text-decoration-none">
                    <span class="faq-q">?</span> FAQ
                </a>
            </div>
        </div>

        <div class="container hero-content text-center mx-auto" style="transform: none; max-width: 800px;">
            <h1 class="hero-title">TU BOTICA DE CONFIANZA<br>EN EL BARRIO</h1>
            <p class="hero-subtitle">Atención personalizada, precios económicos. Abierto de 7am a 10pm.</p>
            <img src="img/latidos.png" alt="Cardiograma" style="height: 60px; width: auto;" class="mt-3" onerror="this.style.display='none'">
        </div>
    </section>

    <!-- Main Content -->
    <main class="container py-5" style="max-width: 900px; font-family: 'Inter', sans-serif; text-align: justify;">
        <h2 class="fw-bold mb-4" style="font-family: 'Poppins', sans-serif;">Nuestra Historia: Más que una botica, somos tus vecinos</h2>
        
        <p>Hace 3 años, Botica Biofarma abrió sus puertas con un propósito claro y fundamental: acercar la salud y el bienestar a todas las familias de nuestra comunidad. Nacimos con la visión de ser esa clásica "botica de barrio", un espacio donde el paciente no es solo un número de atención, sino un vecino al que llamamos por su nombre. Desde nuestro primer día de atención, asumimos el firme compromiso de ofrecer no solo medicamentos y productos de cuidado personal, sino también una atención humana, cálida y, sobre todo, personalizada. Entendemos perfectamente que cuando alguien acude a nuestro mostrador, muchas veces lo hace con preocupación por su salud o la de un ser querido; por ello, nos esforzamos en brindar un consejo sincero, una orientación clara y la tranquilidad de saber que su bienestar está en buenas manos.</p>

        <p>A lo largo de este tiempo, hemos crecido y evolucionado gracias a la confianza depositada por cada uno de los transeúntes y familias que nos visitan a diario. Nos enorgullece enormemente ser el primer punto de consulta para los malestares cotidianos, estar preparados para las temporadas de invierno y resfríos, y acompañar a nuestros pacientes mayores en el seguimiento de sus tratamientos. Nuestro equipo está conformado por personal técnico altamente capacitado y con una profunda vocación de servicio. Nos aseguramos de mantener un catálogo variado que incluye desde los medicamentos de marca más reconocidos hasta alternativas genéricas de calidad comprobada, garantizando así que el cuidado de la salud no sea un privilegio, sino un derecho accesible para todos los bolsillos de nuestra comunidad.</p>

        <p>En Botica Biofarma, no solo despachamos recetas; construimos lazos de confianza que perduran en el tiempo. Tu salud es nuestra prioridad, y tu bienestar, nuestra mayor satisfacción.</p>

        <h5 class="fw-bold mt-5 mb-2">Nuestra Misión</h5>
        <p>Brindar un servicio farmacéutico integral y de excelencia, proveyendo medicamentos, artículos de higiene y perfumería básica de la más alta calidad a precios justos y económicos. Buscamos mejorar la calidad de vida de nuestra comunidad a través de una dispensación responsable, asesoría ética y un trato empático que supere las expectativas de cada vecino que nos visita.</p>

        <h5 class="fw-bold mt-4 mb-2">Nuestra Visión</h5>
        <p>Consolidarnos como el establecimiento farmacéutico líder y de mayor confianza en nuestro sector. Aspiramos a ser reconocidos permanentemente por nuestra calidez humana, la disponibilidad de nuestro stock y nuestro inquebrantable compromiso con la salud preventiva y el bienestar integral de todas las familias de nuestro entorno.</p>

        <h5 class="fw-bold mt-4 mb-3">Nuestros Valores Institucionales</h5>
        <ul>
            <li class="mb-2"><strong>Confianza y Transparencia:</strong> Actuamos con total honestidad en cada recomendación, garantizando la procedencia, el buen almacenamiento y la vigencia de todos nuestros productos.</li>
            <li class="mb-2"><strong>Cercanía y Empatía:</strong> Tratamos a cada cliente con la misma dedicación y respeto que le brindaríamos a nuestra propia familia, escuchando activamente sus necesidades.</li>
            <li class="mb-2"><strong>Responsabilidad Social:</strong> Mantenemos precios competitivos y accesibles, entendiendo la realidad económica de nuestro entorno y apoyando el acceso a la salud.</li>
            <li class="mb-2"><strong>Vocación de Servicio:</strong> Trabajamos de 7:00 am a 10:00 pm con la mejor disposición, listos para ayudar, orientar y resolver las dudas de nuestros pacientes con una sonrisa.</li>
        </ul>
    </main>

    <!-- Professional Footer -->
    <?php include 'includes/footer.php'; ?>

    

</body>
</html>


