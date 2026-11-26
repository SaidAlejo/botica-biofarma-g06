import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";
import {
  buscarUsuarioPorNombre,
  actualizarUltimoAcceso,
} from "../models/auth.model.js";

export const login = async (req, res, next) => {
  try {
    const { usuario, password } = req.body ?? {};

    if (
      typeof usuario !== "string" ||
      !usuario.trim() ||
      typeof password !== "string" ||
      !password.trim()
    ) {
      return res.status(400).json({
        mensaje: "usuario y password son obligatorios",
      });
    }

    const registro = await buscarUsuarioPorNombre(usuario.trim());

    if (
      !registro ||
      !registro.activo ||
      !(await bcrypt.compare(password, registro.password_hash))
    ) {
      return res.status(401).json({ mensaje: "Credenciales incorrectas" });
    }

    const token = jwt.sign(
      {
        id: registro.id,
        usuario: registro.usuario,
        rol: registro.rol,
      },
      process.env.JWT_SECRET,
      { expiresIn: process.env.JWT_EXPIRES || "2h" }
    );

    await actualizarUltimoAcceso(registro.id);

    return res.status(200).json({
      token,
      usuario: registro.usuario,
      rol: registro.rol,
    });
  } catch (error) {
    next(error);
  }
};
