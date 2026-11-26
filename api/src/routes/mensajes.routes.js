import { Router } from "express";
import * as controlador from "../controllers/mensajes.controller.js";
import { verificarToken, autorizar } from "../middlewares/auth.js";

const router = Router();

router.get("/", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.listar);
router.patch("/:id", verificarToken, autorizar("ADMIN", "OPERADOR"), controlador.actualizarParcial);
router.delete("/:id", verificarToken, autorizar("ADMIN"), controlador.eliminar);

export default router;
