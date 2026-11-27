const REGEX_RUC = /^\d{11}$/;
const REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

export const validarProveedor = (req, res, next) => {
  const { ruc, razon_social, nombre_comercial, telefono, correo, direccion } =
    req.body ?? {};
  const errores = [];

  if (typeof ruc !== "string" || !REGEX_RUC.test(ruc.trim())) {
    errores.push("El RUC es obligatorio y debe tener exactamente 11 dígitos");
  }

  if (typeof razon_social !== "string" || !razon_social.trim()) {
    errores.push("La razón social es obligatoria");
  } else if (razon_social.trim().length > 150) {
    errores.push("La razón social admite máximo 150 caracteres");
  }

  if (typeof nombre_comercial !== "string" || !nombre_comercial.trim()) {
    errores.push("El nombre comercial es obligatorio");
  } else if (nombre_comercial.trim().length > 120) {
    errores.push("El nombre comercial admite máximo 120 caracteres");
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
