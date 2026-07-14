<?php
// Inicializar la sesión del sistema para guardar los datos del usuario logueado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../database/conexion.php';
require_once '../models/Usuario.php';

class UsuarioController {
    
    // Controlador central que decide qué acción ejecutar según el formulario
    public function procesarPeticion() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accion = $_POST['accion'] ?? 'registro';

            if ($accion === 'login') {
                $this->iniciarSesion();
            } else {
                $this->registrarUsuario();
            }
        }
    }

    // Método para procesar el formulario de registro
    private function registrarUsuario() {
        $database = new Conexion();
        $db = $database->getConnection();
        $usuario = new Usuario($db);
        
        $usuario->nombre = $_POST['nombre'] ?? '';
        $usuario->correo = $_POST['correo'] ?? '';
        $usuario->contrasena = $_POST['contrasena'] ?? '';
        $usuario->rol = $_POST['rol'] ?? 'comprador';
        
        if (!empty($usuario->nombre) && !empty($usuario->correo) && !empty($usuario->contrasena)) {
            if ($usuario->registrar()) {
                header("Location: ../views/login.php?registro=exitoso");
                exit();
            } else {
                echo "Error al registrar el usuario. El correo podría estar duplicado.";
            }
        } else {
            echo "Por favor, completa todos los campos del formulario.";
        }
    }

    // Método nuevo para procesar el inicio de sesión (Login)
    private function iniciarSesion() {
        $database = new Conexion();
        $db = $database->getConnection();
        $usuario = new Usuario($db);
        
        $usuario->correo = $_POST['correo'] ?? '';
        $usuario->contrasena = $_POST['contrasena'] ?? '';
        
        if (!empty($usuario->correo) && !empty($usuario->contrasena)) {
            if ($usuario->login()) {
                // Guardar los datos devueltos por el modelo en la sesión global de PHP
                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nombre'] = $usuario->nombre;
                $_SESSION['usuario_rol'] = $usuario->rol;
                
                // Redirigir al index principal del sistema web
                header("Location: ../index.php");
                exit();
            } else {
                echo "Correo electrónico o contraseña incorrectos.";
            }
        } else {
            echo "Por favor, ingresa tus credenciales completas.";
        }
    }
}

// Instanciar el controlador automáticamente para capturar los envíos de los formularios
$controller = new UsuarioController();
$controller->procesarPeticion();
?>
