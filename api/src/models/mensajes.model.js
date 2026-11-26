import pool from "../config/db.js";

const TABLA = "sti_g06_mensajes";

export const listarMensajes = async ({ buscar = "", pagina = 1, limite = 10 }) => {
  const condiciones = ["activo = 1"];
  const valores = [];

  if (buscar) {
    condiciones.push("(nombre LIKE ? OR celular LIKE ? OR correo LIKE ? OR mensaje LIKE ?)");
    const patron = `%${buscar}%`;
    valores.push(patron, patron, patron, patron);
  }

  const where = "WHERE " + condiciones.join(" AND ");
  const offset = (pagina - 1) * limite;

  const [conteo] = await pool.query(
    `SELECT COUNT(*) AS total FROM ${TABLA} ${where}`,
    valores
  );

  const [noLeidos] = await pool.query(
    `SELECT COUNT(*) AS total FROM ${TABLA} WHERE activo = 1 AND leido = 0`
  );

  const [filas] = await pool.query(
    `SELECT id, nombre, celular, correo, mensaje, leido, fecha_creacion, activo
     FROM ${TABLA}
     ${where}
     ORDER BY fecha_creacion DESC, id DESC
     LIMIT ? OFFSET ?`,
    [...valores, limite, offset]
  );

  return {
    total: conteo[0].total,
    noLeidos: noLeidos[0].total,
    datos: filas,
  };
};

export const marcarLeido = async (id, leido = 1) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA} SET leido = ? WHERE id = ? AND activo = 1`,
    [leido, id]
  );
  return resultado.affectedRows;
};

export const eliminarMensajeLogico = async (id) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA} SET activo = 0 WHERE id = ? AND activo = 1`,
    [id]
  );
  return resultado.affectedRows;
};
