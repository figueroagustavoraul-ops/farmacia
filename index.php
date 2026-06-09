<?php include 'productos.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Norte Grande Pharma | Alta Gama & Bienestar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- NAVBAR COHESIVA -->
    <header class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">NG<span>Pharma</span></a>
            <nav class="menu">
                <a href="index.php" class="active">Showroom Digital</a>
                <a href="#corporativo">Servicios B2B</a>
            </nav>
        </div>
    </header>

    <!-- SECCIÓN HERO -->
    <main class="container section-padding" style="text-align: center;">
        <div class="section-header">
            <span class="sub-title">División Profesional & Bienestar</span>
            <h1 style="font-size: 3.5rem; font-weight: 900; color: #fff; margin-bottom: 1rem; letter-spacing: -1px;">Farmacia Digital Premium</h1>
            <p style="color: var(--text-muted); max-width: 700px; margin: 0 auto 2.5rem auto; font-size: 1.1rem; line-height: 1.6;">
                Provisión selecta de compuestos dermocosméticos, dispositivos de precisión médica y suplementos de alta performance con trazabilidad certificada.
            </p>
        </div>
    </main>

    <!-- MÓDULO DINÁMICO DE FILTROS -->
    <section class="container" style="padding-bottom: 2rem;">
        <div class="filter-wrapper">
            <div class="filter-box">
                <div class="filter-group">
                    <label>Línea / Laboratorio</label>
                    <select id="filtro-marca" class="input-field-sm">
                        <option value="todos">Todos los laboratorios</option>
                        <option value="laroche">La Roche-Posay</option>
                        <option value="vishy">Vichy</option>
                        <option value="nutri">NutriPerformance</option>
                        <option value="omron">Omron Medical</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Categoría</label>
                    <select id="filtro-categoria" class="input-field-sm">
                        <option value="todos">Todas las categorías</option>
                        <option value="dermo">Dermocosmética</option>
                        <option value="suplementos">Suplementos Premium</option>
                        <option value="dispositivos">Tecnología Médica</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Rango de Valores</label>
                    <select id="filtro-precio" class="input-field-sm">
                        <option value="todos">Todos los valores</option>
                        <option value="bajo">Hasta $50.000 ARS</option>
                        <option value="alto">Más de $50.000 ARS</option>
                    </select>
                </div>
                <button id="btn-limpiar" class="btn btn-outline-light" style="padding:0.6rem 1.2rem;">Limpiar</button>
            </div>
        </div>

        <div id="sin-resultados" style="display: none; text-align: center; padding: 4rem; color: var(--text-muted);">
            <h3>⚠️ No poseemos stock disponible para esa combinación de filtros.</h3>
        </div>
    </section>

    <!-- GRILLA GENERADA DINÁMICAMENTE POR PHP -->
    <section class="container" style="padding-bottom: 4rem;">
        <div class="grid-autos" id="contenedor-pharma">
            <?php foreach ($productos as $prod): 
                $rango_precio = ($prod['precio'] <= 50000) ? 'bajo' : 'alto';
                // Convertimos el array de especificaciones a un string JSON seguro para leer desde JavaScript
                $specs_json = htmlspecialchars(json_encode($prod['especificaciones']), ENT_QUOTES, 'UTF-8');
            ?>
                <article class="card-auto" 
                         data-marca="<?php echo $prod['marca']; ?>" 
                         data-categoria="<?php echo $prod['categoria']; ?>" 
                         data-precio="<?php echo $rango_precio; ?>"
                         data-nombre="<?php echo htmlspecialchars($prod['nombre']); ?>"
                         data-precio-full="<?php echo number_format($prod['precio'], 0, ',', '.'); ?>"
                         data-foto1="<?php echo $prod['foto1']; ?>"
                         data-foto2="<?php echo $prod['foto2']; ?>"
                         data-desc="<?php echo htmlspecialchars($prod['descripcion']); ?>"
                         data-specs="<?php echo $specs_json; ?>">
                    
                    <div class="tag-status <?php echo $prod['tag_clase']; ?>"><?php echo $prod['stock']; ?></div>
                    <div class="img-zoom-container">
                        <img src="<?php echo $prod['foto1']; ?>" class="auto-img" alt="<?php echo $prod['nombre']; ?>">
                    </div>
                    <div class="card-auto-body">
                        <span class="categoria text-metal-gold"><?php echo strtoupper($prod['categoria']); ?></span>
                        <h3><?php echo $prod['nombre']; ?></h3>
                        <div class="precio-auto text-metal-gold">$ <?php echo number_format($prod['precio'], 0, ',', '.'); ?> <span class="moneda-ref">ARS</span></div>
                        <p class="descripcion-corta"><?php echo $prod['descripcion']; ?></p>
                        <button class="btn-open-details" onclick="verDetallesProducto(this)">Ficha Técnica & Análisis →</button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- VENTANA MODAL FLOTANTE (Detalles dinámicos con galería) -->
    <div id="custom-modal" class="modal-overlay">
        <div class="modal-card">
            <span class="close-modal-btn" onclick="cerrarFichaModal()">&times;</span>
            <h2 id="m-titulo" style="font-size:1.6rem; margin-bottom: 1.5rem; font-weight:900; color: #fff;">Producto</h2>
            
            <div class="modal-gallery">
                <img id="m-img1" src="" alt="Frente del Producto">
                <img id="m-img2" src="" alt="Textura / Componentes">
            </div>

            <p id="m-descripcion" style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"></p>

            <div class="modal-technical-sheet">
                <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #fff; margin-bottom: 0.5rem;">Especificaciones Analíticas</h4>
                <div id="m-specs-contenedor"></div>
                <div class="tech-item" style="border:none; margin-top:1rem; padding-top:1rem; border-top:1px dashed var(--border-color);">
                    <strong style="color:var(--text-light); font-size:1.1rem;">Precio Exclusivo Digital:</strong> 
                    <div>
                        <span id="m-precio" class="text-metal-gold" style="font-size:1.4rem; font-weight:900;"></span> 
                        <span style="font-size:0.8rem; color:var(--text-muted);">ARS</span>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" style="width:100%; margin-top:1.5rem; padding:0.8rem;" onclick="alert('Enviando pedido al canal de empaque prioritario...')">Añadir al Carrito de Suministros</button>
        </div>
    </div>

    <!-- BURBUJA DE ASISTENTE DE IA ESPECIALIZADA -->
    <div class="ai-bubble-container">
        <div class="ai-chat-window" id="ai-chat">
            <div class="ai-chat-header">
                <div class="ai-status-dot"></div>
                <span>Pharma Intellect Bot</span>
            </div>
            <div class="ai-chat-body" id="ai-body-content">
                <p class="ai-msg-bot">Hola. Soy el asistente de validación e IA de NG Pharma. ¿Tenés dudas sobre las interacciones de un compuesto, stock institucional o necesitás asesoramiento en dermo-estética?</p>
            </div>
            <div class="ai-chat-footer">
                <input type="text" placeholder="Consultar sobre laboratorios o precios..." id="ai-input">
                <button onclick="enviarMensajeIA()">➔</button>
            </div>
        </div>
        <button class="ai-bubble-trigger" onclick="toggleAIChat()">
            <span class="ai-icon">✨</span>
            <span class="ai-badge">IA</span>
        </button>
    </div>

    <footer class="footer"><div class="container"><p>&copy; 2026 Norte Grande Pharma. Todos los derechos reservados.</p></div></footer>

    <script src="script-pharma.js"></script>
</body>
</html>