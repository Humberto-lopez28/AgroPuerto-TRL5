<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión - AgroPuerto</h2>
    
    <!-- Mensaje en caso de que el usuario se acabe de registrar con éxito -->
    <?php if(isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
        <p style="color: green;">¡Registro exitoso! Ya puedes iniciar sesión.</p>
    <?php endif; ?>

    <!-- Formulario que enviará los datos al controlador -->
    <form action="../controllers/UsuarioController.php" method="POST">
        <!-- Un campo oculto para decirle al controlador que esta acción es un login -->
        <input type="hidden" name="accion" value="login">

        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <button type="submit">Ingresar</button>
    </form>

    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</body>
</html>
