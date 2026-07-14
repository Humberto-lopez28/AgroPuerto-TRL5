<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    // Propiedades del usuario (coinciden con la base de datos)
    public $id;
    public $nombre;
    public $correo;
    public $contrasena;
    public $rol;
    public $fecha_registro;

    // Constructor: recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo usuario (Productor o Comprador)
    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, correo=:correo, contrasena=:contrasena, rol=:rol";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos contra inyecciones de código (Sanitización)
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->rol = htmlspecialchars(strip_tags($this->rol));

        // Encriptar la contraseña de forma segura usando BCRYPT
        $password_hash = password_hash($this->contrasena, PASSWORD_BCRYPT);

        // Vincular los valores con los parámetros de la consulta SQL
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":contrasena", $password_hash);
        $stmt->bindParam(":rol", $this->rol);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para verificar las credenciales de inicio de sesión
    public function login() {
        // Consulta para buscar al usuario por su correo electrónico
        $query = "SELECT id, nombre, contrasena, rol FROM " . $this->table_name . " WHERE correo = :correo LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // Limpiar el parámetro para evitar inyecciones
        $this->correo = htmlspecialchars(strip_tags($this->correo));

        // Vincular el correo
        $stmt->bindParam(":correo", $this->correo);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se encontró el correo en la base de datos
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña ingresada coincide con el hash encriptado
            if(password_verify($this->contrasena, $row['contrasena'])) {
                // Asignar los datos del usuario a las propiedades del objeto para usarlos en la sesión
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->rol = $row['rol'];
                return true;
            }
        }
        return false;
    }
}
?>
