<?php
/**
 * Función de autocarga para cargar clases automáticamente basada en el nombre de clase proporcionado.
 *
 * @param string $class El nombre de clase completamente cualificado que se va a cargar.
 * @return void
 */
function autoload($class)
{
    // Convertir los separadores de namespace en separadores de directorio y añadir la extensión de archivo PHP
    $file = str_replace('\\', '/', $class) . '.php';

    // Verificar si el archivo existe
    if (file_exists($file)) {
        // Requerir el archivo si existe
        require $file;
        return;
    }
}

// Registrar la función de autocarga con la función spl_autoload_register
spl_autoload_register('autoload');
