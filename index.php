<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$productos = [
    ['nom' => 'Plátano Hartón Fresco', 'cat' => 'Tubérculos', 'pre' => 2500, 'uni' => 'Arroba', 'st' => 45, 'desc' => 'Cosechado orgánicamente en la Finca El Recuerdo.', 'img' => 'https://unsplash.com'],
    ['nom' => 'Yuca Blanca Llanera', 'cat' => 'Tubérculos', 'pre' => 1800, 'uni' => 'Kilo', 'st' => 120, 'desc' => 'Yuca suave de excelente calidad, recolectada esta semana.', 'img' => 'https://unsplash.com'],
    ['nom' => 'Maíz Amarillo en Grano', 'cat' => 'Cereales', 'pre' => 3200, 'uni' => 'Kilo', 'st' => 80, 'desc' => 'Grano seleccionado seco, ideal para consumo o procesamiento.', 'img' => 'https://unsplash.com']
];

try {
    $db = new PDO("mysql:host=localhost;dbname=agropuerto_db;charset=utf8mb4", "root", "");
    $stmt = $db->query("SELECT p.*, c.nombre_categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id_categoria WHERE p.estado_oferta = 'Activo' ORDER BY p.id_producto DESC LIMIT 3");
    $reales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($reales)) {
        foreach ($reales as $i => $r) {
            $productos[$i] = ['nom' => $r['nombre_producto'], 'cat' => $r['nombre_categoria'], 'pre' => $r['precio_unidad'], 'uni' => $r['unidad_medida'], 'st' => $r['cantidad_disponible'], 'desc' => $r['descripcion_cosecha'], 'img' => $productos[$i]['img']];
        }
    }
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroPuerto - UNAD 2026</title>
    <style>
        :root { --p: #059669; --bg: #f8fafc; --d: #0f172a; --m: #475569; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
        body { background: var(--bg); color: var(--d); min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between; }
        header { background: white; border-bottom: 1px solid #e2e8f0; padding: 1rem; position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .nav { max-w: 1140px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 0.5rem; font-weight: 900; font-size: 1.25rem; }
        .logo-box { background: var(--p); color: white; padding: 0.5rem; border-radius: 10px; }
        .nav-actions a { font-size: 13px; font-weight: 700; text-decoration: none; padding: 0.6rem 1.2rem; border-radius: 10px; margin-left: 10px; }
        .btn-l { color: var(--m); text-transform: uppercase; }
        .btn-p { background: var(--p); color: white; }
        main { max-w: 1140px; margin: 0 auto; width: 100%; padding: 3rem 1rem; display: grid; grid-template-columns: 1fr; gap: 2rem; }
        @media (min-width: 768px) { main { grid-template-columns: 1.2fr 0.8fr; } }
        .hero { display: flex; flex-direction: column; gap: 1.25rem; justify-content: center; }
        .badge { align-self: flex-start; background: #e6f4ea; color: #137333; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .title { font-size: 2.25rem; font-weight: 900; line-height: 1.2; }
        .desc { color: var(--m); line-height: 1.6; }
        .hero-img-box { border-radius: 24px; overflow: hidden; height: 320px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .hero-img { width: 100%; height: 100%; object-fit: cover; }
        .catalog { background: white; border-top: 1px solid #e2e8f0; padding: 4rem 1rem; }
        .catalog-container { max-w: 1140px; margin: 0 auto; }
        .cat-title { font-size: 1.75rem; font-weight: 900; text-align: center; margin-bottom: 2rem; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        @media (min-width: 768px) { .grid { grid-template-columns: repeat(3, 1fr); } }
        .card { background: var(--bg); border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; }
        .card-img-box { height: 160px; overflow: hidden; position: relative; }
        .card-img { width: 100%; height: 100%; object-fit: cover; }
        .card-tag { position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(0,0,0,0.7); color: white; font-size: 10px; font-weight: 700; padding: 0.2rem 0.5rem; border-radius: 6px; }
        .card-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .card-meta { padding: 1rem 1.25rem; background: white; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .price { font-size: 18px; font-weight: 900; color: var(--p); }
        .stock { font-size: 11px; background: #e6f4ea; padding: 3px 8px; border-radius: 6px; color: #137333; font-weight: 700; }
        footer { background: #0f172a; color: #94a3b8; font-size: 12px; padding: 1.5rem; text-align: center; }
    </style>
</head>
<body>

    <header>
        <div class="nav">
            <div class="logo"><span class="logo-box">🌱</span> AgroPuerto</div>
            <div class="nav-actions">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <span style="font-size:13px">👨‍🌾 <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                    <a href="controllers/UsuarioController.php?accion=logout" class="btn-p" style="background:#ef4444">Salir</a>
                <?php else: ?>
                    <a href="views/login.php" class="btn-l">Ingresar</a>
                    <a href="views/registro.php" class="btn-p">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <div class="hero">
            <div class="badge">✨ Circuito Corto de Comercialización Activo</div>
            <h2 class="title">Conectando el campo directamente con tu mesa</h2>
            <p class="desc">Prototipo tecnológico para la vereda La Bendición. Permitimos la publicación de cosechas en tiempo real eliminando intermediarios.</p>
            <div style="display:flex; gap:1rem; margin-top:0.5rem;">
                <a href="views/login.php" class="btn-p" style="padding:0.8rem 1.5rem; text-decoration:none">Comenzar a Operar</a>
            </div>
        </div>
        <div class="hero-img-box">
            <img src="https://unsplash.com" class="hero-image" alt="Campo">
        </div>
    </main>

    <section class="catalog">
        <div class="catalog-container">
            <h3 class="cat-title">🌾 Cosechas en Tiempo Real</h3>
            <div class="grid">
                <?php foreach ($productos as $p): ?>
                    <div class="card">
                        <div class="card-img-box">
                            <img src="<?php echo $p['img']; ?>" class="card-img" alt="Producto">
                            <span class="card-tag"><?php echo htmlspecialchars($p['cat']); ?></span>
                        </div>
                        <div class="card-body">
                            <h4 style="font-weight:800"><?php echo htmlspecialchars($p['nom']); ?></h4>
                            <p class="desc" style="font-size:13px"><?php echo htmlspecialchars($p['desc']); ?></p>
                        </div>
                        <div class="card-meta">
                            <div class="price">$<?php echo number_format($p['pre'], 0, ',', '.'); ?><span style="font-size:11px; color:var(--m); font-weight:normal"> / <?php echo htmlspecialchars($p['uni']); ?></span></div>
                            <span class="stock">Stock: <?php echo $p['st']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> AgroPuerto - UNAD 2026. Jorge López, Jonatan Criales, Angie Triana.</p>
    </footer>

</body>
</html>
