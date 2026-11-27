import pool from "../config/db.js";

const TABLA = "sti_g06_clientes";

export const listarClientes = async ({ buscar = "", pagina = 1, limite = 5 }) => {
  const condiciones = ["activo = 1"];
  const valores = [];

  if (buscar) {
    condiciones.push(
      "(dni LIKE ? OR nombres LIKE ? OR apellidos LIKE ? OR correo LIKE ?)"
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
    `SELECT id, dni, nombres, apellidos, telefono, correo, direccion, activo
     FROM ${TABLA}
     ${where}
     ORDER BY apellidos ASC, nombres ASC, id ASC
     LIMIT ? OFFSET ?`,
    [...valores, limite, offset]
  );

  return {
    total: conteo[0].total,
    datos: filas,
  };
};

export const resumenClientes = async () => {
  const [filas] = await pool.execute(
    `SELECT id, CONCAT(apellidos, ', ', nombres, ' (', dni, ')') AS nombre
     FROM ${TABLA}
     WHERE activo = 1
     ORDER BY apellidos ASC, nombres ASC`
  );
  return filas;
};

export const obtenerClientePorId = async (id) => {
  const [filas] = await pool.execute(
    `SELECT id, dni, nombres, apellidos, telefono, correo, direccion, activo
     FROM ${TABLA}
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return filas[0] || null;
};

export const crearCliente = async ({
  dni,
  nombres,
  apellidos,
  telefono,
  correo,
  direccion,
}) => {
  const [resultado] = await pool.execute(
    `INSERT INTO ${TABLA} (dni, nombres, apellidos, telefono, correo, direccion)
     VALUES (?, ?, ?, ?, ?, ?)`,
    [dni, nombres, apellidos, telefono, correo, direccion]
  );
  return resultado.insertId;
};

export const actualizarClienteCompleto = async (
  id,
  { dni, nombres, apellidos, telefono, correo, direccion }
) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET dni = ?, nombres = ?, apellidos = ?, telefono = ?, correo = ?, direccion = ?
     WHERE id = ? AND activo = 1`,
    [dni, nombres, apellidos, telefono, correo, direccion, id]
  );
  return resultado.affectedRows;
};

export const actualizarClienteParcial = async (id, cambios) => {
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

export const eliminarClienteLogico = async (id) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET activo = 0
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return resultado.affectedRows;
};
