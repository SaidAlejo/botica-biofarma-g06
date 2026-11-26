// Cliente centralizado para consumir la API REST de Botica Biofarma con JWT
window.BIOFARMA_API = (() => {
  const BASE_URL = "http://localhost:3000/api/v1";

  function getToken() {
    return sessionStorage.getItem("token");
  }

  function getUsuario() {
    return sessionStorage.getItem("usuario") || "";
  }

  function getRol() {
    return sessionStorage.getItem("rol") || "";
  }

  function esAdmin() {
    return getRol() === "ADMIN";
  }

  function guardarSesion({ token, usuario, rol }) {
    sessionStorage.setItem("token", token);
    sessionStorage.setItem("usuario", usuario);
    sessionStorage.setItem("rol", rol);
  }

  function cerrarSesion(motivo = "") {
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("usuario");
    sessionStorage.removeItem("rol");
    const destino = motivo ? `login.php?${motivo}` : "login.php";
    window.location.href = destino;
  }

  function requerirSesion() {
    if (!getToken()) {
      window.location.href = "login.php";
      return false;
    }
    pintarInfoSidebar();
    aplicarPermisosRol();
    return true;
  }

  function pintarInfoSidebar() {
    const elUser = document.getElementById("sidebar-user-name");
    const elRol = document.getElementById("sidebar-user-role");
    if (elUser) elUser.textContent = getUsuario();
    if (elRol) {
      elRol.textContent = esAdmin() ? "Administrador" : "Operador";
    }
  }

  function aplicarPermisosRol() {
    if (!esAdmin()) {
      document.querySelectorAll("[data-solo-admin]").forEach((el) => {
        el.style.display = "none";
      });
    }
  }

  function mostrarAlerta(contenedorId, mensaje, tipo = "success", status = null) {
    const box = document.getElementById(contenedorId);
    if (!box) return;
    box.textContent = "";
    box.className = `bio-alert bio-alert-${tipo}`;
    box.style.display = "flex";

    const texto = document.createElement("span");
    texto.textContent = mensaje;
    box.appendChild(texto);

    if (status) {
      const badge = document.createElement("span");
      badge.className = "bio-status-tag";
      badge.textContent = `HTTP ${status}`;
      box.appendChild(badge);
    }
  }

  function ocultarAlerta(contenedorId) {
    const box = document.getElementById(contenedorId);
    if (box) box.style.display = "none";
  }

  function formatearMensajeError(datos, fallback) {
    if (datos && Array.isArray(datos.errores) && datos.errores.length > 0) {
      return `${datos.mensaje}: ${datos.errores.join(" · ")}`;
    }
    return (datos && datos.mensaje) || fallback;
  }

  async function request(ruta, opciones = {}) {
    const headers = {
      "Content-Type": "application/json",
      ...(opciones.headers || {}),
    };
    const token = getToken();
    if (token) {
      headers.Authorization = `Bearer ${token}`;
    }

    try {
      const respuesta = await fetch(`${BASE_URL}${ruta}`, {
        ...opciones,
        headers,
      });

      const datos = await respuesta.json().catch(() => ({}));

      if (respuesta.status === 401 && !opciones.permitir401) {
        cerrarSesion("expired=1");
        return { ok: false, status: 401, datos, expirado: true };
      }

      return { ok: respuesta.ok, status: respuesta.status, datos };
    } catch (error) {
      console.error("Error de conexión con la API:", error);
      return {
        ok: false,
        status: 0,
        datos: {
          mensaje: "No se pudo conectar con el servidor de Botica Biofarma.",
        },
      };
    }
  }

  return {
    BASE_URL,
    getToken,
    getUsuario,
    getRol,
    esAdmin,
    guardarSesion,
    cerrarSesion,
    requerirSesion,
    mostrarAlerta,
    ocultarAlerta,
    formatearMensajeError,
    request,
  };
})();
