-- ============================================================================
-- SISTEMA DE GESTIÓN DE BOTICA BIOFARMA - GRUPO 06
-- Unidad Didáctica: Servicios de TI (Actividad Integradora)
-- Integrantes:
--   1. Jeancarlo Alejo (Coordinador) -> Recurso: productos   (sti_g06_productos)
--   2. Jesus Sarmiento               -> Recurso: categorias  (sti_g06_categorias)
--   3. Dariel Carpio                 -> Recurso: proveedores (sti_g06_proveedores)
--   4. Piero Ramos                   -> Recurso: clientes    (sti_g06_clientes)
--
-- Usuarios iniciales:
--   admin    / Said123      (Rol: ADMIN)
--   operador / operador123  (Rol: OPERADOR)
-- ============================================================================

CREATE DATABASE IF NOT EXISTS sistema_botica_biofarma_g06
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE sistema_botica_biofarma_g06;

-- Limpiar tablas en orden inverso de dependencias si se reimporta el script
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS sti_g06_mensajes;
DROP TABLE IF EXISTS sti_g06_productos;
DROP TABLE IF EXISTS sti_g06_clientes;
DROP TABLE IF EXISTS sti_g06_proveedores;
DROP TABLE IF EXISTS sti_g06_categorias;
DROP TABLE IF EXISTS sti_g06_usuarios;
DROP TABLE IF EXISTS sti_g06_roles;
SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------------------------------------------------------
-- 1. TABLA DE ROLES
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL UNIQUE,
  nombre VARCHAR(80) NOT NULL,
  descripcion VARCHAR(200) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 2. TABLA DE USUARIOS
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  correo VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol_id INT NOT NULL,
  ultimo_acceso DATETIME NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_g06_usuarios_rol
    FOREIGN KEY (rol_id) REFERENCES sti_g06_roles(id)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 3. RECURSO: CATEGORÍAS (Jesus Sarmiento)
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(20) NOT NULL UNIQUE,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) NOT NULL,
  pasillo_ubicacion VARCHAR(60) NOT NULL,
  requiere_frio TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 4. RECURSO: PROVEEDORES (Dariel Carpio)
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_proveedores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ruc VARCHAR(11) NOT NULL UNIQUE,
  razon_social VARCHAR(150) NOT NULL,
  nombre_comercial VARCHAR(120) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  correo VARCHAR(120) NOT NULL,
  direccion VARCHAR(200) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 5. RECURSO: PRODUCTOS (Jeancarlo Alejo - Coordinador)
--    Relacionado con categorias (FK) y proveedores (FK)
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(25) NOT NULL UNIQUE,
  nombre VARCHAR(150) NOT NULL,
  gramaje VARCHAR(60) NOT NULL,
  categoria_id INT NOT NULL,
  proveedor_id INT NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  requiere_receta TINYINT(1) NOT NULL DEFAULT 0,
  imagen VARCHAR(150) NOT NULL DEFAULT 'default.png',
  activo TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_g06_productos_categoria
    FOREIGN KEY (categoria_id) REFERENCES sti_g06_categorias(id),
  CONSTRAINT fk_g06_productos_proveedor
    FOREIGN KEY (proveedor_id) REFERENCES sti_g06_proveedores(id)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 6. RECURSO: CLIENTES (Piero Ramos)
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(8) NOT NULL UNIQUE,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  correo VARCHAR(120) NOT NULL,
  direccion VARCHAR(200) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 7. TABLA DE MENSAJES DE CONTACTO (Formulario web contacto.php)
-- ----------------------------------------------------------------------------
CREATE TABLE sti_g06_mensajes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  celular VARCHAR(20) NOT NULL,
  correo VARCHAR(120) NULL,
  mensaje TEXT NOT NULL,
  leido TINYINT(1) NOT NULL DEFAULT 0,
  fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ============================================================================
-- INSERCIÓN DE DATOS REALES SIMULADOS
-- ============================================================================

-- Roles
INSERT INTO sti_g06_roles (codigo, nombre, descripcion, activo) VALUES
  ('ADMIN', 'Administrador', 'Acceso completo a todos los módulos y operaciones de Botica Biofarma', 1),
  ('OPERADOR', 'Operador de Botica', 'Consulta de catálogo y actualizaciones parciales de inventario y datos', 1);

-- Usuarios (contraseñas hasheadas con bcryptjs, 10 rondas)
INSERT INTO sti_g06_usuarios (usuario, nombres, apellidos, correo, password_hash, rol_id, activo) VALUES
  ('admin', 'Jeancarlo', 'Alejo', 'admin@boticabiofarma.pe', '$2b$10$hZccuPEkZFBcDeL51jJUouRAwK/wt2YtEk.EEXsw6j1s8thIZcKCu', 1, 1),
  ('operador', 'Jesus', 'Sarmiento', 'operador@boticabiofarma.pe', '$2b$10$dlnEYqTyksg8H6Sf7iI0qOloaCitxXk.M2IaItUpvsE7EOsuihaWe', 2, 1);

