import * as modelo from "../models/productos.model.js";
import {
  LIMITE_MAXIMO,
  enteroPositivo,
  parsearId,
} from "../utils/validacionQuery.js";

export const listar = async (req, res, next) => {
  const { buscar, categoria_id } = req.query;
  const pagina = enteroPositivo(req.query.pagina, 1);
  const limite = enteroPositivo(req.query.limite, 5);

  if (pagina === null || limite === null || limite > LIMITE_MAXIMO) {
    return res.status(400).json({
      mensaje: `pagina y limite deben ser enteros positivos (limite máximo ${LIMITE_MAXIMO})`,
    });
  }

  if (buscar !== undefined && typeof buscar !== "string") {
    return res.status(400).json({ mensaje: "buscar debe ser un texto" });
  }

  let categoriaId = null;
  if (categoria_id !== undefined) {
    categoriaId = enteroPositivo(categoria_id, null);
    if (categoriaId === null) {
      return res
        .status(400)
        .json({ mensaje: "categoria_id debe ser un entero positivo" });
    }
  }

  try {
    const texto = buscar ? buscar.trim() : "";
    const { total, datos } = await modelo.listarProductos({
      buscar: texto,
      categoriaId,
      pagina,
      limite,
    });

    return res.status(200).json({
      pagina,
      limite,
      total,
      totalPaginas: Math.ceil(total / limite),
      datos,
    });
  } catch (error) {
    next(error);
  }
};

export const resumen = async (req, res, next) => {
  try {
    const datos = await modelo.resumenProductos();
    return res.status(200).json(datos);
  } catch (error) {
    next(error);
  }
};

export const obtener = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  try {
    const producto = await modelo.obtenerProductoPorId(id);
    if (!producto) {
      return res.status(404).json({ mensaje: "Producto no encontrado" });
    }
    return res.status(200).json(producto);
  } catch (error) {
    next(error);
  }
};

export const registrar = async (req, res, next) => {
  const {
    sku,
    nombre,
    gramaje,
    categoria_id,
    proveedor_id,
    precio,
    stock,
    requiere_receta,
    imagen,
  } = req.body;

  try {
    const id = await modelo.crearProducto({
      sku: sku.trim(),
      nombre: nombre.trim(),
      gramaje: gramaje.trim(),
      categoria_id: Number(categoria_id),
      proveedor_id: Number(proveedor_id),
      precio: Number(precio),
      stock: Number(stock),
      requiere_receta:
        requiere_receta === undefined ? 0 : Number(requiere_receta),
      imagen: typeof imagen === "string" && imagen.trim() ? imagen.trim() : "default.png",
    });

    return res.status(201).json({
      mensaje: "Producto registrado correctamente",
      id,
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El SKU del producto ya existe" });
    }
    if (
      ["ER_NO_REFERENCED_ROW_2", "ER_NO_REFERENCED_ROW"].includes(error.code)
    ) {
      return res.status(400).json({
        mensaje: "La categoría o proveedor indicado no existe",
      });
    }
    next(error);
  }
};

export const actualizar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const {
    sku,
    nombre,
    gramaje,
    categoria_id,
    proveedor_id,
    precio,
    stock,
    requiere_receta,
    imagen,
  } = req.body;

  try {
    const afectadas = await modelo.actualizarProductoCompleto(id, {
      sku: sku.trim(),
      nombre: nombre.trim(),
      gramaje: gramaje.trim(),
      categoria_id: Number(categoria_id),
      proveedor_id: Number(proveedor_id),
      precio: Number(precio),
      stock: Number(stock),
      requiere_receta:
        requiere_receta === undefined ? 0 : Number(requiere_receta),
      imagen: typeof imagen === "string" && imagen.trim() ? imagen.trim() : "default.png",
    });

    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Producto no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Producto actualizado correctamente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El SKU del producto ya existe" });
    }
    if (
      ["ER_NO_REFERENCED_ROW_2", "ER_NO_REFERENCED_ROW"].includes(error.code)
    ) {
      return res.status(400).json({
        mensaje: "La categoría o proveedor indicado no existe",
      });
    }
    next(error);
  }
};

export const actualizarParcial = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const datos = req.body;
  const permitidos = [
    "sku",
    "nombre",
    "gramaje",
    "categoria_id",
    "proveedor_id",
    "precio",
    "stock",
    "requiere_receta",
    "imagen",
  ];
  const maxLongitudes = {
    sku: 25,
    nombre: 150,
    gramaje: 60,
    imagen: 150,
  };

  if (
    !datos ||
    typeof datos !== "object" ||
    Array.isArray(datos) ||
    Object.keys(datos).length === 0 ||
    Object.keys(datos).some((c) => !permitidos.includes(c))
  ) {
    return res.status(400).json({
      mensaje: "Envía al menos un campo permitido para producto",
    });
  }

  const cambios = [];
  for (const [campo, valor] of Object.entries(datos)) {
    if (campo === "precio") {
      const n = Number(valor);
      if (valor === "" || !Number.isFinite(n) || n <= 0) {
        return res
          .status(400)
          .json({ mensaje: "El precio debe ser un número mayor que 0" });
      }
      cambios.push([campo, n]);
    } else if (campo === "stock") {
      const n = Number(valor);
      if (valor === "" || !Number.isInteger(n) || n < 0) {
        return res
          .status(400)
          .json({ mensaje: "El stock debe ser un entero mayor o igual a 0" });
      }
      cambios.push([campo, n]);
    } else if (campo === "categoria_id" || campo === "proveedor_id") {
      const n = Number(valor);
      if (!Number.isInteger(n) || n <= 0) {
        return res
          .status(400)
          .json({ mensaje: `${campo} debe ser un entero positivo` });
      }
      cambios.push([campo, n]);
    } else if (campo === "requiere_receta") {
      if (![0, 1, true, false].includes(valor)) {
        return res
          .status(400)
          .json({ mensaje: "requiere_receta debe ser 0 o 1" });
      }
      cambios.push([campo, Number(valor)]);
    } else {
      if (typeof valor !== "string" || !valor.trim()) {
        return res.status(400).json({ mensaje: `Valor inválido para ${campo}` });
      }
      if (valor.trim().length > maxLongitudes[campo]) {
        return res.status(400).json({
          mensaje: `${campo} admite máximo ${maxLongitudes[campo]} caracteres`,
        });
      }
      cambios.push([campo, valor.trim()]);
    }
  }

  try {
    const afectadas = await modelo.actualizarProductoParcial(id, cambios);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Producto no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Producto actualizado parcialmente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El SKU del producto ya existe" });
    }
    if (
      ["ER_NO_REFERENCED_ROW_2", "ER_NO_REFERENCED_ROW"].includes(error.code)
    ) {
      return res.status(400).json({
        mensaje: "La categoría o proveedor indicado no existe",
      });
    }
    next(error);
  }
};

export const eliminar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  try {
    const afectadas = await modelo.eliminarProductoLogico(id);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Producto no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Producto eliminado lógicamente (activo = 0)",
    });
  } catch (error) {
    next(error);
  }
};
