const REGEX_DNI = /^\d{8}$/;
const REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

export const validarCliente = (req, res, next) => {
  const { dni, nombres, apellidos, telefono, correo, direccion } =
    req.body ?? {};
  const errores = [];

  if (typeof dni !== "string" || !REGEX_DNI.test(dni.trim())) {
    errores.push("El DNI es obligatorio y debe tener exactamente 8 dígitos");
  }

  if (typeof nombres !== "string" || !nombres.trim()) {
    errores.push("Los nombres son obligatorios");
  } else if (nombres.trim().length > 100) {
    errores.push("Los nombres admiten máximo 100 caracteres");
  }

  if (typeof apellidos !== "string" || !apellidos.trim()) {
    errores.push("Los apellidos son obligatorios");
  } else if (apellidos.trim().length > 100) {
    errores.push("Los apellidos admiten máximo 100 caracteres");
  }

  if (typeof telefono !== "string" || !telefono.trim()) {
    errores.push("El teléfono es obligatorio");
  } else if (telefono.trim().length > 20) {
    errores.push("El teléfono admite máximo 20 caracteres");
  }

  if (typeof correo !== "string" || !REGEX_EMAIL.test(correo.trim())) {
    errores.push("El correo es obligatorio y debe tener formato válido");
  } else if (correo.trim().length > 120) {
    errores.push("El correo admite máximo 120 caracteres");
  }

  if (typeof direccion !== "string" || !direccion.trim()) {
    errores.push("La dirección es obligatoria");
  } else if (direccion.trim().length > 200) {
    errores.push("La dirección admite máximo 200 caracteres");
  }

  if (errores.length > 0) {
    return res.status(400).json({ mensaje: "Datos inválidos", errores });
  }

  next();
};
