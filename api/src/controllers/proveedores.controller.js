import * as modelo from "../models/proveedores.model.js";
import {
  LIMITE_MAXIMO,
  enteroPositivo,
  parsearId,
} from "../utils/validacionQuery.js";

const REGEX_RUC = /^\d{11}$/;
const REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

export const listar = async (req, res, next) => {
  const { buscar } = req.query;
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

  try {
    const texto = buscar ? buscar.trim() : "";
    const { total, datos } = await modelo.listarProveedores({
      buscar: texto,
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
    const datos = await modelo.resumenProveedores();
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
    const proveedor = await modelo.obtenerProveedorPorId(id);
    if (!proveedor) {
      return res.status(404).json({ mensaje: "Proveedor no encontrado" });
    }
    return res.status(200).json(proveedor);
  } catch (error) {
    next(error);
  }
};

export const registrar = async (req, res, next) => {
  const { ruc, razon_social, nombre_comercial, telefono, correo, direccion } =
    req.body;

  try {
    const id = await modelo.crearProveedor({
      ruc: ruc.trim(),
      razon_social: razon_social.trim(),
      nombre_comercial: nombre_comercial.trim(),
      telefono: telefono.trim(),
      correo: correo.trim(),
      direccion: direccion.trim(),
    });

    return res.status(201).json({
      mensaje: "Proveedor registrado correctamente",
      id,
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El RUC ya está registrado" });
    }
    next(error);
  }
};

export const actualizar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const { ruc, razon_social, nombre_comercial, telefono, correo, direccion } =
    req.body;

  try {
    const afectadas = await modelo.actualizarProveedorCompleto(id, {
      ruc: ruc.trim(),
      razon_social: razon_social.trim(),
      nombre_comercial: nombre_comercial.trim(),
      telefono: telefono.trim(),
      correo: correo.trim(),
      direccion: direccion.trim(),
    });

    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Proveedor no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Proveedor actualizado correctamente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El RUC ya está registrado" });
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
    "ruc",
    "razon_social",
    "nombre_comercial",
    "telefono",
    "correo",
    "direccion",
  ];
  const maxLongitudes = {
    ruc: 11,
    razon_social: 150,
    nombre_comercial: 120,
    telefono: 20,
    correo: 120,
    direccion: 200,
  };

  if (
    !datos ||
    typeof datos !== "object" ||
    Array.isArray(datos) ||
    Object.keys(datos).length === 0 ||
    Object.keys(datos).some((c) => !permitidos.includes(c))
  ) {
    return res.status(400).json({
      mensaje: "Envía al menos un campo permitido para proveedor",
    });
  }

  const cambios = [];
  for (const [campo, valor] of Object.entries(datos)) {
    if (typeof valor !== "string" || !valor.trim()) {
      return res.status(400).json({ mensaje: `Valor inválido para ${campo}` });
    }
    const limpio = valor.trim();
    if (campo === "ruc" && !REGEX_RUC.test(limpio)) {
      return res.status(400).json({ mensaje: "El RUC debe tener exactamente 11 dígitos" });
    }
    if (campo === "correo" && !REGEX_EMAIL.test(limpio)) {
      return res.status(400).json({ mensaje: "El correo no tiene un formato válido" });
    }
    if (limpio.length > maxLongitudes[campo]) {
      return res.status(400).json({
        mensaje: `${campo} admite máximo ${maxLongitudes[campo]} caracteres`,
      });
    }
    cambios.push([campo, limpio]);
  }

  try {
    const afectadas = await modelo.actualizarProveedorParcial(id, cambios);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Proveedor no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Proveedor actualizado parcialmente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El RUC ya está registrado" });
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
    const afectadas = await modelo.eliminarProveedorLogico(id);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Proveedor no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Proveedor eliminado lógicamente (activo = 0)",
    });
  } catch (error) {
    next(error);
  }
};
