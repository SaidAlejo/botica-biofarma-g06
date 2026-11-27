<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores | Panel Admin Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Gestión de Proveedores</h1>
                    <p id="subtitulo-total" class="page-subtitle">Cargando proveedores...</p>
                </div>
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" data-solo-admin onclick="abrirModalCrear()">
                    <i class="fa-solid fa-plus"></i> Agregar Proveedor
                </button>
            </div>

            <div id="prov-alert" class="bio-alert"></div>

            <div class="admin-table-container">
                <div class="bio-toolbar">
                    <form id="form-buscar" class="bio-search-group">
                        <input type="text" id="input-buscar" class="form-control-admin" placeholder="Buscar por RUC, razón social, nombre comercial o correo..." style="padding: 10px 14px;">
                        <button type="submit" class="btn-admin-primary" style="cursor: pointer; white-space: nowrap;">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </form>

                    <div class="bio-quick-select">
                        <select id="select-resumen-prov" class="form-control-admin" style="padding: 10px 12px;">
                            <option value="">Consulta rápida de proveedor...</option>
                        </select>
                    </div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>RUC</th>
                            <th>Nombre Comercial / Razón Social</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-proveedores"></tbody>
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
            <h3 id="modal-titulo" style="margin-top: 0; color: var(--primary-color);">Nuevo Proveedor</h3>
            <form id="form-proveedor" novalidate>
                <input type="hidden" id="prov-id">
                <div class="bio-grid-2" style="margin-bottom: 14px;">
                    <div>
                        <label class="form-label-admin" for="prov-ruc">RUC (11 dígitos) *</label>
                        <input type="text" id="prov-ruc" class="form-control-admin" style="box-sizing: border-box;" placeholder="20512345678">
                    </div>
                    <div>
                        <label class="form-label-admin" for="prov-telefono">Teléfono *</label>
                        <input type="text" id="prov-telefono" class="form-control-admin" style="box-sizing: border-box;" placeholder="052-412350">
                    </div>
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="prov-razon">Razón Social *</label>
                    <input type="text" id="prov-razon" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: Droguería del Sur S.A.C.">
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="prov-comercial">Nombre Comercial *</label>
                    <input type="text" id="prov-comercial" class="form-control-admin" style="box-sizing: border-box;" placeholder="Ej: Droguería del Sur">
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="prov-correo">Correo Electrónico *</label>
                    <input type="email" id="prov-correo" class="form-control-admin" style="box-sizing: border-box;" placeholder="ventas@drogueria.pe">
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="prov-direccion">Dirección *</label>
                    <input type="text" id="prov-direccion" class="form-control-admin" style="box-sizing: border-box;" placeholder="Av. Industrial 450, Tacna">
                </div>
                <div class="bio-modal-actions">
                    <button type="button" class="btn-secondary-admin" onclick="cerrarModales()">Cancelar</button>
                    <button type="submit" id="btn-submit-prov" class="btn-admin-primary" style="cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ajuste Rápido (PATCH: telefono) -->
    <div id="modal-patch" class="bio-modal">
        <div class="bio-modal-content" style="width: 420px;">
            <h3 style="margin-top: 0; color: var(--primary-color);">Actualizar Teléfono</h3>
            <p id="patch-sub" style="color: var(--text-muted); font-size: 0.9rem; margin-top: -6px;"></p>
            <form id="form-patch" novalidate>
                <input type="hidden" id="patch-id">
                <label class="form-label-admin" for="patch-telefono">Nuevo Teléfono de Contacto</label>
                <input type="text" id="patch-telefono" class="form-control-admin" style="box-sizing: border-box;">
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
            <h3 id="det-titulo" style="margin-top: 0; color: var(--primary-color);">Detalle del Proveedor</h3>
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
            document.getElementById("prov-id").value = "";
            document.getElementById("form-proveedor").reset();
            document.getElementById("modal-titulo").textContent = "Nuevo Proveedor";
            document.getElementById("btn-submit-prov").textContent = "Guardar Proveedor";
            document.getElementById("modal-form").classList.add("open");
        }

        async function abrirModalEditar(id) {
            const res = await BIOFARMA_API.request(`/proveedores/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo cargar el proveedor"), "danger", res.status);
                }
                return;
            }
            const p = res.datos;
            document.getElementById("prov-id").value = p.id;
            document.getElementById("prov-ruc").value = p.ruc;
            document.getElementById("prov-razon").value = p.razon_social;
            document.getElementById("prov-comercial").value = p.nombre_comercial;
            document.getElementById("prov-telefono").value = p.telefono;
            document.getElementById("prov-correo").value = p.correo;
            document.getElementById("prov-direccion").value = p.direccion;
            document.getElementById("modal-titulo").textContent = "Editar Proveedor";
            document.getElementById("btn-submit-prov").textContent = "Actualizar Proveedor";
            document.getElementById("modal-form").classList.add("open");
        }

        function abrirPatch(prov) {
            document.getElementById("patch-id").value = prov.id;
            document.getElementById("patch-sub").textContent = `${prov.ruc} — ${prov.nombre_comercial}`;
            document.getElementById("patch-telefono").value = prov.telefono;
            document.getElementById("modal-patch").classList.add("open");
        }

        async function verDetalle(id) {
            const res = await BIOFARMA_API.request(`/proveedores/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Proveedor no encontrado"), "danger", res.status);
                }
                return;
            }
            const p = res.datos;
            document.getElementById("det-titulo").textContent = p.nombre_comercial;
            const cuerpo = document.getElementById("det-cuerpo");
            cuerpo.textContent = "";
            for (const [k, v] of [
                ["RUC", p.ruc],
                ["Razón Social", p.razon_social],
                ["Teléfono", p.telefono],
                ["Correo", p.correo],
                ["Dirección", p.direccion],
            ]) {
                const div = document.createElement("div");
                const strong = document.createElement("strong");
                strong.textContent = `${k}: `;
                div.append(strong, document.createTextNode(String(v)));
                cuerpo.appendChild(div);
            }
            document.getElementById("modal-detalle").classList.add("open");
        }

        async function eliminarProveedor(prov) {
            if (!confirm(`¿Deseas desactivar al proveedor "${prov.nombre_comercial}"?`)) return;
            const res = await BIOFARMA_API.request(`/proveedores/${prov.id}`, { method: "DELETE" });
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo eliminar"), "danger", res.status);
                }
                return;
            }
            BIOFARMA_API.mostrarAlerta("prov-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarProveedores();
        }

        function pintarTabla(datos) {
            const tbody = document.getElementById("tbody-proveedores");
            tbody.textContent = "";

            if (!datos || datos.length === 0) {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = 6;
                td.style.cssText = "text-align:center;padding:28px;color:var(--text-muted);";
                td.textContent = "No se encontraron proveedores activos.";
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            const admin = BIOFARMA_API.esAdmin();

            for (const p of datos) {
                const tr = document.createElement("tr");

                const tdRuc = document.createElement("td");
                tdRuc.style.color = "var(--text-muted)";
                tdRuc.textContent = p.ruc;

                const tdNom = document.createElement("td");
                const d1 = document.createElement("div");
                d1.style.fontWeight = "600";
                d1.textContent = p.nombre_comercial;
                const d2 = document.createElement("div");
                d2.style.cssText = "font-size:0.8rem;color:var(--text-muted);";
                d2.textContent = p.razon_social;
                tdNom.append(d1, d2);

                const tdTel = document.createElement("td");
                tdTel.textContent = p.telefono;

                const tdCor = document.createElement("td");
                tdCor.style.fontSize = "0.86rem";
                tdCor.textContent = p.correo;

                const tdDir = document.createElement("td");
                tdDir.style.cssText = "font-size:0.84rem;color:var(--text-muted);max-width:220px;";
                tdDir.textContent = p.direccion;

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
                btnPatch.title = "Actualizar teléfono rápido";
                btnPatch.innerHTML = '<i class="fa-solid fa-phone"></i>';
                btnPatch.addEventListener("click", () => abrirPatch(p));

                tdAcc.append(btnVer, btnPatch);

                if (admin) {
                    const btnEdit = document.createElement("button");
                    btnEdit.type = "button";
                    btnEdit.className = "btn-action-icon";
                    btnEdit.style.color = "#1976d2";
                    btnEdit.title = "Editar proveedor";
                    btnEdit.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';
                    btnEdit.addEventListener("click", () => abrirModalEditar(p.id));

                    const btnDel = document.createElement("button");
                    btnDel.type = "button";
                    btnDel.className = "btn-action-icon";
                    btnDel.style.color = "#d32f2f";
                    btnDel.title = "Eliminar proveedor";
                    btnDel.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
                    btnDel.addEventListener("click", () => eliminarProveedor(p));

                    tdAcc.append(btnEdit, btnDel);
                }

                tr.append(tdRuc, tdNom, tdTel, tdCor, tdDir, tdAcc);
                tbody.appendChild(tr);
            }
        }

        async function cargarResumen() {
            const res = await BIOFARMA_API.request("/proveedores/resumen");
            if (!res.ok) return;
            const sel = document.getElementById("select-resumen-prov");
            sel.textContent = "";
            const def = document.createElement("option");
            def.value = "";
            def.textContent = "Consulta rápida de proveedor...";
            sel.appendChild(def);
            for (const p of res.datos) {
                const opt = document.createElement("option");
                opt.value = p.id;
                opt.textContent = p.nombre;
                sel.appendChild(opt);
            }
        }

        async function cargarProveedores() {
            const qs = new URLSearchParams({
                pagina: String(estado.pagina),
                limite: String(estado.limite),
            });
            if (estado.buscar) qs.set("buscar", estado.buscar);

            const res = await BIOFARMA_API.request(`/proveedores?${qs.toString()}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al cargar proveedores"), "danger", res.status);
                }
                return;
            }

            const { pagina, total, totalPaginas, datos } = res.datos;
            estado.pagina = pagina;
            estado.totalPaginas = totalPaginas || 1;

            document.getElementById("subtitulo-total").textContent = `Total: ${total} proveedor(es) activos`;
            document.getElementById("texto-paginacion").textContent = `Página ${pagina} de ${estado.totalPaginas}`;
            document.getElementById("btn-anterior").disabled = pagina <= 1;
            document.getElementById("btn-siguiente").disabled = pagina >= estado.totalPaginas;

            pintarTabla(datos);
        }

        document.getElementById("form-buscar").addEventListener("submit", (e) => {
            e.preventDefault();
            estado.buscar = document.getElementById("input-buscar").value.trim();
            estado.pagina = 1;
            cargarProveedores();
        });

        document.getElementById("select-resumen-prov").addEventListener("change", (e) => {
            if (e.target.value) {
                verDetalle(e.target.value);
                e.target.value = "";
            }
        });

        document.getElementById("btn-anterior").addEventListener("click", () => {
            if (estado.pagina > 1) { estado.pagina -= 1; cargarProveedores(); }
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            if (estado.pagina < estado.totalPaginas) { estado.pagina += 1; cargarProveedores(); }
        });

        document.getElementById("form-proveedor").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("prov-id").value;
            const cuerpo = {
                ruc: document.getElementById("prov-ruc").value.trim(),
                razon_social: document.getElementById("prov-razon").value.trim(),
                nombre_comercial: document.getElementById("prov-comercial").value.trim(),
                telefono: document.getElementById("prov-telefono").value.trim(),
                correo: document.getElementById("prov-correo").value.trim(),
                direccion: document.getElementById("prov-direccion").value.trim(),
            };

            const res = await BIOFARMA_API.request(id ? `/proveedores/${id}` : "/proveedores", {
                method: id ? "PUT" : "POST",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al guardar proveedor"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("prov-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarProveedores();
        });

        document.getElementById("form-patch").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("patch-id").value;
            const telefono = document.getElementById("patch-telefono").value.trim();

            const res = await BIOFARMA_API.request(`/proveedores/${id}`, {
                method: "PATCH",
                body: JSON.stringify({ telefono }),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("prov-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al actualizar teléfono"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("prov-alert", res.datos.mensaje, "success", res.status);
            await cargarProveedores();
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            await cargarResumen();
            await cargarProveedores();
        })();
    </script>
</body>
</html>
