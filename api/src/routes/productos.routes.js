import { Router } from "express";
import * as controlador from "../controllers/productos.controller.js";
import { verificarToken, autorizar } from "../middlewares/auth.js";
import { validarProducto } from "../middlewares/validarProducto.js";

// Recurso a cargo de: Jeancarlo Alejo - Coordinador (Grupo 06)
const router = Router();

router.get("/", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.listar);
router.get("/resumen", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.resumen);
router.get("/:id", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.obtener);

router.post("/", verificarToken, autorizar("ADMIN"), validarProducto, controlador.registrar);
router.put("/:id", verificarToken, autorizar("ADMIN"), validarProducto, controlador.actualizar);
router.patch("/:id", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.actualizarParcial);
router.delete("/:id", verificarToken, autorizar("ADMIN"), controlador.eliminar);

export default router;