-- 10 Categorías reales de botica
INSERT INTO sti_g06_categorias (codigo, nombre, descripcion, pasillo_ubicacion, requiere_frio, activo) VALUES
  ('CAT-ANA-01', 'Analgésicos y Antiinflamatorios', 'Medicamentos para alivio del dolor, fiebre e inflamación muscular o articular', 'Pasillo A - Estante 1', 0, 1),
  ('CAT-ANT-02', 'Antibióticos', 'Fármacos de prescripción médica para tratamiento de infecciones bacterianas', 'Pasillo A - Vitrina Controlada', 0, 1),
  ('CAT-RES-03', 'Salud Respiratoria', 'Jarabes, expectorantes, antigripales y descongestionantes nasales', 'Pasillo A - Estante 3', 0, 1),
  ('CAT-CAR-04', 'Cardiología e Hipertensión', 'Medicamentos para el control de la presión arterial y salud cardiovascular', 'Pasillo A - Estante 4', 0, 1),
  ('CAT-GAS-05', 'Salud Digestiva', 'Antiácidos, protectores gástricos, probióticos y sales de rehidratación', 'Pasillo B - Estante 1', 0, 1),
  ('CAT-PAU-06', 'Primeros Auxilios', 'Alcohol medicinal, gasas estériles, vendas, termómetros y antisépticos', 'Pasillo B - Estante 2', 0, 1),
  ('CAT-CUI-07', 'Cuidado Personal e Higiene', 'Jabones líquidos, pastas dentales, desodorantes, shampoos y cremas corporales', 'Pasillo C - Estante 1', 0, 1),
  ('CAT-DER-08', 'Dermatología y Protección Solar', 'Bloqueadores solares, geles dermatológicos y lociones hidratantes', 'Pasillo C - Estante 2', 0, 1),
  ('CAT-VIT-09', 'Vitaminas y Suplementos', 'Multivitamínicos, vitamina C, magnesio, calcio y colágeno hidrolizado', 'Pasillo B - Estante 4', 0, 1),
  ('CAT-BIO-10', 'Biológicos y Cadena de Frío', 'Insulinas, vacunas y productos farmacéuticos que requieren refrigeración controlada', 'Cámara Fría - Módulo 1', 1, 1);

-- 10 Proveedores / Laboratorios farmacéuticos
INSERT INTO sti_g06_proveedores (ruc, razon_social, nombre_comercial, telefono, correo, direccion, activo) VALUES
  ('20100018625', 'Medifarma S.A.', 'Laboratorios Medifarma', '01-3326200', 'ventas@medifarma.com.pe', 'Jr. Ecuador 787, Cercado de Lima', 1),
  ('20100024609', 'Farmindustria S.A.', 'Farmindustria Perú', '01-2212100', 'pedidos@farmindustria.com.pe', 'Av. Mariscal Oscar R. Benavides 5812, Callao', 1),
  ('20100204330', 'Laboratorios Portugal S.R.L.', 'Lab. Portugal', '054-252627', 'comercial@labportugal.com', 'Parque Industrial Río Seco, Arequipa', 1),
  ('20100096341', 'Bayer S.A.', 'Bayer HealthCare Perú', '01-2113800', 'contacto.peru@bayer.com', 'Av. Paseo de la República 3074, San Isidro', 1),
  ('20100152356', 'Química Suiza S.A.C.', 'Química Suiza Distribución', '01-2114000', 'clientes@quimicasuiza.com', 'Av. República de Panamá 2577, La Victoria', 1),
  ('20100073723', 'Droguería Alfaro S.A.C.', 'Droguería Alfaro', '01-4220880', 'atencion@drogueriaalfaro.pe', 'Av. Nicolás Arriola 824, La Victoria', 1),
  ('20265733515', 'Laboratorios AC Farma S.A.', 'AC Farma', '01-4361515', 'ventas@acfarma.com', 'Calle Los Hornos 185, Ate, Lima', 1),
  ('20503840121', 'Hersil S.A. Laboratorios Industriales Farmacéuticos', 'Laboratorios Hersil', '01-7133333', 'comercial@hersil.com.pe', 'Av. Los Frutales 220, Ate, Lima', 1),
  ('20100128056', 'Procter & Gamble Perú S.R.L.', 'P&G Salud e Higiene', '01-2153300', 'distribucion.pe@pg.com', 'Av. Pardo y Aliaga 695, San Isidro', 1),
  ('20100116805', 'Johnson & Johnson del Perú S.A.', 'J&J Consumo Masivo', '01-2117200', 'pedidos.pe@jnj.com', 'Av. Canaval y Moreyra 480, San Isidro', 1);

