<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    // Propiedades del usuario que coinciden con tu base de datos
    public $id;
    public $nombre;
    public $correo;
    public $contrasena;
    public $rol;
    public $fecha_registro;

    // Al instanciar el modelo, le pasamos la conexión a la base de datos
    public function __construct($db) {
        $this->conn = db;
    }

    // Método para registrar un nuevo usuario (Productor o Comprador)
    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, correo=:correo, contrasena=:contrasena, rol=:rol";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos contra inyecciones de código
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->rol = htmlspecialchars(strip_tags($this->rol));

        // Encriptar la contraseña de forma segura antes de guardarla
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
}
?>
