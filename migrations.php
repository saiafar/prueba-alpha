<?php
/**
 * @autor Rafaias Villan
 */

require_once "autoload.php";


use Core\App;
use App\Models\Clase;
use App\Models\Examen;
use App\Models\TipoExamen;

$app = new App(__DIR__, array());

$app->db->runMigrations();
if(count($argv)){
    if($argv[1] == '-create'){
        

        Clase::create(["'Vocabulario sobre Trabajo en Inglés'", 4]);
        Clase::create(["'Organizacion de documentos'", 4]);
        Clase::create(["'Introduccion al desarrollo web'", 5]);
        Clase::create(["'Desarrollo de aplicaciones avanzadas'", 5]);
        Clase::create(["'Como la unidad del equipo es importante'", 4]);
        Clase::create(["'Colores primemarios'", 4]);
        Clase::create(["'Desarrollo y Diseño'", 5]);
        Clase::create(["'Como hacer pruebas'", 5]);


        TipoExamen::create(["'selección'"]);
        TipoExamen::create(["'pregunta y respuesta'"]);
        TipoExamen::create(["'completación'"]);

        Examen::create(["'Trabajos y ocupaciones en Inglés'", 1]);
        Examen::create(["'Documentacion de codigo'", 3]);
        Examen::create(["'Desarrollo Web con PHP'", 2]);
        Examen::create(["'Logica de Programacion basica'", 3]);
        Examen::create(["'Pruebas Unitarias en proyectos'", 2]);
        Examen::create(["'Unidades de medicion'", 1]);
        Examen::create(["'Contabilidad aplicada al desarrollo'", 2]);
        Examen::create(["'Desarrollo de aplicaciones avanzadas'", 3]);


    }
}
