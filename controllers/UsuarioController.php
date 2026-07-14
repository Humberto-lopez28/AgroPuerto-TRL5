<?php
// controllers/UsuarioController.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Requerir el archivo de infraestructura de conexión
require_once __DIR__ . '/../config/conexion.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

switch ($accion) {
    case 'login':
        procesarLogin();
        break;
    case 'registro':
        procesarRegistro();
        break;
    case 'logout':
        procesarLogout();
        break;
    default:
        header("Location: ../index.php");
        exit();
}

// 1. INICIO DE SESIÓN COMPROBANDO CREDENCIALES EN MYSQL
function procesarLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = trim($_POST['correo']);
        $password = trim($_POST['password']);

        if (empty($correo) || empty($password)) {
            $_SESSION['mensaje_error'] = "Todos los campos técnicos son obligatorios.";
            header("Location: ../views/login.php");
            exit();
        }

        try {
            $db = Conexion::conectar();
            // Consultar si el correo electrónico existe en la BD
            $stmt = $db->prepare("SELECT id, nombre, contrasena, rol FROM usuarios WHERE correo = :correo LIMIT 1");
            $stmt->execute([':correo' => $correo]);
            $usuario = $stmt->fetch();

            // Verificar si el usuario existe y comprobar la contraseña cifrada
            if ($usuario && password_verify($password, $usuario['contrasena'])) {
                // Autenticación exitosa: Registrar variables globales de sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['mensaje_error'] = "Credenciales incorrectas para el circuito agrícola. Intente de nuevo.";
                header("Location: ../views/login.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "Error en el servidor de datos: " . $e->getMessage();
            header("Location: ../views/login.php");
            exit();
        }
    }
}

// 2. REGISTRO REAL E INSERCIÓN EN LA TABLA DE USUARIOS
function procesarRegistro() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $password = trim($_POST['password']);
        $rol = trim($_POST['rol']); // 'productor' o 'comprador'

        if (empty($nombre) || empty($correo) || empty($password) || empty($rol)) {
            $_SESSION['mensaje_error'] = "Error de consistencia: Faltan campos en el formulario.";
            header("Location: ../views/registro.php");
            exit();
        }

        try {
            $db = Conexion::conectar();

            // Validar de forma preventiva que el correo no esté duplicado
            $checkStmt = $db->prepare("SELECT id FROM usuarios WHERE correo = :correo LIMIT 1");
            $checkStmt->execute([':correo' => $correo]);
            if ($checkStmt->fetch()) {
                $_SESSION['mensaje_error'] = "El correo electrónico ya se encuentra registrado en el sistema.";
                header("Location: ../views/registro.php");
                exit();
            }

            // Cifrar la contraseña utilizando el algoritmo robusto BCRYPT (Requisito de seguridad)
            $passwordCifrada = password_hash($password, PASSWORD_BCRYPT);

            // Insertar el nuevo registro en la base de datos
            $insertStmt = $db->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (:nombre, :correo, :contrasena, :rol)");
            $insertStmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':contrasena' => $passwordCifrada,
                ':rol' => $rol
            ]);

            $_SESSION['mensaje_exito'] = "¡Excelente! Cuenta creada con éxito para " . htmlspecialchars($nombre) . ". Ingrese sus credenciales para operar.";
            header("Location: ../views/login.php");
            exit();

        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "Error de infraestructura: " . $e->getMessage();
            header("Location: ../views/registro.php");
            exit();
        }
    }
}

// 3. CIERRE DE SESIÓN SEGURO
function procesarLogout() {
    session_unset();
    session_destroy();
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['mensaje_exito'] = "Sesión cerrada correctamente. Conexión a la base de datos liberada.";
    header("Location: ../views/login.php");
    exit();
}
