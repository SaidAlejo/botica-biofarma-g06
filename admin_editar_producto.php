<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto | Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <a href="admin_productos.php" style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px;">
                <i class="fa-solid fa-arrow-left"></i> Volver al listado
            </a>

            <div class="page-header" style="margin-bottom: 20px;">
                <div>
                    <h1 class="page-title">Editar Producto</h1>
                    <p class="page-subtitle">Actualiza los datos completos del producto seleccionado</p>
                </div>
            </div>

            <div id="form-alert" class="bio-alert"></div>

            <div class="admin-card" style="max-width: 800px;">
                <form id="form-editar-producto" novalidate>
                    <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 20px;">
                        <img id="preview-img" src="https://placehold.co/90x90/f4f6f8/666?text=Img" alt="Producto" style="width: 90px; height: 90px; object-fit: contain; border-radius: 8px; border: 1px solid var(--border-color); background: #fff;">
                        <div style="flex-grow: 1;">
                            <label class="form-label-admin" for="imagen">Archivo de Imagen</label>
                            <input type="text" id="imagen" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: paracetamol_500mg.png">
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 20px;">
                        <div>
                            <label class="form-label-admin" for="nombre">Nombre del Producto *</label>
                            <input type="text" id="nombre" class="form-control-admin" style="box-sizing: border-box;">
                        </div>
                        <div>
                            <label class="form-label-admin" for="sku">SKU *</label>
                            <input type="text" id="sku" class="form-control-admin" style="box-sizing: border-box;">
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 20px;">
                        <div>
                            <label class="form-label-admin" for="gramaje">Gramaje / Presentación *</label>
                            <input type="text" id="gramaje" class="form-control-admin" style="box-sizing: border-box;">
                        </div>
                        <div>
                            <label class="form-label-admin" for="categoria_id">Categoría *</label>
                            <select id="categoria_id" class="form-control-admin" style="box-sizing: border-box;"></select>
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 24px;">
                        <div>
                            <label class="form-label-admin" for="proveedor_id">Proveedor / Laboratorio *</label>
                            <select id="proveedor_id" class="form-control-admin" style="box-sizing: border-box;"></select>
                        </div>
                        <div class="bio-grid-2">
                            <div>
                                <label class="form-label-admin" for="precio">Precio (S/) *</label>
                                <input type="number" step="0.01" id="precio" class="form-control-admin" style="box-sizing: border-box;">
                            </div>
                            <div>
                                <label class="form-label-admin" for="stock">Stock *</label>
                                <input type="number" step="1" id="stock" class="form-control-admin" style="box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; max-width: 300px; margin-bottom: 30px;">
                        <span style="font-size: 0.9rem; font-weight: 500;">Requiere Receta Médica</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="requiere_receta" value="1">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <button type="submit" id="btn-actualizar" class="btn-admin-primary" style="flex: 1; text-align: center; font-size: 1rem; cursor: pointer;">
                            <i class="fa-solid fa-arrows-rotate"></i> Actualizar Producto
                        </button>
                        <a href="admin_productos.php" class="btn-secondary-admin" style="flex: 1; text-align: center;">Cancelar</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        const params = new URLSearchParams(window.location.search);
        const productoId = params.get("id");

        document.getElementById("imagen").addEventListener("input", (e) => {
            const val = e.target.value.trim();
            document.getElementById("preview-img").src = val ? `img/${val}` : "https://placehold.co/90x90/f4f6f8/666?text=Img";
        });

        async function iniciar() {
            if (!BIOFARMA_API.requerirSesion()) return;
            if (!productoId) {
                window.location.href = "admin_productos.php";
                return;
            }

            const [rCat, rProv, rProd] = await Promise.all([
                BIOFARMA_API.request("/categorias/resumen"),
                BIOFARMA_API.request("/proveedores/resumen"),
                BIOFARMA_API.request(`/productos/${encodeURIComponent(productoId)}`),
            ]);

            if (rCat.ok) {
                const sel = document.getElementById("categoria_id");
                sel.textContent = "";
                for (const c of rCat.datos) {
                    const opt = document.createElement("option");
                    opt.value = c.id;
                    opt.textContent = c.nombre;
                    sel.appendChild(opt);
                }
            }

            if (rProv.ok) {
                const sel = document.getElementById("proveedor_id");
                sel.textContent = "";
                for (const p of rProv.datos) {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.nombre;
                    sel.appendChild(opt);
                }
            }

            if (!rProd.ok) {
                if (!rProd.expirado) {
                    BIOFARMA_API.mostrarAlerta("form-alert", BIOFARMA_API.formatearMensajeError(rProd.datos, "Producto no encontrado"), "danger", rProd.status);
                    document.getElementById("btn-actualizar").disabled = true;
                }
                return;
            }

            const prod = rProd.datos;
            document.getElementById("sku").value = prod.sku;
            document.getElementById("nombre").value = prod.nombre;
            document.getElementById("gramaje").value = prod.gramaje;
            document.getElementById("categoria_id").value = prod.categoria_id;
            document.getElementById("proveedor_id").value = prod.proveedor_id;
            document.getElementById("precio").value = prod.precio;
            document.getElementById("stock").value = prod.stock;
            document.getElementById("requiere_receta").checked = Boolean(prod.requiere_receta);
            document.getElementById("imagen").value = prod.imagen || "default.png";

            const prev = document.getElementById("preview-img");
            prev.src = `img/${prod.imagen || "default.png"}`;
            prev.onerror = function () { this.src = "https://placehold.co/90x90/f4f6f8/666?text=Img"; };

            if (!BIOFARMA_API.esAdmin()) {
                BIOFARMA_API.mostrarAlerta("form-alert", "No tienes permiso para editar productos completos.", "warning", 403);
                document.getElementById("btn-actualizar").disabled = true;
            }
        }

        document.getElementById("form-editar-producto").addEventListener("submit", async (e) => {
            e.preventDefault();
            const precioVal = document.getElementById("precio").value;
            const stockVal = document.getElementById("stock").value;

            const cuerpo = {
                sku: document.getElementById("sku").value.trim(),
                nombre: document.getElementById("nombre").value.trim(),
                gramaje: document.getElementById("gramaje").value.trim(),
                categoria_id: Number(document.getElementById("categoria_id").value),
                proveedor_id: Number(document.getElementById("proveedor_id").value),
                precio: precioVal === "" ? "" : Number(precioVal),
                stock: stockVal === "" ? "" : Number(stockVal),
                requiere_receta: document.getElementById("requiere_receta").checked ? 1 : 0,
                imagen: document.getElementById("imagen").value.trim() || "default.png",
            };

            const res = await BIOFARMA_API.request(`/productos/${encodeURIComponent(productoId)}`, {
                method: "PUT",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("form-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo actualizar el producto"), "danger", res.status);
                }
                return;
            }

            window.location.href = "admin_productos.php?msg=updated";
        });

        iniciar();
    </script>
</body>
</html>
