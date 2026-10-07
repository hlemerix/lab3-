<?php
// index.php - Formulario de registro de aspirantes
define('APP_RUNNING', true);
include 'includes/header.php';
?>

<main class="flex-grow-1 py-4">
    <section class="container">
        <h1 class="h3 fw-bold mb-4 text-center">Formulario de Registro de Aspirantes</h1>

        <?php include 'includes/formulario.php'; ?>

    </section>
</main>

<?php include 'includes/footer.php'; ?>