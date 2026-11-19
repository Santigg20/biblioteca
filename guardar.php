<?php

/**
 * Script encargado de registrar un nuevo libro en la base de datos.
 *
 * @package ControlBiblioteca
 */

/**
 * Conecta a la base de datos MySQL y devuelve la instancia de conexión.
 *
 * @param string $host       Nombre o dirección del servidor de base de datos.
 * @param string $usuario    Usuario de la base de datos.
 * @param string $password   Contraseña del usuario.
 * @param string $base_datos Nombre de la base de datos.
 * @return mysqli Instancia activa de conexión a MySQL.
 */
function conectarBaseDatos(string $host, string $usuario, string $password, string $base_datos): mysqli
{
    $conexion = new mysqli($host, $usuario, $password, $base_datos);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    return $conexion;
}

/**
 * Inserta un nuevo libro en la tabla `libros` escapando los campos recibidos.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @param string $titulo   Título del libro.
 * @param string $autor    Nombre del autor.
 * @param string $isbn     Código ISBN del libro.
 * @return bool True si el registro se guardó correctamente, false en caso contrario.
 */
function guardarLibro(mysqli $conexion, string $titulo, string $autor, string $isbn): bool
{
    // Limpiar variables para evitar inyecciones SQL básicas
    $titulo_limpio = $conexion->real_escape_string($titulo);
    $autor_limpio = $conexion->real_escape_string($autor);
    $isbn_limpio = $conexion->real_escape_string($isbn);

    $sql = "INSERT INTO libros (titulo, autor, isbn) VALUES ('$titulo_limpio', '$autor_limpio', '$isbn_limpio')";

    return $conexion->query($sql) === TRUE;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "fdb1029.awardspace.net"; // Reemplaza XX por el número de tu servidor
    $servidor = "fdb1029.awardspace.net";
    $usuario = "4794860_pruebadb";
    $password = "74san74ti";
    $base_datos = "4794860_pruebadb";

    $conexion = conectarBaseDatos($host, $usuario, $password, $base_datos);

    if (guardarLibro($conexion, $_POST['titulo'], $_POST['autor'], $_POST['isbn'])) {
        $conexion->close();
        // Redireccionar de vuelta a la página principal si se guardó con éxito
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "Error al guardar el libro: " . $conexion->error;
        $conexion->close();
    }
}

ya quedo santi
