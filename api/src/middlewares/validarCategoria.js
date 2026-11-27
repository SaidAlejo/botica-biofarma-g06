export const validarCategoria = (req, res, next) => {
  const { codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio } =
    req.body ?? {};
  const errores = [];

  if (typeof codigo !== "string" || !codigo.trim()) {
    errores.push("El código es obligatorio");
  } else if (codigo.trim().length > 20) {
    errores.push("El código admite máximo 20 caracteres");
  }

  if (typeof nombre !== "string" || !nombre.trim()) {
    errores.push("El nombre es obligatorio");
  } else if (nombre.trim().length > 100) {
    errores.push("El nombre admite máximo 100 caracteres");
  }

  if (typeof descripcion !== "string" || !descripcion.trim()) {
    errores.push("La descripción es obligatoria");
  } else if (descripcion.trim().length > 255) {
    errores.push("La descripción admite máximo 255 caracteres");
  }

  if (typeof pasillo_ubicacion !== "string" || !pasillo_ubicacion.trim()) {
    errores.push("El pasillo de ubicación es obligatorio");
  } else if (pasillo_ubicacion.trim().length > 60) {
    errores.push("El pasillo de ubicación admite máximo 60 caracteres");
  }

  if (
    requiere_frio !== undefined &&
    ![0, 1, true, false].includes(requiere_frio)
  ) {
    errores.push("requiere_frio debe ser 0 o 1");
  }

  if (errores.length > 0) {
    return res.status(400).json({ mensaje: "Datos inválidos", errores });
  }

  next();
};
