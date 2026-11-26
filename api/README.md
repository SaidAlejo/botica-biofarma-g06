# API REST – Botica Biofarma (Grupo 06)

Proyecto integrador de la Unidad Didáctica **Servicios de TI** (IESP Vigil).

## Integrantes y Reparto de Recursos

| Integrante | Rol en el grupo | Recurso a su cargo | Tabla MySQL |
|---|---|---|---|
| **Jeancarlo Alejo** | Coordinador | `productos` (+ autenticación) | `sti_g06_productos` |
| **Jesus Sarmiento** | Integrante | `categorias` | `sti_g06_categorias` |
| **Dariel Carpio** | Integrante | `proveedores` | `sti_g06_proveedores` |
| **Piero Ramos** | Integrante | `clientes` | `sti_g06_clientes` |

Tablas comunes: `sti_g06_roles` y `sti_g06_usuarios`.

## Usuarios de Prueba

| Usuario | Contraseña | Rol | Permisos |
|---|---|---|---|
| `admin` | `Said123` | `ADMIN` | Acceso completo (`GET`, `POST`, `PUT`, `PATCH`, `DELETE`) |
| `operador` | `operador123` | `OPERADOR` | Lectura (`GET`, `/resumen`, `/:id`) y edición parcial (`PATCH`); recibe `403` en `POST`, `PUT` y `DELETE` |

## Puesta en Marcha Local

1. Inicia **MySQL** en XAMPP e importa `../bd_g06.sql` (crea `sistema_botica_biofarma_g06`).
2. Verifica `api/.env` (puedes guiarte con `api/.env.example`).
3. Instala dependencias (si no existe `node_modules/`):
   ```bash
   npm install
   ```
4. Inicia la API:
   ```bash
   npm run dev
   ```
   - API disponible en: `http://localhost:3000/api/v1`
   - Documentación Swagger UI: `http://localhost:3000/api-docs`
5. Abre **Botica Biofarma** en tu navegador (con Apache encendido en XAMPP):
   - Sitio público y catálogo: `http://localhost/BOTICABIOFARMA/index.php`
   - Inicio de sesión y Panel Admin integrado a la API: `http://localhost/BOTICABIOFARMA/login.php`
