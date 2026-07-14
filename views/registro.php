<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - Registro de Usuarios</title>
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
            <span class="text-xs text-slate-400 font-mono">Componente: Registro TRL5</span>
        </div>
    </header>

    <!-- Contenedor del Formulario -->
    <main class="max-w-md mx-auto px-4 py-10 flex-grow flex items-center justify-center w-full">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 w-full space-y-6">
            
            <!-- Encabezado con Descripción Ampliada -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl text-xl font-bold shadow-inner">📝</div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Crear Cuenta Técnica</h2>
                
                <!-- DESCRIPCIÓN AMPLIADA -->
                <p class="text-xs text-slate-500 leading-relaxed max-w-sm mx-auto pt-1 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    🌾 <strong>Nota de Selección de Rol:</strong> Elija <em>Productor</em> si cosechas en la vereda La Bendición y necesitas publicar ofertas. Selecciona <em>Comprador</em> si representas el consumo final o distribución directa.
                </p>
            </div>

            <!-- COMPONENTE: MENSAJES DE ALERTA -->
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs flex items-start gap-2.5 shadow-sm">
                    <span class="text-base leading-none">❌</span>
                    <div>
                        <strong class="font-bold block">Error en la Operación</strong>
                        <span><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulario de Registro Conectado al Controlador -->
            <form action="../controllers/UsuarioController.php?accion=registro" method="POST" class="space-y-4">
                
                <!-- Campo de Nombre Completo -->
                <div class="space-y-1.5">
                    <label for="nombre" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Nombre Completo / Razón Social</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Ej: Juan Pérez o Asociación Coop" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none">
                </div>

                <!-- Campo de Correo Electrónico -->
                <div class="space-y-1.5">
                    <label for="correo" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" required placeholder="correo@ejemplo.com" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none">
                </div>

                <!-- Campo de Contraseña -->
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Contraseña del Sistema</label>
                    <input type="password" name="password" id="password" required placeholder="Mínimo 6 caracteres" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none">
                </div>

                <!-- Campo de Selección de Rol Técnico (ENUM en DB) -->
                <div class="space-y-1.5">
                    <label for="rol" class="text-xs font-bold uppercase tracking-wider text-slate-600 block">Tipo de Perfil Operativo</label>
                    <div class="relative">
                        <select name="rol" id="rol" required 
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none appearance-none cursor-pointer">
                            <option value="" disabled selected>Seleccione su rol técnico...</option>
                            <option value="productor">Productor (Vendedor Agrícola)</option>
                            <option value="comprador">Comprador (Cliente / Distribuidor)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            ▼
                        </div>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-5 rounded-xl shadow-md shadow-emerald-600/10 hover:shadow-lg transition-all duration-200 cursor-pointer text-sm mt-2">
                    Dar de Alta en la Red
                </button>
            </form>

            <!-- Enlace de Retorno -->
            <p class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
                ¿Ya posees credenciales? <a href="login.php" class="text-emerald-600 font-bold hover:underline">Inicia Sesión</a>
            </p>

        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="bg-slate-100 border-t border-slate-200 py-4 text-center">
        <p class="text-[11px] text-slate-400">
            Registro de Nodos Locales - AgroPuerto TRL 5. Datos integrados de forma segura con MySQL Core.
        </p>
    </footer>

</body>
</html>
