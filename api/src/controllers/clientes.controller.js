import * as modelo from "../models/clientes.model.js";
import {
  LIMITE_MAXIMO,
  enteroPositivo,
  parsearId,
} from "../utils/validacionQuery.js";

const REGEX_DNI = /^\d{8}$/;
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
    const { total, datos } = await modelo.listarClientes({
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
    const datos = await modelo.resumenClientes();
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
    const cliente = await modelo.obtenerClientePorId(id);
    if (!cliente) {
      return res.status(404).json({ mensaje: "Cliente no encontrado" });
    }
    return res.status(200).json(cliente);
  } catch (error) {
    next(error);
  }
};

export const registrar = async (req, res, next) => {
  const { dni, nombres, apellidos, telefono, correo, direccion } = req.body;

  try {
    const id = await modelo.crearCliente({
      dni: dni.trim(),
      nombres: nombres.trim(),
      apellidos: apellidos.trim(),
      telefono: telefono.trim(),
      correo: correo.trim(),
      direccion: direccion.trim(),
    });

    return res.status(201).json({
      mensaje: "Cliente registrado correctamente",
      id,
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El DNI ya está registrado" });
    }
    next(error);
  }
};

export const actualizar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const { dni, nombres, apellidos, telefono, correo, direccion } = req.body;

  try {
    const afectadas = await modelo.actualizarClienteCompleto(id, {
      dni: dni.trim(),
      nombres: nombres.trim(),
      apellidos: apellidos.trim(),
      telefono: telefono.trim(),
      correo: correo.trim(),
      direccion: direccion.trim(),
    });

    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Cliente no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Cliente actualizado correctamente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El DNI ya está registrado" });
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
    "dni",
    "nombres",
    "apellidos",
    "telefono",
    "correo",
    "direccion",
  ];
  const maxLongitudes = {
    dni: 8,
    nombres: 100,
    apellidos: 100,
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
      mensaje: "Envía al menos un campo permitido para cliente",
    });
  }

  const cambios = [];
  for (const [campo, valor] of Object.entries(datos)) {
    if (typeof valor !== "string" || !valor.trim()) {
      return res.status(400).json({ mensaje: `Valor inválido para ${campo}` });
    }
    const limpio = valor.trim();
    if (campo === "dni" && !REGEX_DNI.test(limpio)) {
      return res
        .status(400)
        .json({ mensaje: "El DNI debe tener exactamente 8 dígitos" });
    }
    if (campo === "correo" && !REGEX_EMAIL.test(limpio)) {
      return res
        .status(400)
        .json({ mensaje: "El correo no tiene un formato válido" });
    }
    if (limpio.length > maxLongitudes[campo]) {
      return res.status(400).json({
        mensaje: `${campo} admite máximo ${maxLongitudes[campo]} caracteres`,
      });
    }
    cambios.push([campo, limpio]);
  }

  try {
    const afectadas = await modelo.actualizarClienteParcial(id, cambios);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Cliente no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Cliente actualizado parcialmente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El DNI ya está registrado" });
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
    const afectadas = await modelo.eliminarClienteLogico(id);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Cliente no encontrado" });
    }

    return res.status(200).json({
      mensaje: "Cliente eliminado lógicamente (activo = 0)",
    });
  } catch (error) {
    next(error);
  }
};
