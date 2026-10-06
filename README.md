
**Universidad Tecnológica de Panamá**
**Facultad de Sistemas Computacionales**
**licenciatura en Ciberseguridad**
**Estudiante:** Hanna Licona
**Grupo:** 1S3122
**Profesora:** Ing. Irina Fong
**Fecha de entrega:** 2 de octubre de 2026

# Laboratorio #3: Sistema de Registro de Aspirantes

Formulario web de registro de aspirantes desarrollado en **PHP** y **Bootstrap 5**, con menú, migas de pan y pie de página modulares mediante `include`.
## Características

- Formulario con nombre, apellido, identificación, fecha de nacimiento, sexo y fotografía.
- Etiquetas semánticas de HTML5: `<header>`, `<main>`, `<section>` y `<footer>`.
- Navbar y breadcrumb dinámico: las migas de pan cambian según la página (`basename($_SERVER['PHP_SELF'])`).
- Archivos modulares con `include`: `header.php` y `footer.php`.
- Año del pie de página generado con `date('Y')`.
- Interfaz responsiva con Bootstrap 5.3.8.

## Validaciones (backend)

- Todos los campos obligatorios deben venir llenos.
- La edad se calcula a partir de la fecha de nacimiento y debe estar **entre 18 y 70 años**.
- Nombre y apellido se guardan en **formato título** (por ejemplo, `mARÍA lópez` pasa a `María López`).
- La foto debe ser PNG, JPG, JPEG o GIF, comprobada por extensión, tipo real del archivo e imagen válida, con un máximo de 2 MB.
- Los textos se limpian con `trim`, `strip_tags` y `htmlspecialchars` para evitar XSS.

## Seguridad

- Las fotos se guardan en `uploaded_files/` con un **nombre aleatorio**, nunca con el nombre original.
- `uploaded_files/.htaccess` bloquea el acceso directo desde el navegador (403 Forbidden) y desactiva la ejecución de PHP en esa carpeta.
- `header.php` y `footer.php` no se pueden abrir directamente por URL: solo funcionan si la página que los incluye define la constante `APP_RUNNING`.
- Las fotos subidas no se versionan en Git (ver `.gitignore`).

## Estructura del proyecto

```
laboratorio3/
├── includes/
│   ├── header.php      # Metadatos, navbar y breadcrumb dinámico
│   └── footer.php      # Pie de página con enlaces y año dinámico
├── uploaded_files/
│   ├── .htaccess       # Bloquea el acceso directo a las fotos
│   └── .gitkeep        # Mantiene la carpeta en Git
├── .gitignore
├── index.php           # Formulario de registro
├── procesar.php        # Validación, procesamiento y resultado
└── README.md
```

## Requisitos

- PHP 8.0 o superior, con las extensiones `fileinfo` y `mbstring` activas.
- Servidor Apache con `mod_rewrite` y `AllowOverride All` (por ejemplo, WAMP).
- Conexión a internet, para cargar Bootstrap desde el CDN.

## Cómo ejecutarlo

1. Copia la carpeta del proyecto en `C:\wamp64\www\`.
2. Enciende WAMP y espera a que el icono esté en verde.
3. Abre en el navegador: `http://localhost/laboratorio3/`

## Probar la protección de la carpeta de fotos

1. Registra un aspirante con una foto.
2. Intenta abrir `http://localhost/laboratorio3/uploaded_files/<nombre-de-la-foto>.jpg`.
3. Debe aparecer **403 Forbidden**.

## Tecnologías

PHP 
· HTML5 
· Bootstrap 5.3.8 
· Apache (WAMP) 
· Git y GitHub