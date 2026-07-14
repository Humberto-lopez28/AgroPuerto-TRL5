<?php
// config/conexion.php
class Conexion {
    public static function conectar() {
        $host = "localhost";
        $db = "agropuerto";
        $user = "root";
        $password = ""; // En Codespaces por defecto va vacío
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>

