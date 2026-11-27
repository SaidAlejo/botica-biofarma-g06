import * as modelo from "../models/categorias.model.js";
import {
  LIMITE_MAXIMO,
  enteroPositivo,
  parsearId,
} from "../utils/validacionQuery.js";

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
    const { total, datos } = await modelo.listarCategorias({
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
    const datos = await modelo.resumenCategorias();
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
    const categoria = await modelo.obtenerCategoriaPorId(id);
    if (!categoria) {
      return res.status(404).json({ mensaje: "Categoría no encontrada" });
    }
    return res.status(200).json(categoria);
  } catch (error) {
    next(error);
  }
};

export const registrar = async (req, res, next) => {
  const { codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio } =
    req.body;

  try {
    const id = await modelo.crearCategoria({
      codigo: codigo.trim(),
      nombre: nombre.trim(),
      descripcion: descripcion.trim(),
      pasillo_ubicacion: pasillo_ubicacion.trim(),
      requiere_frio: requiere_frio === undefined ? 0 : Number(requiere_frio),
    });

    return res.status(201).json({
      mensaje: "Categoría registrada correctamente",
      id,
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El código de categoría ya existe" });
    }
    next(error);
  }
};

export const actualizar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const { codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio } =
    req.body;

  try {
    const afectadas = await modelo.actualizarCategoriaCompleta(id, {
      codigo: codigo.trim(),
      nombre: nombre.trim(),
      descripcion: descripcion.trim(),
      pasillo_ubicacion: pasillo_ubicacion.trim(),
      requiere_frio: requiere_frio === undefined ? 0 : Number(requiere_frio),
    });

    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Categoría no encontrada" });
    }

    return res.status(200).json({
      mensaje: "Categoría actualizada correctamente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El código de categoría ya existe" });
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
    "codigo",
    "nombre",
    "descripcion",
    "pasillo_ubicacion",
    "requiere_frio",
  ];
  const maxLongitudes = {
    codigo: 20,
    nombre: 100,
    descripcion: 255,
    pasillo_ubicacion: 60,
  };

  if (
    !datos ||
    typeof datos !== "object" ||
    Array.isArray(datos) ||
    Object.keys(datos).length === 0 ||
    Object.keys(datos).some((c) => !permitidos.includes(c))
  ) {
    return res.status(400).json({
      mensaje: "Envía al menos un campo permitido para categoría",
    });
  }

  const cambios = [];
  for (const [campo, valor] of Object.entries(datos)) {
    if (campo === "requiere_frio") {
      if (![0, 1, true, false].includes(valor)) {
        return res.status(400).json({ mensaje: "requiere_frio debe ser 0 o 1" });
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
    const afectadas = await modelo.actualizarCategoriaParcial(id, cambios);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Categoría no encontrada" });
    }

    return res.status(200).json({
      mensaje: "Categoría actualizada parcialmente",
    });
  } catch (error) {
    if (error.code === "ER_DUP_ENTRY") {
      return res.status(409).json({ mensaje: "El código de categoría ya existe" });
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
    const afectadas = await modelo.eliminarCategoriaLogico(id);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Categoría no encontrada" });
    }

    return res.status(200).json({
      mensaje: "Categoría eliminada lógicamente (activo = 0)",
    });
  } catch (error) {
    next(error);
  }
};
