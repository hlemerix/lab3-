<?php
// includes/header.php - Cabecera modular: metadatos, navbar y breadcrumb dinámico

// Bloquea el acceso directo por URL (solo funciona si la página principal definió APP_RUNNING)
if (!defined('APP_RUNNING')) {
    http_response_code(403);
    die('Acceso directo no permitido.');
}

// Detectamos el nombre del archivo actual (ej: index.php o procesar.php)
$paginaActual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Admisión de la UTP</title>
    <meta name="description" content="Sistema de admisión de datos para aspirantes">
    <meta name="author" content="Universidad Tecnológica de Panamá / HANNA LICONA">
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body
