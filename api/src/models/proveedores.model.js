import pool from "../config/db.js";

const TABLA = "sti_g06_proveedores";

export const listarProveedores = async ({ buscar = "", pagina = 1, limite = 5 }) => {
  const condiciones = ["activo = 1"];
  const valores = [];

  if (buscar) {
    condiciones.push(
      "(ruc LIKE ? OR razon_social LIKE ? OR nombre_comercial LIKE ? OR correo LIKE ?)"
    );
    const patron = `%${buscar}%`;
    valores.push(patron, patron, patron, patron);
  }

  const where = "WHERE " + condiciones.join(" AND ");
  const offset = (pagina - 1) * limite;

  const [conteo] = await pool.query(
    `SELECT COUNT(*) AS total FROM ${TABLA} ${where}`,
    valores
  );

  const [filas] = await pool.query(
    `SELECT id, ruc, razon_social, nombre_comercial, telefono, correo, direccion, activo
     FROM ${TABLA}
     ${where}
     ORDER BY nombre_comercial ASC, id ASC
     LIMIT ? OFFSET ?`,
    [...valores, limite, offset]
  );

  return {
    total: conteo[0].total,
    datos: filas,
  };
};

export const resumenProveedores = async () => {
  const [filas] = await pool.execute(
    `SELECT id, nombre_comercial AS nombre
     FROM ${TABLA}
     WHERE activo = 1
     ORDER BY nombre_comercial ASC`
  );
  return filas;
};

export const obtenerProveedorPorId = async (id) => {
  const [filas] = await pool.execute(
    `SELECT id, ruc, razon_social, nombre_comercial, telefono, correo, direccion, activo
     FROM ${TABLA}
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return filas[0] || null;
};

export const crearProveedor = async ({
  ruc,
  razon_social,
  nombre_comercial,
  telefono,
  correo,
  direccion,
}) => {
  const [resultado] = await pool.execute(
    `INSERT INTO ${TABLA} (ruc, razon_social, nombre_comercial, telefono, correo, direccion)
     VALUES (?, ?, ?, ?, ?, ?)`,
    [ruc, razon_social, nombre_comercial, telefono, correo, direccion]
  );
  return resultado.insertId;
};

export const actualizarProveedorCompleto = async (
  id,
  { ruc, razon_social, nombre_comercial, telefono, correo, direccion }
) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET ruc = ?, razon_social = ?, nombre_comercial = ?, telefono = ?, correo = ?, direccion = ?
     WHERE id = ? AND activo = 1`,
    [ruc, razon_social, nombre_comercial, telefono, correo, direccion, id]
  );
  return resultado.affectedRows;
};

export const actualizarProveedorParcial = async (id, cambios) => {
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

export const eliminarProveedorLogico = async (id) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET activo = 0
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return resultado.affectedRows;
};
