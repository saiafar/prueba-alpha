<?php
/* 
*
*   @autor Rafaias Villan
*
*/
error_reporting(E_ALL & ~E_DEPRECATED);

require "autoload.php";

use Core\App;
use App\Controller\SearchController;

// Crear una instancia de la aplicación
$app = new App(__DIR__, $argv);

// Agregar una ruta para el comando 'search' que apunta al método 'search' del controlador de búsqueda
$app->router->add('search', [SearchController::class, 'search']);

$app->run();
