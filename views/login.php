<?php
// Iniciar sesión para verificar si hay mensajes de error o confirmación pendientes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - Ingreso al Sistema</title>
    <!-- Tailwind CSS -->
    <script src="https://jsdelivr.net"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col justify-between">

    <!-- Navbar Simplificado -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="../index.php" class="flex items-center gap-2 group">
                <span class="text-xl group-hover:scale-110 transition-transform">←</span>
                <span class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Volver al Inicio</span>
            </a>
            <span class="text-xs text-slate-400 font-mono">Componente: Autenticación</span>
        </div>
    </header>

    <!-- Contenedor Principal del Formulario -->
    <main class="max-w-md mx-auto px-4 py-12 flex-grow flex items-center justify-center w-full">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 w-full space-y-6">
            
            <!-- Encabezado con Descripción Ampliada -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl text-xl font-bold shadow-inner">🔑</div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Acceso a la Plataforma</h2>
                
                <!-- DESCRIPCIÓN AMPLIADA (Requerimiento de Usabilidad TRL 5) -->
                <p class="text-xs text-slate-500 leading-relaxed max-w-sm mx-auto pt-1 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    💡 <strong>Nota del Sistema:</strong> Ingrese sus credenciales autorizadas. Si es productor agrícola de la vereda, use el rol asignado en su registro para gestionar la publicación de inventarios en el circuito corto.
                </p>
            </div>

            <!-- COMPONENTE: MENSAJES DE CONFIRMACIÓN / ALERTA -->
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <!-- Alerta Verde de Éxito -->
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-xs flex items-start gap-2.5 shadow-sm animate-pulse">
                    <span class="text-base leading-none">✅</span>
                    <div>
                        <strong class="font-bold block">Operación Exitosa</strong>
                        <span><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <!-- Alerta Roja de Error -->
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs flex items-start gap-2.5 shadow-sm">
                    <span class="text-base leading-none">❌</span>
                    <div>
                        <strong class="font-bold block">Error de Validación</strong>
                        <span><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulario Técnico -->
            <form action="../controllers/UsuarioController.php?accion=login" method="POST" class="space-y-4">
                
                <!-- Campo de Correo -->
                <div class="space-y-1.5">
                    <label for="correo" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" required placeholder="ejemplo@correo.com" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none">
                </div>

                <!-- Campo de Contraseña -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Contraseña</label>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="••••••••" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none">
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-5 rounded-xl shadow-md shadow-emerald-600/10 hover:shadow-lg transition-all duration-200 cursor-pointer text-sm mt-2">
                    Verificar Credenciales
                </button>
            </form>

            <!-- Enlace alternativo -->
            <p class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
                ¿Aún no tienes una cuenta técnica? <a href="registro.php" class="text-emerald-600 font-bold hover:underline">Regístrate aquí</a>
            </p>

        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="bg-slate-100 border-t border-slate-200 py-4 text-center">
        <p class="text-[11px] text-slate-400">
            Módulo de Acceso Seguro - AgroPuerto TRL 5. Todos los datos viajan cifrados hacia MySQL.
        </p>
    </footer>

</body>
</html>
