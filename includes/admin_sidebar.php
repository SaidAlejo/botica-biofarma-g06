<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<button class="mobile-toggle" onclick="document.querySelector('.admin-sidebar').classList.toggle('active')">
    <i class="fa-solid fa-bars"></i>
</button>
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">Panel Admin</h2>
        <p class="sidebar-subtitle">Botica Biofarma</p>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="admin.php" class="sidebar-link <?= $pagina_actual === 'admin.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-border-all"></i> Dashboard
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_productos.php" class="sidebar-link <?= in_array($pagina_actual, ['admin_productos.php', 'admin_agregar_producto.php', 'admin_editar_producto.php']) ? 'active' : '' ?>">
                <i class="fa-solid fa-box"></i> Productos
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_categorias.php" class="sidebar-link <?= $pagina_actual === 'admin_categorias.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-folder"></i> Categorías
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_proveedores.php" class="sidebar-link <?= $pagina_actual === 'admin_proveedores.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-truck-medical"></i> Proveedores
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_clientes.php" class="sidebar-link <?= $pagina_actual === 'admin_clientes.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i> Clientes
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_mensajes.php" class="sidebar-link <?= $pagina_actual === 'admin_mensajes.php' ? 'active' : '' ?>">
                <i class="fa-regular fa-comment-dots"></i> Mensajes
            </a>
        </li>
        <li class="sidebar-item" style="margin-top: 20px;">
            <a href="catalogo.php" target="_blank" class="sidebar-link">
                <i class="fa-solid fa-store"></i> Ver Catálogo Web
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div style="padding: 0 16px 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 10px;">
            <div id="sidebar-user-name" style="font-size: 0.9rem; font-weight: 600; color: #ffffff;">—</div>
            <div id="sidebar-user-role" style="font-size: 0.75rem; color: #919eab;">—</div>
        </div>
        <a href="logout.php" id="btn-cerrar-sesion" class="sidebar-link" style="color: #919eab;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
        </a>
    </div>
</aside>
