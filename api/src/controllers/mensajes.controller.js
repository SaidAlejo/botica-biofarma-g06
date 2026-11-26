import * as modelo from "../models/mensajes.model.js";
import {
  LIMITE_MAXIMO,
  enteroPositivo,
  parsearId,
} from "../utils/validacionQuery.js";

export const listar = async (req, res, next) => {
  const { buscar } = req.query;
  const pagina = enteroPositivo(req.query.pagina, 1);
  const limite = enteroPositivo(req.query.limite, 10);

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
    const { total, noLeidos, datos } = await modelo.listarMensajes({
      buscar: texto,
      pagina,
      limite,
    });

    return res.status(200).json({
      pagina,
      limite,
      total,
      noLeidos,
      totalPaginas: Math.ceil(total / limite),
      datos,
    });
  } catch (error) {
    next(error);
  }
};

export const actualizarParcial = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  const { leido } = req.body ?? {};
  if (![0, 1, true, false].includes(leido)) {
    return res.status(400).json({ mensaje: "leido debe ser 0 o 1" });
  }

  try {
    const afectadas = await modelo.marcarLeido(id, Number(leido));
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Mensaje no encontrado" });
    }
    return res.status(200).json({ mensaje: "Estado del mensaje actualizado" });
  } catch (error) {
    next(error);
  }
};

export const eliminar = async (req, res, next) => {
  const id = parsearId(req.params.id);
  if (!id) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  try {
    const afectadas = await modelo.eliminarMensajeLogico(id);
    if (afectadas === 0) {
      return res.status(404).json({ mensaje: "Mensaje no encontrado" });
    }
    return res.status(200).json({ mensaje: "Mensaje eliminado correctamente" });
  } catch (error) {
    next(error);
  }
};
