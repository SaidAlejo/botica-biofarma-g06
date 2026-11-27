import pool from "../config/db.js";

const TABLA = "sti_g06_categorias";

export const listarCategorias = async ({ buscar = "", pagina = 1, limite = 5 }) => {
  const condiciones = ["activo = 1"];
  const valores = [];

  if (buscar) {
    condiciones.push("(codigo LIKE ? OR nombre LIKE ? OR pasillo_ubicacion LIKE ?)");
    const patron = `%${buscar}%`;
    valores.push(patron, patron, patron);
  }

  const where = "WHERE " + condiciones.join(" AND ");
  const offset = (pagina - 1) * limite;

  const [conteo] = await pool.query(
    `SELECT COUNT(*) AS total FROM ${TABLA} ${where}`,
    valores
  );

  const [filas] = await pool.query(
    `SELECT id, codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio, activo
     FROM ${TABLA}
     ${where}
     ORDER BY nombre ASC, id ASC
     LIMIT ? OFFSET ?`,
    [...valores, limite, offset]
  );

  return {
    total: conteo[0].total,
    datos: filas,
  };
};

export const resumenCategorias = async () => {
  const [filas] = await pool.execute(
    `SELECT id, nombre
     FROM ${TABLA}
     WHERE activo = 1
     ORDER BY nombre ASC`
  );
  return filas;
};

export const obtenerCategoriaPorId = async (id) => {
  const [filas] = await pool.execute(
    `SELECT id, codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio, activo
     FROM ${TABLA}
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return filas[0] || null;
};

export const crearCategoria = async ({
  codigo,
  nombre,
  descripcion,
  pasillo_ubicacion,
  requiere_frio,
}) => {
  const [resultado] = await pool.execute(
    `INSERT INTO ${TABLA} (codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio)
     VALUES (?, ?, ?, ?, ?)`,
    [codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio]
  );
  return resultado.insertId;
};

export const actualizarCategoriaCompleta = async (
  id,
  { codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio }
) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET codigo = ?, nombre = ?, descripcion = ?, pasillo_ubicacion = ?, requiere_frio = ?
     WHERE id = ? AND activo = 1`,
    [codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio, id]
  );
  return resultado.affectedRows;
};

export const actualizarCategoriaParcial = async (id, cambios) => {
  const asignaciones = cambios.map(([campo]) => `${campo} = ?`).join(", ");
  const valores = cambios.map(([, valor]) => valor);

  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET ${asignaciones}
     WHERE id = ? AND activo = 1`,
    [...valores, id]
  );
  return resultado.affectedRows;
};

export const eliminarCategoriaLogico = async (id) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET activo = 0
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return resultado.affectedRows;
};
