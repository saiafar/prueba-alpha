<?php
/* 
*
*   @autor Rafaias Villan
*
*/

namespace Core;

/**
 * Clase para manejar la representación de vistas.
 */
class View
{
    /**
     * Renderiza una vista con los parámetros proporcionados.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Parámetros para pasar a la vista.
     * @return string El contenido de la vista renderizada.
     */
    public function renderView($view, array $params)
    {
        // Extrae los parámetros y los convierte en variables locales
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        // Inicia el almacenamiento en el búfer de salida
        ob_start();
        
        // Incluye la vista y captura su salida en el búfer de salida
        include_once App::$ROOT_DIR."/App/views/$view.php";
        
        // Obtiene y limpia el contenido del búfer de salida y lo devuelve
        return ob_get_clean();
    }
}
