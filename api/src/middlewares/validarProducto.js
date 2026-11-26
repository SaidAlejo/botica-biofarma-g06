export const validarProducto = (req, res, next) => {
  const {
    sku,
    nombre,
    gramaje,
    categoria_id,
    proveedor_id,
    precio,
    stock,
    requiere_receta,
  } = req.body ?? {};
  const errores = [];

  if (typeof sku !== "string" || !sku.trim()) {
    errores.push("El SKU es obligatorio");
  } else if (sku.trim().length > 25) {
    errores.push("El SKU admite máximo 25 caracteres");
  }

  if (typeof nombre !== "string" || !nombre.trim()) {
    errores.push("El nombre del producto es obligatorio");
  } else if (nombre.trim().length > 150) {
    errores.push("El nombre admite máximo 150 caracteres");
  }

  if (typeof gramaje !== "string" || !gramaje.trim()) {
    errores.push("El gramaje o presentación es obligatorio");
  } else if (gramaje.trim().length > 60) {
    errores.push("El gramaje admite máximo 60 caracteres");
  }

  const catId = Number(categoria_id);
  if (!Number.isInteger(catId) || catId <= 0) {
    errores.push("categoria_id debe ser un entero positivo");
  }

  const provId = Number(proveedor_id);
  if (!Number.isInteger(provId) || provId <= 0) {
    errores.push("proveedor_id debe ser un entero positivo");
  }

  const precioNum = Number(precio);
  if (
    precio === undefined ||
    precio === "" ||
    !Number.isFinite(precioNum) ||
    precioNum <= 0
  ) {
    errores.push("El precio debe ser un número mayor que 0");
  }

  const stockNum = Number(stock);
  if (
    stock === undefined ||
    stock === "" ||
    !Number.isInteger(stockNum) ||
    stockNum < 0
  ) {
    errores.push("El stock debe ser un entero mayor o igual a 0");
  }

  if (
    requiere_receta !== undefined &&
    ![0, 1, true, false].includes(requiere_receta)
  ) {
    errores.push("requiere_receta debe ser 0 o 1");
  }

  if (errores.length > 0) {
    return res.status(400).json({ mensaje: "Datos inválidos", errores });
  }

  next();
};
