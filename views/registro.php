<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - Registro</title>
</head>
<body>
    <h2>Formulario de Registro - AgroPuerto</h2>
    
    <!-- El formulario envía los datos por POST al controlador -->
    <form action="../controllers/UsuarioController.php" method="POST">
        
        <label for="nombre">Nombre Completo:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <label for="rol">Tipo de Usuario (Rol):</label><br>
        <select id="rol" name="rol" required>
            <option value="comprador">Comprador / Cliente</option>
            <option value="productor">Productor / Agricultor</option>
        </select><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>
