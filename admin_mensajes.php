<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes | Panel Admin Botica Biofarma</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Bandeja de Mensajes</h1>
                    <p id="subtitulo-mensajes" class="page-subtitle">Cargando mensajes...</p>
                </div>
            </div>

            <div id="msg-alert" class="bio-alert"></div>

            <div class="admin-table-container">
                <div class="bio-toolbar">
                    <form id="form-buscar" class="bio-search-group">
                        <input type="text" id="input-buscar" class="form-control-admin" placeholder="Buscar por nombre, celular, correo o mensaje..." style="padding: 10px 14px;">
                        <button type="submit" class="btn-admin-primary" style="cursor: pointer; white-space: nowrap;">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </form>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-mensajes"></tbody>
                </table>

                <div class="bio-pagination">
                    <button id="btn-anterior" type="button" class="btn-page">&laquo; Anterior</button>
                    <span id="texto-paginacion" style="font-size: 0.88rem; color: var(--text-muted);">Página 1 de 1</span>
                    <button id="btn-siguiente" type="button" class="btn-page">Siguiente &raquo;</button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Ver Mensaje -->
    <div id="modal-mensaje" class="bio-modal">
        <div class="bio-modal-content" style="width: 480px;">
            <h3 style="margin-top: 0; color: var(--primary-color);">Detalle del Mensaje</h3>
            <p style="margin: 6px 0;"><strong>De:</strong> <span id="modal-nombre"></span></p>
            <p style="margin: 6px 0;"><strong>Celular:</strong> <span id="modal-celular"></span></p>
            <p style="margin: 6px 0;"><strong>Correo:</strong> <span id="modal-correo"></span></p>
            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 14px 0;">
            <p id="modal-texto" style="white-space: pre-wrap; font-size: 0.94rem; color: #334155;"></p>
            <div class="bio-modal-actions">
                <button type="button" class="btn-admin-primary" style="cursor: pointer;" onclick="cerrarYMarcarLeido()">
                    Cerrar y Marcar Leído
                </button>
            </div>
        </div>
    </div>

    <script src="js/api_admin.js"></script>
    <script>
        const estado = { pagina: 1, limite: 10, totalPaginas: 1, buscar: "" };
        let mensajeActual = null;

        function formatearFecha(iso) {
            if (!iso) return "";
            const d = new Date(iso);
            return Number.isNaN(d.getTime()) ? String(iso) : d.toLocaleString("es-PE");
        }

        function verMensaje(msg) {
            mensajeActual = msg;
            document.getElementById("modal-nombre").textContent = msg.nombre;
            document.getElementById("modal-celular").textContent = msg.celular;
            document.getElementById("modal-correo").textContent = msg.correo || "No indicado";
            document.getElementById("modal-texto").textContent = msg.mensaje;
            document.getElementById("modal-mensaje").classList.add("open");
        }

        async function cerrarYMarcarLeido() {
            document.getElementById("modal-mensaje").classList.remove("open");
            if (mensajeActual && !mensajeActual.leido) {
                const res = await BIOFARMA_API.request(`/mensajes/${mensajeActual.id}`, {
                    method: "PATCH",
                    body: JSON.stringify({ leido: 1 }),
                });
                if (res.ok) {
                    BIOFARMA_API.mostrarAlerta("msg-alert", res.datos.mensaje, "success", res.status);
                    await cargarMensajes();
                }
            }
            mensajeActual = null;
        }

        async function eliminarMensaje(msg) {
            if (!confirm(`¿Deseas eliminar el mensaje de "${msg.nombre}"?`)) return;
            const res = await BIOFARMA_API.request(`/mensajes/${msg.id}`, { method: "DELETE" });
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("msg-alert", BIOFARMA_API.formatearMensajeError(res.datos, "No se pudo eliminar"), "danger", res.status);
                }
                return;
            }
            BIOFARMA_API.mostrarAlerta("msg-alert", res.datos.mensaje, "success", res.status);
            await cargarMensajes();
        }

        function pintarTabla(datos) {
            const tbody = document.getElementById("tbody-mensajes");
            tbody.textContent = "";

            if (!datos || datos.length === 0) {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.colSpan = 7;
                td.style.cssText = "text-align:center;padding:30px;color:var(--text-muted);";
                td.textContent = "No hay mensajes en la bandeja de entrada.";
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            const admin = BIOFARMA_API.esAdmin();

            for (const msg of datos) {
                const tr = document.createElement("tr");
                if (!msg.leido) tr.style.backgroundColor = "#f0fdf4";

                const tdEst = document.createElement("td");
                tdEst.style.color = !msg.leido ? "#00A859" : "var(--text-muted)";
                tdEst.innerHTML = `<i class="fa-regular ${!msg.leido ? "fa-envelope" : "fa-envelope-open"}"></i>`;

                const tdNom = document.createElement("td");
                tdNom.style.fontWeight = !msg.leido ? "700" : "500";
                tdNom.textContent = msg.nombre;

                const tdCor = document.createElement("td");
                tdCor.style.color = "var(--text-muted)";
                tdCor.textContent = msg.correo || "No indicado";

                const tdCel = document.createElement("td");
                tdCel.style.color = "var(--text-muted)";
                tdCel.textContent = msg.celular;

                const tdTxt = document.createElement("td");
                tdTxt.style.cssText = "color:var(--text-muted);max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;";
                tdTxt.textContent = msg.mensaje;

                const tdFec = document.createElement("td");
                tdFec.style.cssText = "color:var(--text-muted);font-size:0.82rem;white-space:nowrap;";
                tdFec.textContent = formatearFecha(msg.fecha_creacion);

                const tdAcc = document.createElement("td");
                tdAcc.style.whiteSpace = "nowrap";

                const btnVer = document.createElement("button");
                btnVer.type = "button";
                btnVer.className = "btn-admin-primary";
                btnVer.style.cssText = "padding:6px 12px;font-size:0.82rem;cursor:pointer;margin-right:6px;";
                btnVer.innerHTML = '<i class="fa-regular fa-eye"></i> Ver';
                btnVer.addEventListener("click", () => verMensaje(msg));
                tdAcc.appendChild(btnVer);

                if (admin) {
                    const btnDel = document.createElement("button");
                    btnDel.type = "button";
                    btnDel.className = "btn-action-icon";
                    btnDel.style.color = "#d32f2f";
                    btnDel.title = "Eliminar mensaje";
                    btnDel.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
                    btnDel.addEventListener("click", () => eliminarMensaje(msg));
                    tdAcc.appendChild(btnDel);
                }

                tr.append(tdEst, tdNom, tdCor, tdCel, tdTxt, tdFec, tdAcc);
                tbody.appendChild(tr);
            }
        }

        async function cargarMensajes() {
            const qs = new URLSearchParams({
                pagina: String(estado.pagina),
                limite: String(estado.limite),
            });
            if (estado.buscar) qs.set("buscar", estado.buscar);

            const res = await BIOFARMA_API.request(`/mensajes?${qs.toString()}`);
            if (!res.ok) {
                if (!res.expirado) {
                    BIOFARMA_API.mostrarAlerta("msg-alert", BIOFARMA_API.formatearMensajeError(res.datos, "Error al cargar mensajes"), "danger", res.status);
                }
                return;
            }

            const { pagina, total, noLeidos, totalPaginas, datos } = res.datos;
            estado.pagina = pagina;
            estado.totalPaginas = totalPaginas || 1;

            document.getElementById("subtitulo-mensajes").textContent = `${noLeidos} mensaje(s) sin leer · Total: ${total}`;
            document.getElementById("texto-paginacion").textContent = `Página ${pagina} de ${estado.totalPaginas}`;
            document.getElementById("btn-anterior").disabled = pagina <= 1;
            document.getElementById("btn-siguiente").disabled = pagina >= estado.totalPaginas;

            pintarTabla(datos);
        }

        document.getElementById("form-buscar").addEventListener("submit", (e) => {
            e.preventDefault();
            estado.buscar = document.getElementById("input-buscar").value.trim();
            estado.pagina = 1;
            cargarMensajes();
        });

        document.getElementById("btn-anterior").addEventListener("click", () => {
            if (estado.pagina > 1) { estado.pagina -= 1; cargarMensajes(); }
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            if (estado.pagina < estado.totalPaginas) { estado.pagina += 1; cargarMensajes(); }
        });

        (async () => {
            if (!BIOFARMA_API.requerirSesion()) return;
            await cargarMensajes();
        })();
    </script>
</body>
</html>
