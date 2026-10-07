<?php
// includes/formulario.php - Formulario de registro de aspirantes
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <form action="procesar.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre (Requerido):</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label fw-bold">Apellido (Requerido):</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>

                    <div class="mb-3">
                        <label for="identificacion" class="form-label fw-bold">Identificación (Requerido):</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de Nacimiento (Requerido):</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                               max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <span class="form-label fw-bold d-block">Sexo (Requerido):</span>
                        <div class="btn-group w-100" role="group" aria-label="Sexo">
                            <input type="radio" class="btn-check" name="sexo" id="sexoH" value="Hombre" required>
                            <label class="btn btn-outline-secondary" for="sexoH">Hombre</label>

                            <input type="radio" class="btn-check" name="sexo" id="sexoM" value="Mujer">
                            <label class="btn btn-outline-secondary" for="sexoM">Mujer</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label fw-bold">Fotografía del Aspirante (png, jpg, jpeg, gif):</label>
                        <input type="file" class="form-control" id="foto" name="foto"
                               accept=".png,.jpg,.jpeg,.gif" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrar Aspirante</button>
                </form>

            </div>
        </div>
    </div>
</div>