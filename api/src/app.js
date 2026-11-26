import "dotenv/config";
import express from "express";
import cors from "cors";

import { registrarSolicitud } from "./middlewares/registrarSolicitud.js";
import { noEncontrado, manejadorErrores } from "./middlewares/errores.js";

import authRoutes from "./routes/auth.routes.js";
import categoriasRoutes from "./routes/categorias.routes.js";
import proveedoresRoutes from "./routes/proveedores.routes.js";
import productosRoutes from "./routes/productos.routes.js";
import clientesRoutes from "./routes/clientes.routes.js";
import mensajesRoutes from "./routes/mensajes.routes.js";
import docsRoutes from "./routes/docs.routes.js";

const app = express();
const PORT = Number(process.env.PORT || 3000);

const origenesPermitidos = (process.env.CORS_ORIGIN || "http://localhost:5500")
  .split(",")
  .map((o) => o.trim())
  .filter(Boolean);

// 1. Middleware de registro de solicitudes
app.use(registrarSolicitud);

// 2. CORS
app.use(
  cors({
    origin: (origin, callback) => {
      if (!origin || origenesPermitidos.includes(origin)) {
        return callback(null, true);
      }
      return callback(new Error(`Origen no permitido por CORS: ${origin}`));
    },
    methods: ["GET", "POST", "PUT", "PATCH", "DELETE"],
    allowedHeaders: ["Content-Type", "Authorization"],
  })
);

// 3. Parseo de cuerpo JSON
app.use(express.json());

// 4. Rutas de la API y documentación
app.get("/", (req, res) => {
  res.status(200).json({
    servicio: "API REST - Sistema de Gestión de Botica Biofarma (Grupo 06)",
    version: "1.0.0",
    documentacion: "/api-docs",
    recursos: [
      "/api/v1/auth/login",
      "/api/v1/categorias",
      "/api/v1/proveedores",
      "/api/v1/productos",
      "/api/v1/clientes",
    ],
  });
});

app.use("/api/v1/auth", authRoutes);
app.use("/api/v1/categorias", categoriasRoutes);
app.use("/api/v1/proveedores", proveedoresRoutes);
app.use("/api/v1/productos", productosRoutes);
app.use("/api/v1/clientes", clientesRoutes);
app.use("/api/v1/mensajes", mensajesRoutes);
app.use("/api-docs", docsRoutes);

// 5. Ruta no encontrada (404 en JSON)
app.use(noEncontrado);

// 6. Manejo centralizado de errores (400 JSON mal formado / 500)
app.use(manejadorErrores);

// 7. Arranque del servidor
app.listen(PORT, () => {
  console.log(`API Botica Biofarma (Grupo 06) activa en http://localhost:${PORT}`);
  console.log(`Documentación Swagger UI en http://localhost:${PORT}/api-docs`);
});
