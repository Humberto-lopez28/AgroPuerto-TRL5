-- ============================================================================
-- ARQUITECTURA DE BASE DE DATOS RELACIONAL - PROYECTO AGROPUERTO (TRL 5)
-- Estudiantes: Jorge López, Jonatan Criales, Angie Triana
-- Curso: Proyecto de Grado - UNAD 2026
-- ============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";

-- ----------------------------------------------------------------------------
-- 1. ESTRUCTURA DE LA TABLA: categorias
-- (Permite el filtrado eficiente del catálogo público)
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar categorías base solicitadas en los requerimientos
INSERT INTO `categorias` (`nombre_categoria`, `descripcion`) VALUES
('Frutas', 'Productos frutales frescos de la región'),
('Verduras y Hortalizas', 'Verduras cosechadas localmente'),
('Tubérculos y Raíces', 'Yuca, plátano, papa y similares'),
('Cereales y Legumbres', 'Maíz, frijol y producción de grano');

-- ----------------------------------------------------------------------------
-- 2. ESTRUCTURA DE LA TABLA: usuarios (Productores Agrícolas)
-- (Soporta el RF-01 y RF-02: Registro, inicio de sesión y datos de contacto)
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL UNIQUE,
  `telefono_whatsapp` varchar(20) NOT NULL,
  `nombre_finca` varchar(100) DEFAULT NULL,
  `vereda_sector` varchar(100) DEFAULT 'Vereda La Bendición',
  `correo_electronico` varchar(100) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. ESTRUCTURA DE LA TABLA: productos (Ofertas Comerciales Activas)
-- (Soporta el RF-03 y RF-04: CRUD de cosechas y despliegue en Catálogo)
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion_cosecha` text DEFAULT NULL,
  `precio_unidad` decimal(10,2) NOT NULL,
  `unidad_medida` varchar(20) NOT NULL DEFAULT 'Kilogramo',
  `cantidad_disponible` int(11) NOT NULL,
  `url_imagen` varchar(255) DEFAULT 'assets/img/default-producto.jpg',
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_oferta` enum('Activo','Agotado') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id_producto`),
  KEY `fk_productos_usuarios` (`id_usuario`),
  KEY `fk_productos_categorias` (`id_categoria`),
  CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_productos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

