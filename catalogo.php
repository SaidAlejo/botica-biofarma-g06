<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | Botica Biofarma</title>
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
        .cat-filter-card {
            background: #ffffff;
            border: 1px solid #e2ece7;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 168, 89, 0.06);
            overflow: hidden;
        }
        .cat-filter-toggle {
            width: 100%;
            background: linear-gradient(135deg, #008f4c, #00A859);
            color: #ffffff;
            border: none;
            padding: 13px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .cat-filter-toggle:hover {
            opacity: 0.95;
        }
        .cat-filter-toggle .chevron {
            transition: transform 0.25s ease;
        }
        .cat-filter-toggle[aria-expanded="false"] .chevron {
            transform: rotate(-90deg);
        }
        .cat-filter-body {
            padding: 12px;
        }
        .cat-select-modern {
            width: 100%;
            border: 1.5px solid #cfe6d9;
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 13.5px;
            font-weight: 500;
            color: #1f2937;
            background-color: #f8fcfa;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .cat-select-modern:focus {
            outline: none;
            border-color: #00A859;
            box-shadow: 0 0 0 3px rgba(0, 168, 89, 0.15);
        }
        .cat-list-scroll {
            max-height: 250px;
            overflow-y: auto;
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .cat-pill-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            width: 100%;
            border: none;
            background: transparent;
            text-align: left;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 13px;
            color: #374151;
            cursor: pointer;
            transition: background-color 0.15s, color 0.15s;
        }
        .cat-pill-item:hover {
            background-color: #eef8f2;
            color: #008f4c;
        }
        .cat-pill-item.active {
            background-color: #e2f5ea;
            color: #007a40;
            font-weight: 600;
        }
        .cat-pill-count {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background-color: #e5e7eb;
            color: #4b5563;
            flex-shrink: 0;
        }
        .cat-pill-item.active .cat-pill-count {
            background-color: #00A859;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <main class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <aside id="catalog-sidebar" class="col-lg-3 col-md-4">
                <div class="cat-filter-card mb-4">
                    <button class="cat-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="true" aria-controls="collapseCategorias">
                        <span><i class="fa-solid fa-layer-group me-2"></i>Categorías</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="collapse show" id="collapseCategorias">
                        <div class="cat-filter-body">
                            <select id="categorySelect" class="cat-select-modern" aria-label="Seleccionar categoría">
                                <option value="">Todas las categorías</option>
                            </select>
                            <div id="categoryList" class="cat-list-scroll"></div>
                            <button id="btnResetFilters" type="button" class="btn btn-sm btn-outline-success w-100 mt-2 rounded-pill d-none" style="font-size: 12px; font-weight: 600;">
                                <i class="fa-solid fa-rotate-left me-1"></i> Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Banners -->
                <div class="promo-banner p-4 text-center rounded mb-4" style="background-color: #c9ebd8; border: none;">
                    <i class="fa-solid fa-basket-shopping text-success mb-2" style="font-size: 40px;"></i>
                    <h5 class="text-success fw-bold mt-2" style="font-size: 16px;">¡BIENVENIDO!</h5>
                    <p class="small fw-bold text-dark mt-3" style="font-size: 11px; line-height: 1.4;">APROVECHA UN 15% DE<br>DESCUENTO ADICIONAL EN<br>TU PRIMERA COMPRA DE<br>CUIDADO PERSONAL Y<br>PERFUMERÍA.</p>
                    <p class="text-muted mt-3 mb-4" style="font-size: 9px;">Válido en la web. Hasta fin de mes.</p>
                    <button id="btnVerTodo" type="button" class="btn w-100 rounded-pill fw-bold text-white" style="background-color: #1b8a53; font-size: 12px; padding: 10px;">VER CATÁLOGO</button>
                </div>
            </aside>

            <!-- Catalog -->
            <section id="catalog-main-content" class="col-lg-9 col-md-8">
                <!-- Search & Filters -->
                <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3" id="search-filter-bar">
                    <div class="price-filter flex-grow-1" style="max-width: 400px; padding-top: 10px;">
                        <h5 class="fw-bold text-center text-dark" style="font-size: 16px;">FILTRAR POR PRECIO</h5>
                        <div class="d-flex justify-content-between text-dark fw-bold" style="font-size: 11px; margin-bottom: 5px;">
                            <span>S/ 0.00</span>
                            <span>Precio máximo</span>
                            <span id="priceLabel">S/ 200</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="200" value="200" id="priceRange" style="accent-color: #00A859;">
                    </div>

                    <div class="d-flex flex-column align-items-end gap-2">
                        <a href="primeros_auxilios.php" class="btn text-white fw-bold rounded-pill px-3 py-1 d-flex align-items-center gap-2 text-decoration-none" style="background-color: #e93d44; font-size: 13px;">
                            <i class="fa-solid fa-plus-circle text-white bg-danger rounded-circle"></i> Primeros Auxilios
                        </a>
                        <div class="input-group mt-1" style="width: 240px; border-radius: 20px; overflow: hidden;">
                            <span class="input-group-text bg-success border-success text-white px-3" style="border-radius: 20px 0 0 20px;"><i class="fa-solid fa-bars"></i></span>
                            <input type="text" id="searchInput" class="form-control bg-success text-white border-success fw-bold placeholder-white text-center" placeholder="BÚSQUEDA" style="--bs-placeholder-color: rgba(255,255,255,0.85); font-size: 14px;">
                            <button id="searchButton" class="btn btn-success border-success px-3" type="button" style="border-radius: 0 20px 20px 0;"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Search Header (Hidden by default) -->
                <div id="search-header" class="mb-4" style="display: none; background-color: #00A859; padding: 20px; border-radius: 8px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass" style="font-size: 18px;"></i>
                                <span id="search-title">Resultados para: ""</span>
                            </h4>
                            <p id="search-count" class="text-white small mb-0" style="opacity: 0.9;">Encontramos 0 productos</p>
                        </div>
                        <button id="btnLimpiarBusqueda" type="button" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-success">
                            Volver al catálogo
                        </button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div id="product-grid">
                    <div class="text-center py-5">
                        <div class="spinner-border text-success" role="status"></div>
                        <p class="mt-2 text-muted">Cargando catálogo...</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Professional Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>
