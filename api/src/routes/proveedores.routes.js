import { Router } from "express";
import * as controlador from "../controllers/proveedores.controller.js";
import { verificarToken, autorizar } from "../middlewares/auth.js";
import { validarProveedor } from "../middlewares/validarProveedor.js";

// Recurso a cargo de: Dariel Carpio (Grupo 06)
const router = Router();

router.get("/", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.listar);
router.get("/resumen", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.resumen);
router.get("/:id", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.obtener);

router.post("/", verificarToken, autorizar("ADMIN"), validarProveedor, controlador.registrar);
router.put("/:id", verificarToken, autorizar("ADMIN"), validarProveedor, controlador.actualizar);
router.patch("/:id", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.actualizarParcial);
router.delete("/:id", verificarToken, autorizar("ADMIN"), controlador.eliminar);

export default router;
