<?php
// config/conexion.php

class Conexion {
    private static $host = "localhost";
    private static $dbName = "agropuerto_db"; // Nombre exacto de tu script SQL
    private static $usuario = "root";
    private static $password = ""; // En los entornos de Codespaces por defecto va vacío
    private static $conexion = null;

    public static function conectar() {
        // Aplicar patrón Singleton para no duplicar conexiones innecesariamente
        if (self::$conexion === null) {
            try {
                self::$conexion = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8", 
                    self::$usuario, 
                    self::$password
                );
                // Configurar manejo de errores estrictos para depuración en ingeniería
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error crítico de infraestructura: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
?>
