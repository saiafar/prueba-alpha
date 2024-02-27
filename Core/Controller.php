<?php
/* 
*
*   @autor Rafaias Villan
*
*/

namespace Core;

/**
 * Clase base para los controladores de la aplicación.
 *
 * Esta clase proporciona funcionalidades comunes para todos los controladores.
 */
class Controller
{
    /** @var string Nombre de la acción por defecto. */
    public string $action = '';

    /**
     * Renderiza una vista con los parámetros dados.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Parámetros para pasar a la vista.
     * @return string Resultado de la vista renderizada.
     */
    public function render($view, $params = []): string
    {
        return App::$app->view->renderView($view, $params);
    }
}
