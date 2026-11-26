import { Router } from "express";
import fs from "node:fs";
import YAML from "yaml";
import swaggerUi from "swagger-ui-express";

const router = Router();
const ARCHIVO = new URL("../../docs/openapi.yaml", import.meta.url);

// Se lee en cada solicitud: al guardar el YAML basta con recargar /api-docs
router.get("/openapi.json", (req, res, next) => {
  try {
    const documento = YAML.parse(fs.readFileSync(ARCHIVO, "utf8"));
    res.json(documento);
  } catch (error) {
    next(error);
  }
});

router.use("/", swaggerUi.serve);
router.get(
  "/",
  swaggerUi.setup(null, {
    swaggerOptions: { url: "/api-docs/openapi.json" },
  })
);

export default router;
