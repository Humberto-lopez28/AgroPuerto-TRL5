<?php
// Iniciar o reanudar la sesión del usuario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - Plataforma Principal</title>
</head>
<body>
    <h1>AgroPuerto: Plataforma Web para la Optimización del Circuito Corto de Comercialización Agrícola</h1>

    <!-- Verificar si hay una sesión activa de usuario -->
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <h2>¡Bienvenido de nuevo, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</h2>
        <p>Tu rol en el sistema es: <strong><?php echo htmlspecialchars($_SESSION['usuario_rol']); ?></strong></p>
        
        <!-- Contenido dinámico según el rol -->
        <?php if ($_SESSION['usuario_rol'] === 'productor'): ?>
            <p>Acceso concedido al <strong>Panel del Agricultor</strong>. Aquí puedes publicar tus productos.</p>
        <?php else: ?>
            <p>Acceso concedido al <strong>Catálogo de Compras</strong>. Aquí puedes adquirir productos del campo.</p>
        <?php endif; ?>

        <!-- Enlace para cerrar sesión en el futuro -->
        <p><a href="controllers/UsuarioController.php?accion=logout">Cerrar Sesión</a></p>

    <?php else: ?>
        <h2>Bienvenido al Sistema Comercial Agrícola</h2>
        <p>Para interactuar con la plataforma, publicar productos o realizar compras, por favor accede al sistema:</p>
        
        <p>
            <a href="views/login.php"><button>Iniciar Sesión</button></a>
            <a href="views/registro.php"><button>Registrarse</button></a>
        </p>
    <?php endif; ?>
</body>
</html>
