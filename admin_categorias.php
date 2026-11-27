<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías | Panel Admin Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Gestión de Categorías</h1>
                    <p id="subtitulo-total" class="page-subtitle">Cargando categorías...</p>
                </div>
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" data-solo-admin onclick="abrirModalCrear()">
                    <i class="fa-solid fa-plus"></i> Agregar Categoría
                </button>
            </div>

            <div id="cat-alert" class="bio-alert"></div>

            <div class="admin-table-container">
                <div class="bio-toolbar">
                    <form id="form-buscar" class="bio-search-group">
                        <input type="text" id="input-buscar" class="form-control-admin" placeholder="Buscar por código, nombre o pasillo..." style="padding: 10px 14px;">
                        <button type="submit" class="btn-admin-primary" style="cursor: pointer; white-space: nowrap;">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </form>

                    <div class="bio-quick-select">
                        <select id="select-resumen-cat" class="form-control-admin" style="padding: 10px 12px;">
                            <option value="">Consulta rápida de categoría...</option>
                        </select>
                    </div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Ubicación</th>
                            <th>Cadena de Frío</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-categorias"></tbody>
                </table>

                <div class="bio-pagination">
                    <button id="btn-anterior" type="button" class="btn-page">&laquo; Anterior</button>
                    <span id="texto-paginacion" style="font-size: 0.88rem; color: var(--text-muted);">Página 1 de 1</span>
                    <button id="btn-siguiente" type="button" class="btn-page">Siguiente &raquo;</button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Crear / Editar Completo (POST / PUT) -->
    <div id="modal-form" class="bio-modal">
        <div class="bio-modal-content">
            <h3 id="modal-titulo" style="margin-top: 0; color: var(--primary-color);">Nueva Categoría</h3>
            <form id="form-categoria" novalidate>
                <input type="hidden" id="cat-id">
                <div class="bio-grid-2" style="margin-bottom: 14px;">
                    <div>
                        <label class="form-label-admin" for="cat-codigo">Código *</label>
                        <input type="text" id="cat-codigo" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: CAT-OFT-11">
                    </div>
                    <div>
                        <label class="form-label-admin" for="cat-pasillo">Pasillo / Ubicación *</label>
                        <input type="text" id="cat-pasillo" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: Pasillo B - Estante 5">
                    </div>
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="cat-nombre">Nombre *</label>
                    <input type="text" id="cat-nombre" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: Oftalmología">
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label-admin" for="cat-descripcion">Descripción *</label>
                    <textarea id="cat-descripcion" rows="2" class="form-control-admin" style="box-sizing: border-box;" placeholder="Descripción de los productos de esta categoría"></textarea>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; max-width: 280px;">
                    <span style="font-size: 0.9rem; font-weight: 500;">Requiere Cadena de Frío</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="cat-frio" value="1">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="bio-modal-actions">
                    <button type="button" class="btn-secondary-admin" onclick="cerrarModales()">Cancelar</button>
                    <button type="submit" id="btn-submit-cat" class="btn-admin-primary" style="cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ajuste Rápido (PATCH: pasillo_ubicacion) -->
    <div id="modal-patch" class="bio-modal">
        <div class="bio-modal-content" style="width: 420px;">
            <h3 style="margin-top: 0; color: var(--primary-color);">Actualizar Ubicación</h3>
            <p id="patch-sub" style="color: var(--text-muted); font-size: 0.9rem; margin-top: -6px;"></p>
            <form id="form-patch" novalidate>
                <input type="hidden" id="patch-id">
                <label class="form-label-admin" for="patch-pasillo">Nuevo Pasillo / Ubicación</label>
                <input type="text" id="patch-pasillo" class="form-control-admin" style="box-sizing: border-box;">
                <div class="bio-modal-actions">
                    <button type="button" class="btn-secondary-admin" onclick="cerrarModales()">Cancelar</button>
                    <button type="submit" class="btn-admin-primary" style="cursor: pointer;">Guardar Cambio</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detalle (GET /:id) -->
    <div id="modal-detalle" class="bio-modal">
        <div class="bio-modal-content" style="width: 460px;">
            <h3 id="det-titulo" style="margin-top: 0; color: var(--primary-color);">Detalle de Categoría</h3>
            <div id="det-cuerpo" style="font-size: 0.93rem; line-height: 1.7;"></div>
            <div class="bio-modal-actions">
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" onclick="cerrarModales()">Cerrar</button>
            </div>
        </div>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        const estado = { pagina: 1, limite: 5, totalPaginas: 1, buscar: "" };

        function cerrarModales() {
            document.getElementById("modal-form").classList.remove("open");
            document.getElementById("modal-patch").classList.remove("open");
            document.getElementById("modal-detalle").classList.remove("open");
        }

        function abrirModalCrear() {
            document.getElementById("cat-id").value = "";
            document.getElementById("form-categoria").reset();
            document.getElementById("modal-titulo").textContent = "Nueva Categoría";
            document.getElementById("btn-submit-cat").textContent = "Guardar Categoría";
            document.getElementById("modal-form").classList.add("open");
        }

        async function abrirModalEditar(id) {
            const res = await BIOFARMA_API.request(`/categorias/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo cargar la categoría"), "danger", res.status);
                }
                return;
            }
            const c = res.datos;
            document.getElementById("cat-id").value = c.id;
            document.getElementById("cat-codigo").value = c.codigo;
            document.getElementById("cat-nombre").value = c.nombre;
            document.getElementById("cat-descripcion").value = c.descripcion;
            document.getElementById("cat-pasillo").value = c.pasillo_ubicacion;
            document.getElementById("cat-frio").checked = Boolean(c.requiere_frio);
            document.getElementById("modal-titulo").textContent = "Editar Categoría";
            document.getElementById("btn-submit-cat").textContent = "Actualizar Categoría";
            document.getElementById("modal-form").classList.add("open");
        }

        function abrirPatch(cat) {
            document.getElementById("patch-id").value = cat.id;
            document.getElementById("patch-sub").textContent = `${cat.codigo} — ${cat.nombre}`;
            document.getElementById("patch-pasillo").value = cat.pasillo_ubicacion;
            document.getElementById("modal-patch").classList.add("open");
        }

        async function verDetalle(id) {
            const res = await BIOFARMA_API.request(`/categorias/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Categoría no encontrada"), "danger", res.status);
                }
                return;
            }
            const c = res.datos;
            document.getElementById("det-titulo").textContent = c.nombre;
            const cuerpo = document.getElementById("det-cuerpo");
            cuerpo.textContent = "";
            for (const [k, v] of [
                ["Código", c.codigo],
                ["Descripción", c.descripcion],
                ["Ubicación", c.pasillo_ubicacion],
                ["Requiere frío", c.requiere_frio ? "Sí" : "No"],
            ]) {
                const div = document.createElement("div");
                const strong = document.createElement("strong");
                strong.textContent = `${k}: `;
                div.append(strong, document.createTextNode(String(v)));
                cuerpo.appendChild(div);
            }
            document.getElementById("modal-detalle").classList.add("open");
        }

        async function eliminarCategoria(cat) {
            if (!confirm(`¿Deseas desactivar la categoría "${cat.nombre}"?`)) return;
            const res = await BIOFARMA_API.request(`/categorias/${cat.id}`, { method: "DELETE" });
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo eliminar"), "danger", res.status);
                }
                return;
            }
            BIOFARMA_API.mostrarAlerta("cat-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarCategorias();
        }

        function pintarTabla(datos) {
            const tbody = document.getElementById("tbody-categorias");
            tbody.textContent = "";

            if (!datos || datos.length === 0) {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = 6;
                td.style.cssText = "text-align:center;padding:28px;color:var(--text-muted);";
                td.textContent = "No se encontraron categorías activas.";
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            const admin = BIOFARMA_API.esAdmin();

            for (const c of datos) {
                const tr = document.createElement("tr");

                const tdCod = document.createElement("td");
                tdCod.style.color = "var(--text-muted)";
                tdCod.textContent = c.codigo;

                const tdNom = document.createElement("td");
                tdNom.style.fontWeight = "600";
                tdNom.textContent = c.nombre;

                const tdDesc = document.createElement("td");
                tdDesc.style.cssText = "color:var(--text-muted);max-width:260px;font-size:0.86rem;";
                tdDesc.textContent = c.descripcion;

                const tdPas = document.createElement("td");
                tdPas.textContent = c.pasillo_ubicacion;

                const tdFrio = document.createElement("td");
                const badge = document.createElement("span");
                badge.className = "badge-soft " + (c.requiere_frio ? "badge-blue" : "badge-green");
                badge.textContent = c.requiere_frio ? "Refrigerado" : "Ambiente";
                tdFrio.appendChild(badge);

                const tdAcc = document.createElement("td");
                tdAcc.style.whiteSpace = "nowrap";

                const btnVer = document.createElement("button");
                btnVer.type = "button";
                btnVer.className = "btn-action-icon";
                btnVer.style.color = "#475569";
                btnVer.title = "Ver detalle";
                btnVer.innerHTML = '<i class="fa-regular fa-eye"></i>';
                btnVer.addEventListener("click", () => verDetalle(c.id));

                const btnPatch = document.createElement("button");
                btnPatch.type = "button";
                btnPatch.className = "btn-action-icon";
                btnPatch.style.color = "#00A859";
                btnPatch.title = "Actualizar ubicación rápida";
                btnPatch.innerHTML = '<i class="fa-solid fa-location-dot"></i>';
                btnPatch.addEventListener("click", () => abrirPatch(c));

                tdAcc.append(btnVer, btnPatch);

                if (admin) {
                    const btnEdit = document.createElement("button");
                    btnEdit.type = "button";
                    btnEdit.className = "btn-action-icon";
                    btnEdit.style.color = "#1976d2";
                    btnEdit.title = "Editar categoría";
                    btnEdit.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';
                    btnEdit.addEventListener("click", () => abrirModalEditar(c.id));

                    const btnDel = document.createElement("button");
                    btnDel.type = "button";
                    btnDel.className = "btn-action-icon";
                    btnDel.style.color = "#d32f2f";
                    btnDel.title = "Eliminar categoría";
                    btnDel.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
                    btnDel.addEventListener("click", () => eliminarCategoria(c));

                    tdAcc.append(btnEdit, btnDel);
                }

                tr.append(tdCod, tdNom, tdDesc, tdPas, tdFrio, tdAcc);
                tbody.appendChild(tr);
            }
        }

        async function cargarResumen() {
            const res = await BIOFARMA_API.request("/categorias/resumen");
            if (!res.ok) return;
            const sel = document.getElementById("select-resumen-cat");
            sel.textContent = "";
            const def = document.createElement("option");
            def.value = "";
            def.textContent = "Consulta rápida de categoría...";
            sel.appendChild(def);
            for (const c of res.datos) {
                const opt = document.createElement("option");
                opt.value = c.id;
                opt.textContent = c.nombre;
                sel.appendChild(opt);
            }
        }

        async function cargarCategorias() {
            const qs = new URLSearchParams({
                pagina: String(estado.pagina),
                limite: String(estado.limite),
            });
            if (estado.buscar) qs.set("buscar", estado.buscar);

            const res = await BIOFARMA_API.request(`/categorias?${qs.toString()}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al cargar categorías"), "danger", res.status);
                }
                return;
            }

            const { pagina, total, totalPaginas, datos } = res.datos;
            estado.pagina = pagina;
            estado.totalPaginas = totalPaginas || 1;

            document.getElementById("subtitulo-total").textContent = `Total: ${total} categoría(s) activas`;
            document.getElementById("texto-paginacion").textContent = `Página ${pagina} de ${estado.totalPaginas}`;
            document.getElementById("btn-anterior").disabled = pagina <= 1;
            document.getElementById("btn-siguiente").disabled = pagina >= estado.totalPaginas;

            pintarTabla(datos);
        }

        document.getElementById("form-buscar").addEventListener("submit", (e) => {
            e.preventDefault();
            estado.buscar = document.getElementById("input-buscar").value.trim();
            estado.pagina = 1;
            cargarCategorias();
        });

        document.getElementById("select-resumen-cat").addEventListener("change", (e) => {
            if (e.target.value) {
                verDetalle(e.target.value);
                e.target.value = "";
            }
        });

        document.getElementById("btn-anterior").addEventListener("click", () => {
            if (estado.pagina > 1) { estado.pagina -= 1; cargarCategorias(); }
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            if (estado.pagina < estado.totalPaginas) { estado.pagina += 1; cargarCategorias(); }
        });

        document.getElementById("form-categoria").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("cat-id").value;
            const cuerpo = {
                codigo: document.getElementById("cat-codigo").value.trim(),
                nombre: document.getElementById("cat-nombre").value.trim(),
                descripcion: document.getElementById("cat-descripcion").value.trim(),
                pasillo_ubicacion: document.getElementById("cat-pasillo").value.trim(),
                requiere_frio: document.getElementById("cat-frio").checked ? 1 : 0,
            };

            const res = await BIOFARMA_API.request(id ? `/categorias/${id}` : "/categorias", {
                method: id ? "PUT" : "POST",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al guardar categoría"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("cat-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarCategorias();
        });

        document.getElementById("form-patch").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("patch-id").value;
            const pasillo_ubicacion = document.getElementById("patch-pasillo").value.trim();

            const res = await BIOFARMA_API.request(`/categorias/${id}`, {
                method: "PATCH",
                body: JSON.stringify({ pasillo_ubicacion }),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cat-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al actualizar ubicación"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("cat-alert", res.datos.mensaje, "success", res.status);
            await cargarCategorias();
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            await cargarResumen();
            await cargarCategorias();
        })();
    </script>
</body>
</html>
