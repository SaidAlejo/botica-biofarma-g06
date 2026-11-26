export const noEncontrado = (req, res) => {
  res.status(404).json({
    mensaje: `Ruta ${req.method} ${req.originalUrl} no encontrada`,
  });
};

export const manejadorErrores = (err, req, res, next) => {
  console.error(err);

  if (err.type === "entity.parse.failed") {
    return res.status(400).json({
      mensaje: "El cuerpo JSON está mal formado",
    });
  }

  if (err.message && err.message.startsWith("Origen no permitido por CORS")) {
    return res.status(403).json({
      mensaje: err.message,
    });
  }

  const status = err.status || 500;
  return res.status(status).json({
    mensaje: status === 500 ? "Error interno del servidor" : err.message,
  });
};
