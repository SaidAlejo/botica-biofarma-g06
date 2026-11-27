<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Panel Admin Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Gestión de Clientes</h1>
                    <p id="subtitulo-total" class="page-subtitle">Cargando clientes...</p>
                </div>
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" data-solo-admin onclick="abrirModalCrear()">
                    <i class="fa-solid fa-plus"></i> Agregar Cliente
                </button>
            </div>

            <div id="cli-alert" class="bio-alert"></div>

            <div class="admin-table-container">
                <div class="bio-toolbar">
                    <form id="form-buscar" class="bio-search-group">
                        <input type="text" id="input-buscar" class="form-control-admin" placeholder="Buscar por DNI, nombres, apellidos o correo..." style="padding: 10px 14px;">
                        <button type="submit" class="btn-admin-primary" style="cursor: pointer; white-space: nowrap;">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </form>

                    <div class="bio-quick-select">
                        <select id="select-resumen-cli" class="form-control-admin" style="padding: 10px 12px;">
                            <option value="">Consulta rápida de cliente...</option>
                        </select>
                    </div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-clientes"></tbody>
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
            <h3 id="modal-titulo" style="margin-top: 0; color: var(--primary-color);">Nuevo Cliente</h3>
            <form id="form-cliente" novalidate>
                <input type="hidden" id="cli-id">
                <div class="bio-grid-2" style="margin-bottom: 14px;">
                    <div>
                        <label class="form-label-admin" for="cli-dni">DNI (8 dígitos) *</label>
                        <input type="text" id="cli-dni" class="form-control-admin" style="box-sizing: border-box;" placeholder="72894510">
                    </div>
                    <div>
                        <label class="form-label-admin" for="cli-telefono">Teléfono *</label>
                        <input type="text" id="cli-telefono" class="form-control-admin" style="box-sizing: border-box;" placeholder="952874123">
                    </div>
                </div>
                <div class="bio-grid-2" style="margin-bottom: 14px;">
                    <div>
                        <label class="form-label-admin" for="cli-nombres">Nombres *</label>
                        <input type="text" id="cli-nombres" class="form-control-admin" style="box-sizing: border-box;" placeholder="Claudia Sofía">
                    </div>
                    <div>
                        <label class="form-label-admin" for="cli-apellidos">Apellidos *</label>
                        <input type="text" id="cli-apellidos" class="form-control-admin" style="box-sizing: border-box;" placeholder="Valdivia Torres">
                    </div>
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="cli-correo">Correo Electrónico *</label>
                    <input type="email" id="cli-correo" class="form-control-admin" style="box-sizing: border-box;" placeholder="claudia@gmail.com">
                </div>
                <div style="margin-bottom: 14px;">
                    <label class="form-label-admin" for="cli-direccion">Dirección *</label>
                    <input type="text" id="cli-direccion" class="form-control-admin" style="box-sizing: border-box;" placeholder="Av. Bolognesi 450, Tacna">
                </div>
                <div class="bio-modal-actions">
                    <button type="button" class="btn-secondary-admin" onclick="cerrarModales()">Cancelar</button>
                    <button type="submit" id="btn-submit-cli" class="btn-admin-primary" style="cursor: pointer;">Guardar</button>
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
                <label class="form-label-admin" for="patch-telefono">Nuevo Teléfono</label>
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
            <h3 id="det-titulo" style="margin-top: 0; color: var(--primary-color);">Detalle del Cliente</h3>
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
            document.getElementById("cli-id").value = "";
            document.getElementById("form-cliente").reset();
            document.getElementById("modal-titulo").textContent = "Nuevo Cliente";
            document.getElementById("btn-submit-cli").textContent = "Guardar Cliente";
            document.getElementById("modal-form").classList.add("open");
        }

        async function abrirModalEditar(id) {
            const res = await BIOFARMA_API.request(`/clientes/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo cargar el cliente"), "danger", res.status);
                }
                return;
            }
            const c = res.datos;
            document.getElementById("cli-id").value = c.id;
            document.getElementById("cli-dni").value = c.dni;
            document.getElementById("cli-nombres").value = c.nombres;
            document.getElementById("cli-apellidos").value = c.apellidos;
            document.getElementById("cli-telefono").value = c.telefono;
            document.getElementById("cli-correo").value = c.correo;
            document.getElementById("cli-direccion").value = c.direccion;
            document.getElementById("modal-titulo").textContent = "Editar Cliente";
            document.getElementById("btn-submit-cli").textContent = "Actualizar Cliente";
            document.getElementById("modal-form").classList.add("open");
        }

        function abrirPatch(cli) {
            document.getElementById("patch-id").value = cli.id;
            document.getElementById("patch-sub").textContent = `${cli.dni} — ${cli.nombres} ${cli.apellidos}`;
            document.getElementById("patch-telefono").value = cli.telefono;
            document.getElementById("modal-patch").classList.add("open");
        }

        async function verDetalle(id) {
            const res = await BIOFARMA_API.request(`/clientes/${id}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Cliente no encontrado"), "danger", res.status);
                }
                return;
            }
            const c = res.datos;
            document.getElementById("det-titulo").textContent = `${c.nombres} ${c.apellidos}`;
            const cuerpo = document.getElementById("det-cuerpo");
            cuerpo.textContent = "";
            for (const [k, v] of [
                ["DNI", c.dni],
                ["Teléfono", c.telefono],
                ["Correo", c.correo],
                ["Dirección", c.direccion],
            ]) {
                const div = document.createElement("div");
                const strong = document.createElement("strong");
                strong.textContent = `${k}: `;
                div.append(strong, document.createTextNode(String(v)));
                cuerpo.appendChild(div);
            }
            document.getElementById("modal-detalle").classList.add("open");
        }

        async function eliminarCliente(cli) {
            if (!confirm(`¿Deseas desactivar al cliente "${cli.nombres} ${cli.apellidos}"?`)) return;
            const res = await BIOFARMA_API.request(`/clientes/${cli.id}`, { method: "DELETE" });
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo eliminar"), "danger", res.status);
                }
                return;
            }
            BIOFARMA_API.mostrarAlerta("cli-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarClientes();
        }

        function pintarTabla(datos) {
            const tbody = document.getElementById("tbody-clientes");
            tbody.textContent = "";

            if (!datos || datos.length === 0) {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = 6;
                td.style.cssText = "text-align:center;padding:28px;color:var(--text-muted);";
                td.textContent = "No se encontraron clientes activos.";
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            const admin = BIOFARMA_API.esAdmin();

            for (const c of datos) {
                const tr = document.createElement("tr");

                const tdDni = document.createElement("td");
                tdDni.style.color = "var(--text-muted)";
                tdDni.textContent = c.dni;

                const tdNom = document.createElement("td");
                tdNom.style.fontWeight = "600";
                tdNom.textContent = `${c.apellidos}, ${c.nombres}`;

                const tdTel = document.createElement("td");
                tdTel.textContent = c.telefono;

                const tdCor = document.createElement("td");
                tdCor.style.fontSize = "0.86rem";
                tdCor.textContent = c.correo;

                const tdDir = document.createElement("td");
                tdDir.style.cssText = "font-size:0.84rem;color:var(--text-muted);max-width:220px;";
                tdDir.textContent = c.direccion;

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
                btnPatch.title = "Actualizar teléfono rápido";
                btnPatch.innerHTML = '<i class="fa-solid fa-phone"></i>';
                btnPatch.addEventListener("click", () => abrirPatch(c));

                tdAcc.append(btnVer, btnPatch);

                if (admin) {
                    const btnEdit = document.createElement("button");
                    btnEdit.type = "button";
                    btnEdit.className = "btn-action-icon";
                    btnEdit.style.color = "#1976d2";
                    btnEdit.title = "Editar cliente";
                    btnEdit.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';
                    btnEdit.addEventListener("click", () => abrirModalEditar(c.id));

                    const btnDel = document.createElement("button");
                    btnDel.type = "button";
                    btnDel.className = "btn-action-icon";
                    btnDel.style.color = "#d32f2f";
                    btnDel.title = "Eliminar cliente";
                    btnDel.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
                    btnDel.addEventListener("click", () => eliminarCliente(c));

                    tdAcc.append(btnEdit, btnDel);
                }

                tr.append(tdDni, tdNom, tdTel, tdCor, tdDir, tdAcc);
                tbody.appendChild(tr);
            }
        }

        async function cargarResumen() {
            const res = await BIOFARMA_API.request("/clientes/resumen");
            if (!res.ok) return;
            const sel = document.getElementById("select-resumen-cli");
            sel.textContent = "";
            const def = document.createElement("option");
            def.value = "";
            def.textContent = "Consulta rápida de cliente...";
            sel.appendChild(def);
            for (const c of res.datos) {
                const opt = document.createElement("option");
                opt.value = c.id;
                opt.textContent = c.nombre;
                sel.appendChild(opt);
            }
        }

        async function cargarClientes() {
            const qs = new URLSearchParams({
                pagina: String(estado.pagina),
                limite: String(estado.limite),
            });
            if (estado.buscar) qs.set("buscar", estado.buscar);

            const res = await BIOFARMA_API.request(`/clientes?${qs.toString()}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al cargar clientes"), "danger", res.status);
                }
                return;
            }

            const { pagina, total, totalPaginas, datos } = res.datos;
            estado.pagina = pagina;
            estado.totalPaginas = totalPaginas || 1;

            document.getElementById("subtitulo-total").textContent = `Total: ${total} cliente(s) activos`;
            document.getElementById("texto-paginacion").textContent = `Página ${pagina} de ${estado.totalPaginas}`;
            document.getElementById("btn-anterior").disabled = pagina <= 1;
            document.getElementById("btn-siguiente").disabled = pagina >= estado.totalPaginas;

            pintarTabla(datos);
        }

        document.getElementById("form-buscar").addEventListener("submit", (e) => {
            e.preventDefault();
            estado.buscar = document.getElementById("input-buscar").value.trim();
            estado.pagina = 1;
            cargarClientes();
        });

        document.getElementById("select-resumen-cli").addEventListener("change", (e) => {
            if (e.target.value) {
                verDetalle(e.target.value);
                e.target.value = "";
            }
        });

        document.getElementById("btn-anterior").addEventListener("click", () => {
            if (estado.pagina > 1) { estado.pagina -= 1; cargarClientes(); }
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            if (estado.pagina < estado.totalPaginas) { estado.pagina += 1; cargarClientes(); }
        });

        document.getElementById("form-cliente").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("cli-id").value;
            const cuerpo = {
                dni: document.getElementById("cli-dni").value.trim(),
                nombres: document.getElementById("cli-nombres").value.trim(),
                apellidos: document.getElementById("cli-apellidos").value.trim(),
                telefono: document.getElementById("cli-telefono").value.trim(),
                correo: document.getElementById("cli-correo").value.trim(),
                direccion: document.getElementById("cli-direccion").value.trim(),
            };

            const res = await BIOFARMA_API.request(id ? `/clientes/${id}` : "/clientes", {
                method: id ? "PUT" : "POST",
                body: JSON.stringify(cuerpo),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al guardar cliente"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("cli-alert", res.datos.mensaje, "success", res.status);
            await cargarResumen();
            await cargarClientes();
        });

        document.getElementById("form-patch").addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("patch-id").value;
            const telefono = document.getElementById("patch-telefono").value.trim();

            const res = await BIOFARMA_API.request(`/clientes/${id}`, {
                method: "PATCH",
                body: JSON.stringify({ telefono }),
            });

            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("cli-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al actualizar teléfono"), "danger", res.status);
                }
                return;
            }

            cerrarModales();
            BIOFARMA_API.mostrarAlerta("cli-alert", res.datos.mensaje, "success", res.status);
            await cargarClientes();
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            await cargarResumen();
            await cargarClientes();
        })();
    </script>
</body>
</html>