-- 12 Productos reales de Botica Biofarma
INSERT INTO sti_g06_productos (sku, nombre, gramaje, categoria_id, proveedor_id, precio, stock, requiere_receta, imagen, activo) VALUES
  ('BIO-MED-001', 'Paracetamol 500mg Caja x 100', '500 mg', 1, 1, 12.50, 140, 0, 'paracetamol_500mg.png', 1),
  ('BIO-MED-002', 'Ibuprofeno 400mg Blíster x 10', '400 mg', 1, 2, 4.80, 95, 0, 'ibuprofeno_400mg.png', 1),
  ('BIO-MED-003', 'Ibuprofeno 600mg Caja x 20', '600 mg', 1, 1, 14.90, 62, 0, 'ibuprofeno_600mg.png', 1),
  ('BIO-ANT-004', 'Amoxicilina 500mg Cápsulas x 12', '500 mg', 2, 7, 18.50, 48, 1, 'amoxicilina_500mg.png', 1),
  ('BIO-RES-005', 'Jarabe Expectorante Ambroxol', '120 ml', 3, 3, 16.00, 35, 0, 'jarabe_tos.png', 1),
  ('BIO-CAR-006', 'Losartán Potásico 50mg Caja x 30', '50 mg', 4, 8, 22.00, 40, 1, 'losartan_50mg.png', 1),
  ('BIO-GAS-007', 'Omeprazol 20mg Cápsulas x 14', '20 mg', 5, 2, 9.50, 88, 0, 'paracetamol_1g.png', 1),
  ('BIO-PAU-008', 'Alcohol Medicinal 70° Frasco', '500 ml', 6, 3, 7.90, 110, 0, 'alcohol_medicinal.png', 1),
  ('BIO-PAU-009', 'Termómetro Digital Clínico', '1 unidad', 6, 5, 19.90, 28, 0, 'termometro.png', 1),
  ('BIO-PAU-010', 'Vendas de Gasa Estéril 4x5', 'Paquete x 5', 6, 6, 8.40, 74, 0, 'vendas_gasa.png', 1),
  ('BIO-CUI-011', 'Shampoo Anticaspa Control Total', '400 ml', 7, 9, 24.50, 52, 0, 'shampoo_anticaspa.png', 1),
  ('BIO-CUI-012', 'Jabón Líquido Antibacterial Neutro', '350 ml', 7, 10, 13.80, 65, 0, 'jabon_liquido.png', 1);

-- 10 Clientes reales simulados
INSERT INTO sti_g06_clientes (dni, nombres, apellidos, telefono, correo, direccion, activo) VALUES
  ('71452890', 'María Fernanda', 'Quispe Mamani', '952418763', 'mfernanda.quispe@gmail.com', 'Av. Bolognesi 842, Tacna', 1),
  ('45891234', 'Carlos Alberto', 'Mendoza Flores', '952784120', 'cmendoza.flores@hotmail.com', 'Calle Blondell 315, Cercado, Tacna', 1),
  ('73901456', 'Lucía Valeria', 'Choque Condori', '983651429', 'lucia.choque@outlook.com', 'Av. Leguía 1420, Alto de la Alianza, Tacna', 1),
  ('41236589', 'Jorge Luis', 'Paredes Vargas', '952119834', 'jparedes.v@gmail.com', 'Jr. San Martín 560, Tacna', 1),
  ('76124893', 'Ana Gabriela', 'Rojas Gutiérrez', '944201856', 'anag.rojas@gmail.com', 'Urb. Vigil Mz. C Lt. 12, Tacna', 1),
  ('48952310', 'Diego Armando', 'Salazar Ticona', '952903417', 'dsalazar.ticona@yahoo.com', 'Av. Coronel Mendoza 1125, Tacna', 1),
  ('70843219', 'Rosa Elena', 'Huanca Apaza', '974512389', 'rosa.huanca@gmail.com', 'Asoc. Alfonso Ugarte Mz. H Lt. 4, Gregorio Albarracín', 1),
  ('43567891', 'Miguel Ángel', 'Cáceres Velásquez', '952334781', 'mcaceres.v@outlook.com', 'Av. Cusco 678, Pocollay, Tacna', 1),
  ('74561209', 'Fiorella Paola', 'Zegarra Pinto', '987123654', 'fiorella.zegarra@gmail.com', 'Calle Zela 418, Tacna', 1),
  ('46781235', 'Héctor Raúl', 'Linares Morales', '952647892', 'hlinares.morales@gmail.com', 'Av. Jorge Basadre 950, Ciudad Nueva, Tacna', 1);
