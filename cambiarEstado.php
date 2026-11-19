<?php

/**
 * Script encargado de alternar el estado de disponibilidad de un libro.
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
 * Alterna el estado de disponibilidad de un libro entre 1 (disponible) y 0 (prestado).
 *
 * @param mysqli $conexion       Conexión activa a la base de datos.
 * @param int    $id             Identificador del libro.
 * @param int    $estado_actual  Estado actual del libro (1 o 0).
 * @return bool True si la actualización fue exitosa, false en caso contrario.
 */
function alternarEstadoLibro(mysqli $conexion, int $id, int $estado_actual): bool
{
    $nuevo_estado = ($estado_actual === 1) ? 0 : 1;
    $sql = "UPDATE libros SET disponible = $nuevo_estado WHERE id = $id";

    return $conexion->query($sql) === TRUE;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['actual'])) {
    $host = "fdb1029.awardspace.net"; // Reemplaza XX por el número de tu servidor
    $servidor = "fdb1029.awardspace.net";
    $usuario = "4794860_pruebadb";
    $password = "74san74ti";
    $base_datos = "4794860_pruebadb";

    $conexion = conectarBaseDatos($host, $usuario, $password, $base_datos);
    $id = intval($_POST['id']);
    $estado_actual = intval($_POST['actual']);

    if (alternarEstadoLibro($conexion, $id, $estado_actual)) {
        $conexion->close();
        header("Location: index.php?updated=1");
        exit();
    } else {
        echo "Error al actualizar el estado: " . $conexion->error;
        $conexion->close();
    }
} else {
    header("Location: index.php");
    exit();
}