<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Resumen general de Botica Biofarma</p>
                </div>
                <a href="admin_agregar_producto.php" class="btn-admin-primary" data-solo-admin>
                    <i class="fa-solid fa-plus"></i> Nuevo Producto
                </a>
            </div>

            <div id="dash-alert" class="bio-alert"></div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div>
                        <div class="stat-icon green"><i class="fa-solid fa-box"></i></div>
                        <p class="stat-label">Total de Productos</p>
                        <p class="stat-desc">Activos en catálogo</p>
                    </div>
                    <h2 id="stat-productos" class="stat-value green">—</h2>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-icon blue"><i class="fa-solid fa-folder"></i></div>
                        <p class="stat-label">Categorías</p>
                        <p class="stat-desc">Activas</p>
                    </div>
                    <h2 id="stat-categorias" class="stat-value blue">—</h2>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-icon orange"><i class="fa-solid fa-truck-medical"></i></div>
                        <p class="stat-label">Proveedores</p>
                        <p class="stat-desc">Laboratorios activos</p>
                    </div>
                    <h2 id="stat-proveedores" class="stat-value orange">—</h2>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-icon red"><i class="fa-solid fa-users"></i></div>
                        <p class="stat-label">Clientes</p>
                        <p class="stat-desc">Registrados activos</p>
                    </div>
                    <h2 id="stat-clientes" class="stat-value red">—</h2>
                </div>
            </div>

            <div class="bio-grid-2">
                <!-- Productos con Stock Bajo -->
                <div class="admin-card" style="margin: 0;">
                    <h3 style="margin-top: 0; font-size: 1.1rem; margin-bottom: 20px;">Productos con Stock Bajo (&lt; 50 uds)</h3>
                    <div id="lista-stock-bajo" style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="color: #637381;">Cargando inventario...</div>
                    </div>
                </div>

                <!-- Accesos rápidos -->
                <div class="admin-card" style="margin: 0;">
                    <h3 style="margin-top: 0; font-size: 1.1rem; margin-bottom: 20px;">Accesos Rápidos de Gestión</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="admin_productos.php" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-dark);">
                            <span><i class="fa-solid fa-box" style="color: #00A859; width: 24px;"></i> Gestionar Productos e Inventario</span>
                            <i class="fa-solid fa-chevron-right" style="color: #94a3b8;"></i>
                        </a>
                        <a href="admin_categorias.php" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-dark);">
                            <span><i class="fa-solid fa-folder" style="color: #1976d2; width: 24px;"></i> Administrar Categorías y Pasillos</span>
                            <i class="fa-solid fa-chevron-right" style="color: #94a3b8;"></i>
                        </a>
                        <a href="admin_proveedores.php" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-dark);">
                            <span><i class="fa-solid fa-truck-medical" style="color: #f57c00; width: 24px;"></i> Directorio de Proveedores</span>
                            <i class="fa-solid fa-chevron-right" style="color: #94a3b8;"></i>
                        </a>
                        <a href="admin_clientes.php" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-dark);">
                            <span><i class="fa-solid fa-users" style="color: #d32f2f; width: 24px;"></i> Registro de Clientes</span>
                            <i class="fa-solid fa-chevron-right" style="color: #94a3b8;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        async function cargarDashboard() {
            if (!BIOFARMA_API.requerirSesion()) return;

            const [rProd, rCat, rProv, rCli] = await Promise.all([
                BIOFARMA_API.request("/productos?pagina=1&limite=50"),
                BIOFARMA_API.request("/categorias?pagina=1&limite=1"),
                BIOFARMA_API.request("/proveedores?pagina=1&limite=1"),
                BIOFARMA_API.request("/clientes?pagina=1&limite=1"),
            ]);

            if (!rProd.ok) {
                if (!rProd.expirado) {
                    BIOFARMA_API.mostrarAlerta("dash-alert", BIOFARMA_API.formatearMensajeError(rProd.datos, "Error al cargar el resumen"), "danger", rProd.status);
                }
                return;
            }

            document.getElementById("stat-productos").textContent = rProd.datos.total ?? 0;
            document.getElementById("stat-categorias").textContent = rCat.ok ? (rCat.datos.total ?? 0) : "—";
            document.getElementById("stat-proveedores").textContent = rProv.ok ? (rProv.datos.total ?? 0) : "—";
            document.getElementById("stat-clientes").textContent = rCli.ok ? (rCli.datos.total ?? 0) : "—";

            const contenedor = document.getElementById("lista-stock-bajo");
            contenedor.textContent = "";

            const bajos = (rProd.datos.datos || [])
                .filter((p) => Number(p.stock) < 50)
                .sort((a, b) => a.stock - b.stock)
                .slice(0, 5);

            if (bajos.length === 0) {
                const vacio = document.createElement("div");
                vacio.style.color = "#637381";
                vacio.style.fontStyle = "italic";
                vacio.textContent = "No hay productos con stock bajo. Todos superan las 50 unidades.";
                contenedor.appendChild(vacio);
                return;
            }

            for (const prod of bajos) {
                const fila = document.createElement("div");
                fila.style.cssText = "display:flex;align-items:center;justify-content:space-between;gap:12px;";

                const izq = document.createElement("div");
                izq.style.cssText = "display:flex;align-items:center;gap:12px;";

                const img = document.createElement("img");
                img.src = `img/${prod.imagen || "default.png"}`;
                img.className = "product-img-cell";
                img.style.cssText = "width:42px;height:42px;object-fit:contain;border-radius:6px;";
                img.onerror = function () { this.src = "https://placehold.co/42x42/f4f6f8/666?text=Img"; };

                const info = document.createElement("div");
                const nom = document.createElement("div");
                nom.style.cssText = "font-weight:600;font-size:0.9rem;";
                nom.textContent = prod.nombre;
                const sku = document.createElement("div");
                sku.style.cssText = "color:var(--text-muted);font-size:0.8rem;";
                sku.textContent = `${prod.sku} · ${prod.categoria_nombre}`;
                info.append(nom, sku);

                izq.append(img, info);

                const der = document.createElement("div");
                der.style.cssText = `color:${prod.stock === 0 ? "#d32f2f" : "#f57c00"};font-weight:700;font-size:0.9rem;white-space:nowrap;`;
                der.textContent = `${prod.stock} uds`;

                fila.append(izq, der);
                contenedor.appendChild(fila);
            }
        }

        cargarDashboard();
    </script>
</body>
</html>
