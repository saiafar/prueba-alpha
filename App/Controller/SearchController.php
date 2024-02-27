<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace App\Controller;

use Core\Controller;

use App\Models\Clase;
use App\Models\Examen;

class SearchController extends Controller
{

    /**
     * Realiza una búsqueda de clases y exámenes según una palabra de entrada.
     *
     * @param object $input Objeto que contiene la entrada de la consola.
     * @return string Vista que muestra los resultados de la búsqueda.
     */
    public function search($input)
    {
        // Obtener la palabra de búsqueda
        $word = $input->getArg(0);

        if(strlen($word) < 3){
            print("\e[1;37;41m Debe indicar al menos 3 letras para realizar la busqueda \e[0m");
            exit();
        }

        $find = substr($word, 0, 3);

        // Buscar clases que coincidan con la palabra de búsqueda
        // Usamos una  expresion regular para buscar en las palabras de la oracion y no solo en la primera palabra
        $clases =  Clase::where("nombre", "REGEXP", "[[:<:]]$find")->get();

        // Buscar exámenes que coincidan con la palabra de búsqueda y cargar las relaciones de tipoExamen
        $examenes =  Examen::where("nombre", "REGEXP", "[[:<:]]$find")->with("TipoExamen")->get();

        // Renderizar la vista de resultados de búsqueda y pasar los resultados como parámetros
        return $this->render("SearchResults", ["clases" => $clases, "examenes" => $examenes]);
    }

}

?>
