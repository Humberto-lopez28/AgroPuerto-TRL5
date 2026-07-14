<?php
// Incluimos los archivos necesarios de conexión y modelo
require_once '../database/conexion.php';
require_once '../models/Usuario.php';

class UsuarioController {
    
    // Método para procesar el formulario de registro
    public function registrarUsuario() {
        // Verificar si los datos vienen por método POST desde el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Instanciar la base de datos y obtener la conexión
            $database = new Conexion();
            $db = $database->getConnection();
            
            // Instanciar el modelo de Usuario
            $usuario = new Usuario($db);
            
            // Asignar los datos recibidos del formulario a las propiedades del modelo
            $usuario->nombre = $_POST['nombre'] ?? '';
            $usuario->correo = $_POST['correo'] ?? '';
            $usuario->contrasena = $_POST['contrasena'] ?? '';
            $usuario->rol = $_POST['rol'] ?? 'comprador'; // Rol por defecto
            
            // Validar que los campos obligatorios no estén vacíos
            if (!empty($usuario->nombre) && !empty($usuario->correo) && !empty($usuario->contrasena)) {
                
                // Intentar registrar en la base de datos
                if ($usuario->registrar()) {
                    // Si es exitoso, redirigir al login o enviar mensaje de éxito
                    header("Location: ../views/login.php?registro=exitoso");
                    exit();
                } else {
                    echo "Error al registrar el usuario. El correo podría estar duplicado.";
                }
            } else {
                echo "Por favor, completa todos los campos del formulario.";
            }
        }
    }
}
?>
