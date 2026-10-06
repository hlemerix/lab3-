<?php
// procesar.php - Valida, normaliza, calcula edad y guarda la foto
define('APP_RUNNING', true);

// Limpia el texto: trim + strip_tags + htmlspecialchars (contra XSS)
function limpiar(string $valor): string {
    return htmlspecialchars(strip_tags(trim($valor)), ENT_QUOTES, 'UTF-8');
}

// Formato título con tildes: "sofía pérez" -> "Sofía Pérez"
function formatoTitulo(string $texto): string {
    return mb_convert_case(mb_strtolower($texto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

// Si entran directo sin enviar el formulario, los devolvemos al inicio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$errores = [];
$edad = null;
$fotoGuardada = null;
$fotoBase64 = '';

$nombre         = limpiar($_POST['nombre'] ?? '');
$apellido       = limpiar($_POST['apellido'] ?? '');
$identificacion = limpiar($_POST['identificacion'] ?? '');
$fechaNac       = trim($_POST['fecha_nacimiento'] ?? '');
$sexo           = trim($_POST['sexo'] ?? '');

// 1. Campos no vacíos
if ($nombre === '')         $errores[] = 'El nombre es obligatorio.';
if ($apellido === '')       $errores[] = 'El apellido es obligatorio.';
if ($identificacion === '') $errores[] = 'La identificación es obligatoria.';
if ($fechaNac === '')       $errores[] = 'La fecha de nacimiento es obligatoria.';
if ($sexo === '')           $errores[] = 'El sexo es obligatorio.';

if ($sexo !== '' && !in_array($sexo, ['Hombre', 'Mujer'], true)) {
    $errores[] = 'El sexo seleccionado no es válido.';
}

// 2. Estandarizar textos
$nombre         = formatoTitulo($nombre);
$apellido       = formatoTitulo($apellido);
$identificacion = strtoupper($identificacion);

// 3. Edad entre 18 y 70
if ($fechaNac !== '') {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNac);
    if (!$fecha || $fecha->format('Y-m-d') !== $fechaNac) {
        $errores[] = 'La fecha de nacimiento no es válida.';
    } elseif ($fecha > new DateTime('today')) {
        $errores[] = 'La fecha de nacimiento no puede ser futura.';
    } else {
        $edad = (new DateTime('today'))->diff($fecha)->y;
        if ($edad < 18 || $edad > 70) {
            $errores[] = "La edad ($edad años) debe estar entre 18 y 70 años.";
        }
    }
}

// 4. Validar la foto
$extPermitidas  = ['jpg', 'jpeg', 'png', 'gif'];
$mimePermitidos = ['image/jpeg', 'image/png', 'image/gif'];
$maxBytes       = 2 * 1024 * 1024; // 2 MB
$extension = '';
$mime = '';
$tmp = '';

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
    $errores[] = 'Debe seleccionar una fotografía.';
} elseif ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    $errores[] = 'Error al subir la fotografía (código ' . $_FILES['foto']['error'] . ').';
} else {
    $tmp       = $_FILES['foto']['tmp_name'];
    $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $mime      = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);

    if (!in_array($extension, $extPermitidas, true)) {
        $errores[] = 'Extensión no permitida. Use: ' . implode(', ', $extPermitidas) . '.';
    } elseif (!in_array($mime, $mimePermitidos, true) || getimagesize($tmp) === false) {
        $errores[] = 'El archivo no es una imagen válida.';
    } elseif ($_FILES['foto']['size'] > $maxBytes) {
        $errores[] = 'La imagen supera el máximo de 2 MB.';
    }
}

// 5. Guardar la foto solo si todo está bien
if (empty($errores)) {
    $carpeta = __DIR__ . '/uploaded_files/';
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0755, true);
    }

    // Nombre aleatorio: nunca se usa el nombre original del usuario
    $nombreFoto = bin2hex(random_bytes(16)) . '.' . $extension;
    $destino    = $carpeta . $nombreFoto;

    if (move_uploaded_file($tmp, $destino)) {
        $fotoGuardada = $nombreFoto;
        // La carpeta está bloqueada por .htaccess, por eso mostramos la foto en base64
        $fotoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($destino));
    } else {
        $errores[] = 'No se pudo guardar la fotografía en el servidor.';
    }
}

include 'includes/header.php';
?>

<main class="flex-grow-1 py-4">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger shadow-sm">
                    <h2 class="h5 alert-heading">No se pudo registrar al aspirante</h2>
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="index.php" class="btn btn-secondary">&larr; Volver al formulario</a>

            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">Aspirante registrado correctamente</div>
                    <div class="card-body text-center">
                        <img src="<?php echo $fotoBase64; ?>" alt="Foto del aspirante"
                             class="rounded-circle border mb-3" style="width:150px;height:150px;object-fit:cover;">
                        <table class="table table-striped text-start mb-3">
                            <tr><th>Nombre</th><td><?php echo $nombre; ?></td></tr>
                            <tr><th>Apellido</th><td><?php echo $apellido; ?></td></tr>
                            <tr><th>Identificación</th><td><?php echo $identificacion; ?></td></tr>
                            <tr><th>Fecha de nacimiento</th><td><?php echo htmlspecialchars($fechaNac); ?></td></tr>
                            <tr><th>Edad</th><td><?php echo $edad; ?> años</td></tr>
                            <tr><th>Sexo</th><td><?php echo $sexo; ?></td></tr>
                            <tr><th>Archivo guardado</th><td class="small text-break"><?php echo $fotoGuardada; ?></td></tr>
                        </table>
                        <a href="index.php" class="btn btn-primary">Registrar otro aspirante</a>
                    </div>
                </div>
            <?php endif; ?>

            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
