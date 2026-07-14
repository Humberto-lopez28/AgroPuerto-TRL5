# AgroPuerto: Plataforma Web para la Optimización del Circuito Corto de Comercialización Agrícola
> **Proyecto de Grado - Fase 4 (Desarrollo de la Propuesta Ingenieril)**  
> **Nivel de Maduración Tecnológica:** TRL 5 (Prototipo validado en entorno relevante)

[![Stack](https://shields.io)](https://wikipedia.org)
[![PHP](https://shields.io)](https://php.net)
[![MySQL](https://shields.io)](https://mysql.com)
[![Environment](https://shields.io)](#)

---

## 👥 Equipo Desarrollador (UNAD)
* **Jorge Humberto López Adán** - Código: 202016907
* **Jonatan Stiven Criales Alzate**
* **Angie Paola Triana Fernández**

**Docente / Tutor de Grado:** Daniel Andrés Guzmán Arévalo  

---

## 📝 Descripción del Proyecto
AgroPuerto es una solución de ingeniería de software diseñada bajo la arquitectura cliente-servidor para mitigar la brecha de intermediación comercial que afecta a los pequeños productores de la vereda **La Bendición (Puerto Carreño, Vichada)**. 

El sistema implementa interfaces responsivas ligeras basadas en la filosofía *Mobile-First*, optimizadas algorítmicamente para operar de manera eficiente bajo restricciones críticas de conectividad móvil (redes celulares 3G rurales).

---

## 🛠️ Arquitectura de Software y Stack Tecnológico
La plataforma se rige bajo el patrón de diseño estructural **Modelo-Vista-Controlador (MVC)**, garantizando la modularidad, escalabilidad y seguridad de los datos:

*   **Capa de Presentación (Views):** HTML5 semántico, hojas de estilo en CSS3 nativo y JavaScript Vanilla (asíncrono vía Fetch API para evitar recargas completas de página y ahorrar datos móviles).
*   **Capa de Lógica de Negocio (Controllers):** PHP 8.x con enrutamiento dinámico, sanitización de datos de entrada y manejo seguro de sesiones de usuario.
*   **Capa de Persistencia (Models):** MySQL / MariaDB mediante abstracción con PDO (PHP Data Objects) para prevenir ataques de inyección SQL (SQLi).

---

## 📁 Estructura del Repositorio
```diagram
AgroPuerto-TRL5/
├── core/
│   └── Connection.php       # Conexión persistente a la BD mediante PDO
├── models/
│   ├── ProductorModel.php   # Lógica relacional de los usuarios productores
│   └── ProductoModel.php    # Gestión del catálogo y ofertas agrícolas
├── controllers/
│   ├── AuthController.php   # Control de acceso y sesiones seguras
│   └── ProductoController.php # Procesamiento de ofertas e inventario
├── views/
│   ├── public/              # Catálogo abierto al consumidor (Circuito Corto)
│   ├── dashboard/           # Panel privado de administración del productor
│   └── modules/             # Componentes reutilizables (Navbar, Footer)
├── assets/
│   ├── css/                 # Hojas de estilo optimizadas (Minificadas)
│   └── js/                  # Scripts en Vanilla JS para interacción fluida
├── database/
│   └── agropuerto_db.sql    # Script estructurado de la base de datos relacional
└── README.md                # Ficha técnica del proyecto
```

---

## 🚀 Requisitos e Instalación Local

### Requisitos Previos
*   Servidor local con soporte para **PHP 8.0 o superior**.
*   Gestor de bases de datos **MySQL 5.7+** o **MariaDB 10.4+**.
*   Entorno recomendado: XAMPP, Wampserver o Docker.

### Pasos para el Despliegue
1. **Clonar el repositorio dentro del servidor local:**
   ```bash
   git clone https://github.com
   ```
2. **Configurar la Base de Datos:**
   * Ingrese a `phpMyAdmin` (o su gestor preferido).
   * Cree una nueva base de datos llamada `agropuerto_db`.
   * Importe el archivo ubicado en `/database/agropuerto_db.sql`.
3. **Ejecutar la aplicación:**
   * Inicie los servicios de Apache y MySQL en su servidor.
   * Abra su navegador web e ingrese a: `http://localhost/AgroPuerto-TRL5/views/public/index.php`
