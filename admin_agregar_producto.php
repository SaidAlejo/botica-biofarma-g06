<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto | Botica Biofarma</title>
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
                    <h1 class="page-title">Agregar Nuevo Producto</h1>
                    <p class="page-subtitle">Completa los datos del producto farmacéutico</p>
                </div>
            </div>

            <div id="form-alert" class="bio-alert"></div>

            <div class="admin-card" style="max-width: 800px;">
                <form id="form-agregar-producto" novalidate>
                    <div class="bio-grid-2" style="margin-bottom: 20px;">
                        <div>
                            <label class="form-label-admin" for="nombre">Nombre del Producto *</label>
                            <input type="text" id="nombre" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: Paracetamol 500mg Caja x 100">
                        </div>
                        <div>
                            <label class="form-label-admin" for="sku">SKU *</label>
                            <input type="text" id="sku" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: BIO-MED-015">
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 20px;">
                        <div>
                            <label class="form-label-admin" for="gramaje">Gramaje / Presentación *</label>
                            <input type="text" id="gramaje" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: 500 mg, 120 ml, Caja x 20">
                        </div>
                        <div>
                            <label class="form-label-admin" for="imagen">Archivo de Imagen (opcional)</label>
                            <input type="text" id="imagen" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: paracetamol_500mg.png">
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 20px;">
                        <div>
                            <label class="form-label-admin" for="categoria_id">Categoría *</label>
                            <select id="categoria_id" class="form-control-admin" style="box-sizing: border-box;">
                                <option value="">Cargando categorías...</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label-admin" for="proveedor_id">Proveedor / Laboratorio *</label>
                            <select id="proveedor_id" class="form-control-admin" style="box-sizing: border-box;">
                                <option value="">Cargando proveedores...</option>
                            </select>
                        </div>
                    </div>

                    <div class="bio-grid-2" style="margin-bottom: 24px;">
                        <div>
                            <label class="form-label-admin" for="precio">Precio (S/) *</label>
                            <input type="number" step="0.01" id="precio" class="form-control-admin" style="box-sizing: border-box;" placeholder="0.00">
                        </div>
                        <div>
                            <label class="form-label-admin" for="stock">Stock Inicial *</label>
                            <input type="number" step="1" id="stock" class="form-control-admin" style="box-sizing: border-box;" placeholder="0">
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
                        <button type="submit" id="btn-guardar" class="btn-admin-primary" style="flex: 1; text-align: center; font-size: 1rem; cursor: pointer;">
                            <i class="fa-regular fa-floppy-disk"></i> Guardar Producto
                        </button>
                        <a href="admin_productos.php" class="btn-secondary-admin" style="flex: 1; text-align: center;">Cancelar</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        async function cargarSelects() {
            const [rCat, rProv] = await Promise.all([
                BIOFARMA_API.request("/categorias/resumen"),
                BIOFARMA_API.request("/proveedores/resumen"),
            ]);

            if (rCat.ok) {
                const sel = document.getElementById("categoria_id");
                sel.textContent = "";
                const def = document.createElement("option");
                def.value = "";
                def.textContent = "Seleccionar categoría...";
                sel.appendChild(def);
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
                const def = document.createElement("option");
                def.value = "";
                def.textContent = "Seleccionar proveedor...";
                sel.appendChild(def);
                for (const p of rProv.datos) {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.nombre;
                    sel.appendChild(opt);
                }
            }
        }

        document.getElementById("form-agregar-producto").addEventListener("submit", async (e) => {
            e.preventDefault();
            const precioVal = document.getElementById("precio").value;
            const stockVal = document.getElementById("stock").value;
            const catVal = document.getElementById("categoria_id").value;
            const provVal = document.getElementById("proveedor_id").value;

            const cuerpo = {
                sku: document.getElementById("sku").value.trim(),
                nombre: document.getElementById("nombre").value.trim(),
                gramaje: document.getElementById("gramaje").value.trim(),
                categoria_id: catVal === "" ? "" : Number(catVal),
                proveedor_id: provVal === "" ? "" : Number(provVal),
                precio: precioVal === "" ? "" : Number(precioVal),
                stock: stockVal === "" ? "" : Number(stockVal),
                requiere_receta: document.getElementById("requiere_receta").checked ? 1 : 0,
                imagen: document.getElementById("imagen").value.trim() || "default.png",
            };

            const res = await BIOFARMA_API.request("/productos", {
                method: "POST",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("form-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo registrar el producto"), "danger", res.status);
                }
                return;
            }

            window.location.href = "admin_productos.php?msg=created";
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            if (!BIOFARMA_API.esAdmin()) {
                BIOFARMA_API.mostrarAlerta("form-alert", "No tienes permiso para registrar nuevos productos.", "warning", 403);
                document.getElementById("btn-guardar").disabled = true;
            }
            await cargarSelects();
        })();
    </script>
</body>
</html>
