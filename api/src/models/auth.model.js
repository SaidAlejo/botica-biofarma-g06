import pool from "../config/db.js";

export const buscarUsuarioPorNombre = async (usuario) => {
  const [filas] = await pool.execute(
    `SELECT u.id, u.usuario, u.nombres, u.apellidos, u.correo,
            u.password_hash, u.activo, r.codigo AS rol
     FROM sti_g06_usuarios u
     INNER JOIN sti_g06_roles r ON r.id = u.rol_id
     WHERE u.usuario = ?`,
    [usuario]
  );
  return filas[0] || null;
};

export const actualizarUltimoAcceso = async (id) => {
  await pool.execute(
    "UPDATE sti_g06_usuarios SET ultimo_acceso = NOW() WHERE id = ?",
    [id]
  );
};
