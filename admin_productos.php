<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Panel Admin Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Gestión de Productos</h1>
                    <p id="subtitulo-total" class="page-subtitle">Cargando catálogo...</p>
                </div>
                <a href="admin_agregar_producto.php" class="btn-admin-primary" data-solo-admin>
                    <i class="fa-solid fa-plus"></i> Agregar Producto
                </a>
            </div>

            <div id="prod-alert" class="bio-alert"></div>

            <div class="admin-table-container">
                <div class="bio-toolbar">
                    <form id="form-buscar" class="bio-search-group">
                        <input type="text" id="input-buscar" class="form-control-admin" placeholder="Buscar por SKU, nombre, gramaje o categoría..." style="padding: 10px 14px;">
                        <button type="submit" class="btn-admin-primary" style="cursor: pointer; white-space: nowrap;">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </form>

                    <div class="bio-quick-select">
                        <select id="select-filtro-cat" class="form-control-admin" style="padding: 10px 12px;">
                            <option value="">Todas las categorías</option>
                        </select>
                        <select id="select-resumen-prod" class="form-control-admin" style="padding: 10px 12px;">
                            <option value="">Ver detalle de producto...</option>
                        </select>
                    </div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Categoría / Proveedor</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Receta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-productos"></tbody>
                </table>

                <div class="bio-pagination">
                    <button id="btn-anterior" type="button" class="btn-page">&laquo; Anterior</button>
                    <span id="texto-paginacion" style="font-size: 0.88rem; color: var(--text-muted);">Página 1 de 1</span>
                    <button id="btn-siguiente" type="button" class="btn-page">Siguiente &raquo;</button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Ajuste Rápido (PATCH: stock y/o precio) -->
    <div id="modal-patch" class="bio-modal">
        <div class="bio-modal-content" style="width: 420px;">
            <h3 style="margin-top: 0; color: var(--primary-color);">Ajuste Rápido de Inventario</h3>
            <p id="patch-nombre" style="color: var(--text-muted); font-size: 0.9rem; margin-top: -6px;"></p>
            <form id="form-patch" novalidate>
                <input type="hidden" id="patch-id">
                <div class="bio-grid-2">
                    <div>
                        <label class="form-label-admin" for="patch-precio">Precio (S/)</label>
                        <input type="number" step="0.01" id="patch-precio" class="form-control-admin" style="box-sizing: border-box;">
                    </div>
                    <div>
                        <label class="form-label-admin" for="patch-stock">Stock (uds)</label>
                        <input type="number" step="1" id="patch-stock" class="form-control-admin" style="box-sizing: border-box;">
                    </div>
                </div>
                <div class="bio-modal-actions">
                    <button type="button" class="btn-secondary-admin" onclick="cerrarModales()">Cancelar</button>
                    <button type="submit" class="btn-admin-primary" style="cursor: pointer;">Guardar Ajuste</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detalle (GET /:id) -->
    <div id="modal-detalle" class="bio-modal">
        <div class="bio-modal-content" style="width: 460px;">
            <h3 id="det-titulo" style="margin-top: 0; color: var(--primary-color);">Detalle del Producto</h3>
            <div id="det-cuerpo" style="font-size: 0.93rem; line-height: 1.7;"></div>
            <div class="bio-modal-actions">
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" onclick="cerrarModales()">Cerrar</button>
            </div>
        </div>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        const estado = { pagina: 1, limite: 5, totalPaginas: 1, buscar: "", categoriaId: "" };

        function cerrarModales() {
            document.getElementById("modal-patch").classList.remove("open");
            document.getElementById("modal-detalle").classList.remove("open");
        }

        function abrirPatch(prod) {
            document.getElementById("patch-id").value = prod.id;
            document.getElementById("patch-nombre").textContent = `${prod.sku} — ${prod.nombre}`;
            document.getElementById("patch-precio").value = prod.precio;
            document.getElementById("patch-stock").value = prod.stock;
            document.getElementById("modal-patch").classList.add("open");
        }

        async function verDetalle(id) {
            const res = await BIOFARMA_API.request(`/productos/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prod-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Producto no encontrado"), "danger", res.status);
                }
                return;
            }
            const p = res.datos;
            document.getElementById("det-titulo").textContent = p.nombre;
            const cuerpo = document.getElementById("det-cuerpo");
            cuerpo.textContent = "";
            const filas = [
                ["SKU", p.sku],
                ["Presentación", p.gramaje],
                ["Categoría", p.categoria_nombre],
                ["Proveedor", p.proveedor_nombre],
                ["Precio", `S/ ${Number(p.precio).toFixed(2)}`],
                ["Stock", `${p.stock} unidades`],
                ["Requiere receta", p.requiere_receta ? "Sí" : "No"],
            ];
            for (const [k, v] of filas) {
                const div = document.createElement("div");
                const strong = document.createElement("strong");
                strong.textContent = `${k}: `;
                div.append(strong, document.createTextNode(String(v)));
                cuerpo.appendChild(div);
            }
            document.getElementById("modal-detalle").classList.add("open");
        }

        async function eliminarProducto(prod) {
            if (!confirm(`¿Deseas retirar "${prod.nombre}" del catálogo activo?`)) return;
            const res = await BIOFARMA_API.request(`/productos/${prod.id}`, { method: "DELETE" });
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prod-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo eliminar"), "danger", res.status);
                }
                return;
            }
            BIOFARMA_API.mostrarAlerta("prod-alert", res.datos.mensaje, "success", res.status);
            await cargarResumenes();
            await cargarProductos();
        }

        function pintarTabla(datos) {
            const tbody = document.getElementById("tbody-productos");
            tbody.textContent = "";

            if (!datos || datos.length === 0) {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = 8;
                td.style.cssText = "text-align:center;padding:28px;color:var(--text-muted);";
                td.textContent = "No se encontraron productos activos.";
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            const admin = BIOFARMA_API.esAdmin();

            for (const p of datos) {
                const tr = document.createElement("tr");

                const tdSku = document.createElement("td");
                tdSku.style.color = "var(--text-muted)";
                tdSku.textContent = p.sku;

                const tdImg = document.createElement("td");
                const img = document.createElement("img");
                img.src = `img/${p.imagen || "default.png"}`;
                img.className = "product-img-cell";
                img.style.objectFit = "contain";
                img.onerror = function () { this.src = "https://placehold.co/50x50/f4f6f8/666?text=Img"; };
                tdImg.appendChild(img);

                const tdNom = document.createElement("td");
                const d1 = document.createElement("div");
                d1.style.fontWeight = "600";
                d1.textContent = p.nombre;
                const d2 = document.createElement("div");
                d2.style.cssText = "font-size:0.8rem;color:var(--text-muted);";
                d2.textContent = p.gramaje;
                tdNom.append(d1, d2);

                const tdRel = document.createElement("td");
                const c1 = document.createElement("div");
                c1.style.fontSize = "0.88rem";
                c1.textContent = p.categoria_nombre;
                const c2 = document.createElement("div");
                c2.style.cssText = "font-size:0.78rem;color:var(--text-muted);";
                c2.textContent = p.proveedor_nombre;
                tdRel.append(c1, c2);

                const tdPrecio = document.createElement("td");
                tdPrecio.style.fontWeight = "600";
                tdPrecio.textContent = `S/ ${Number(p.precio).toFixed(2)}`;

                const tdStock = document.createElement("td");
                const badge = document.createElement("span");
                badge.className = "badge-soft " + (p.stock > 50 ? "badge-green" : p.stock > 0 ? "" : "badge-red");
                if (p.stock > 0 && p.stock <= 50) {
                    badge.style.cssText = "background:#fff3e0;color:#f57c00;";
                }
                badge.textContent = `${p.stock} uds`;
                tdStock.appendChild(badge);

                const tdRec = document.createElement("td");
                tdRec.textContent = p.requiere_receta ? "Sí" : "No";

                const tdAcc = document.createElement("td");
                tdAcc.style.whiteSpace = "nowrap";

                const btnVer = document.createElement("button");
                btnVer.type = "button";
                btnVer.className = "btn-action-icon";
                btnVer.style.color = "#475569";
                btnVer.title = "Ver detalle";
                btnVer.innerHTML = '<i class="fa-regular fa-eye"></i>';
                btnVer.addEventListener("click", () => verDetalle(p.id));

                const btnPatch = document.createElement("button");
                btnPatch.type = "button";
                btnPatch.className = "btn-action-icon";
                btnPatch.style.color = "#00A859";
                btnPatch.title = "Ajuste rápido de precio / stock";
                btnPatch.innerHTML = '<i class="fa-solid fa-sliders"></i>';
                btnPatch.addEventListener("click", () => abrirPatch(p));

                tdAcc.append(btnVer, btnPatch);

                if (admin) {
                    const linkEdit = document.createElement("a");
                    linkEdit.href = `admin_editar_producto.php?id=${p.id}`;
                    linkEdit.className = "btn-action-icon";
                    linkEdit.style.color = "#1976d2";
                    linkEdit.title = "Editar producto";
                    linkEdit.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';

                    const btnDel = document.createElement("button");
                    btnDel.type = "button";
                    btnDel.className = "btn-action-icon";
                    btnDel.style.color = "#d32f2f";
                    btnDel.title = "Eliminar producto";
                    btnDel.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
                    btnDel.addEventListener("click", () => eliminarProducto(p));

                    tdAcc.append(linkEdit, btnDel);
                }

                tr.append(tdSku, tdImg, tdNom, tdRel, tdPrecio, tdStock, tdRec, tdAcc);
                tbody.appendChild(tr);
            }
        }

        async function cargarResumenes() {
            const [rCat, rProd] = await Promise.all([
                BIOFARMA_API.request("/categorias/resumen"),
                BIOFARMA_API.request("/productos/resumen"),
            ]);

            if (rCat.ok) {
                const selCat = document.getElementById("select-filtro-cat");
                const valorActual = selCat.value;
                selCat.textContent = "";
                const def = document.createElement("option");
                def.value = "";
                def.textContent = "Todas las categorías";
                selCat.appendChild(def);
                for (const c of rCat.datos) {
                    const opt = document.createElement("option");
                    opt.value = c.id;
                    opt.textContent = c.nombre;
                    selCat.appendChild(opt);
                }
                selCat.value = valorActual;
            }

            if (rProd.ok) {
                const selProd = document.getElementById("select-resumen-prod");
                selProd.textContent = "";
                const def = document.createElement("option");
                def.value = "";
                def.textContent = "Consulta rápida de producto...";
                selProd.appendChild(def);
                for (const p of rProd.datos) {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.nombre;
                    selProd.appendChild(opt);
                }
            }
        }

        async function cargarProductos() {
            const qs = new URLSearchParams({
                pagina: String(estado.pagina),
                limite: String(estado.limite),
            });
            if (estado.buscar) qs.set("buscar", estado.buscar);
            if (estado.categoriaId) qs.set("categoria_id", estado.categoriaId);

            const res = await BIOFARMA_API.request(`/productos?${qs.toString()}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prod-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al cargar productos"), "danger", res.status);
                }
                return;
            }

            const { pagina, total, totalPaginas, datos } = res.datos;
            estado.pagina = pagina;
            estado.totalPaginas = totalPaginas || 1;

            document.getElementById("subtitulo-total").textContent = `Total: ${total} producto(s) activos`;
            document.getElementById("texto-paginacion").textContent = `Página ${pagina} de ${estado.totalPaginas}`;
            document.getElementById("btn-anterior").disabled = pagina <= 1;
            document.getElementById("btn-siguiente").disabled = pagina >= estado.totalPaginas;

            pintarTabla(datos);
        }

        document.getElementById("form-buscar").addEventListener("submit", (e) => {
            e.preventDefault();
            estado.buscar = document.getElementById("input-buscar").value.trim();
            estado.pagina = 1;
            cargarProductos();
        });

        document.getElementById("select-filtro-cat").addEventListener("change", (e) => {
            estado.categoriaId = e.target.value;
            estado.pagina = 1;
            cargarProductos();
        });

        document.getElementById("select-resumen-prod").addEventListener("change", (e) => {
            if (e.target.value) {
                verDetalle(e.target.value);
                e.target.value = "";
            }
        });

        document.getElementById("btn-anterior").addEventListener("click", () => {
            if (estado.pagina > 1) {
                estado.pagina -= 1;
                cargarProductos();
            }
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            if (estado.pagina < estado.totalPaginas) {
                estado.pagina += 1;
                cargarProductos();
            }
        });

        document.getElementById("form-patch").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("patch-id").value;
            const precioVal = document.getElementById("patch-precio").value;
            const stockVal = document.getElementById("patch-stock").value;

            const cuerpo = {};
            if (precioVal !== "") cuerpo.precio = Number(precioVal);
            if (stockVal !== "") cuerpo.stock = Number(stockVal);

            const res = await BIOFARMA_API.request(`/productos/${id}`, {
                method: "PATCH",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prod-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al actualizar"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("prod-alert", res.datos.mensaje, "success", res.status);
            await cargarProductos();
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            const params = new URLSearchParams(window.location.search);
            if (params.get("msg") === "created") {
                BIOFARMA_API.mostrarAlerta("prod-alert", "Producto registrado correctamente.", "success", 201);
            } else if (params.get("msg") === "updated") {
                BIOFARMA_API.mostrarAlerta("prod-alert", "Producto actualizado correctamente.", "success", 200);
            }
            await cargarResumenes();
            await cargarProductos();
        })();
    </script>
</body>
</html>
