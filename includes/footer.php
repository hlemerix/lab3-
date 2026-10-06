<?php
// includes/footer.php - Pie de página modular común
if (!defined('APP_RUNNING')) {
    http_response_code(403);
    die('Acceso directo no permitido.');
}
?>
<footer class="bg-dark text-white text-center py-4 mt-auto">
    <div class="container">
        <p class="mb-1 fw-semibold">Portal de Gestión de Aspirantes — Universidad Tecnológica de Panamá</p>

        <div class="mb-2">
            <a href="index.php" class="text-white text-decoration-none mx-2 small">Inicio</a> |
            <a href="https://github.com" class="text-white text-decoration-none mx-2 small" target="_blank" rel="noopener">GitHub</a> |
            <a href="mailto:soporte@utp.ac.pa" class="text-white text-decoration-none mx-2 small">Soporte Técnico</a>
        </div>

        <!-- Año dinámico -->
        <p class="text-white-50 small mb-0">
            &copy; <?php echo date('Y'); ?> Universidad Tecnológica de Panamá. Todos los derechos reservados.
        </p>
    </div>
</footer>

</body>
</html>
