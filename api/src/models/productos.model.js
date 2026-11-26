import pool from "../config/db.js";

const TABLA = "sti_g06_productos";

export const listarProductos = async ({
  buscar = "",
  categoriaId = null,
  pagina = 1,
  limite = 5,
}) => {
  const condiciones = ["p.activo = 1"];
  const valores = [];

  if (buscar) {
    condiciones.push(
      "(p.sku LIKE ? OR p.nombre LIKE ? OR p.gramaje LIKE ? OR c.nombre LIKE ?)"
    );
    const patron = `%${buscar}%`;
    valores.push(patron, patron, patron, patron);
  }

  if (categoriaId !== null) {
    condiciones.push("p.categoria_id = ?");
    valores.push(categoriaId);
  }

  const where = "WHERE " + condiciones.join(" AND ");
  const offset = (pagina - 1) * limite;

  const [conteo] = await pool.query(
    `SELECT COUNT(*) AS total
     FROM ${TABLA} p
     INNER JOIN sti_g06_categorias c ON c.id = p.categoria_id
     INNER JOIN sti_g06_proveedores pr ON pr.id = p.proveedor_id
     ${where}`,
    valores
  );

  const [filas] = await pool.query(
    `SELECT p.id, p.sku, p.nombre, p.gramaje,
            p.categoria_id, c.nombre AS categoria_nombre,
            p.proveedor_id, pr.nombre_comercial AS proveedor_nombre,
            p.precio, p.stock, p.requiere_receta, p.imagen, p.activo
     FROM ${TABLA} p
     INNER JOIN sti_g06_categorias c ON c.id = p.categoria_id
     INNER JOIN sti_g06_proveedores pr ON pr.id = p.proveedor_id
     ${where}
     ORDER BY p.nombre ASC, p.id ASC
     LIMIT ? OFFSET ?`,
    [...valores, limite, offset]
  );

  return {
    total: conteo[0].total,
    datos: filas.map((f) => ({ ...f, precio: Number(f.precio) })),
  };
};

export const resumenProductos = async () => {
  const [filas] = await pool.execute(
    `SELECT id, CONCAT(sku, ' - ', nombre) AS nombre
     FROM ${TABLA}
     WHERE activo = 1
     ORDER BY nombre ASC`
  );
  return filas;
};

export const obtenerProductoPorId = async (id) => {
  const [filas] = await pool.execute(
    `SELECT p.id, p.sku, p.nombre, p.gramaje,
            p.categoria_id, c.nombre AS categoria_nombre,
            p.proveedor_id, pr.nombre_comercial AS proveedor_nombre,
            p.precio, p.stock, p.requiere_receta, p.imagen, p.activo
     FROM ${TABLA} p
     INNER JOIN sti_g06_categorias c ON c.id = p.categoria_id
     INNER JOIN sti_g06_proveedores pr ON pr.id = p.proveedor_id
     WHERE p.id = ? AND p.activo = 1`,
    [id]
  );
  if (!filas[0]) return null;
  return { ...filas[0], precio: Number(filas[0].precio) };
};

export const crearProducto = async ({
  sku,
  nombre,
  gramaje,
  categoria_id,
  proveedor_id,
  precio,
  stock,
  requiere_receta,
  imagen = "default.png",
}) => {
  const [resultado] = await pool.execute(
    `INSERT INTO ${TABLA}
       (sku, nombre, gramaje, categoria_id, proveedor_id, precio, stock, requiere_receta, imagen)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`,
    [
      sku,
      nombre,
      gramaje,
      categoria_id,
      proveedor_id,
      precio,
      stock,
      requiere_receta,
      imagen,
    ]
  );
  return resultado.insertId;
};

export const actualizarProductoCompleto = async (
  id,
  {
    sku,
    nombre,
    gramaje,
    categoria_id,
    proveedor_id,
    precio,
    stock,
    requiere_receta,
    imagen = "default.png",
  }
) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET sku = ?, nombre = ?, gramaje = ?, categoria_id = ?,
         proveedor_id = ?, precio = ?, stock = ?, requiere_receta = ?, imagen = ?
     WHERE id = ? AND activo = 1`,
    [
      sku,
      nombre,
      gramaje,
      categoria_id,
      proveedor_id,
      precio,
      stock,
      requiere_receta,
      imagen,
      id,
    ]
  );
  return resultado.affectedRows;
};

export const actualizarProductoParcial = async (id, cambios) => {
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

export const eliminarProductoLogico = async (id) => {
  const [resultado] = await pool.execute(
    `UPDATE ${TABLA}
     SET activo = 0
     WHERE id = ? AND activo = 1`,
    [id]
  );
  return resultado.affectedRows;
};
