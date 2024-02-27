<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace Core;

use Core\Exception\NotFoundException;

/**
 * Router para manejar comandos y rutas.
 *
 * Este router se encarga de asignar callbacks a comandos y resolver la ruta adecuada.
 */
class CommandRouter
{
    /** @var Input Manejador de entrada. */
    private Input $input;

    /** @var array Mapa de comandos y callbacks. */
    private array $commandMap = [];

    /**
     * Constructor de la clase CommandRouter.
     *
     * @param Input $input Objeto Input para manejar la entrada.
     */
    public function __construct(Input $input)
    {
        $this->input = $input;
    }

    /**
     * Agrega un comando y su callback correspondiente al mapa de comandos.
     *
     * @param string $command Nombre del comando.
     * @param mixed $callback Callback asociado al comando.
     * @return void
     */
    public function add(string $command, $callback)
    {
        $this->commandMap[$command] = $callback;
    }

    /**
     * Obtiene el mapa de rutas para un comando dado.
     *
     * @param string $command Nombre del comando.
     * @return array Mapa de rutas asociado al comando.
     */
    public function getRouteMap($command): array
    {
        return $this->commandMap[$command] ?? [];
    }

    /**
     * Obtiene el callback asociado a un comando.
     *
     * @param string $command Nombre del comando.
     * @return mixed Callback asociado al comando.
     */
    public function getCallback($command)
    {
        if(!array_key_exists($command,$this->commandMap)) {
            print("\e[1;37;41m No existe Ruta para este comando \e[0m");
            exit();
        }
        return $this->commandMap[$command][0];
    }

    /**
     * Obtiene la acción asociada a un comando.
     *
     * @param string $command Nombre del comando.
     * @return mixed Acción asociada al comando.
     */
    public function getAction($command)
    {
       
        return $this->commandMap[$command][1];
    }

    /**
     * Resuelve el comando y ejecuta la acción correspondiente.
     *
     * @return mixed Resultado de la acción ejecutada.
     * @throws NotFoundException Si no se encuentra el comando.
     */
    public function resolve()
    {
        $command = $this->input->getCommand();
        $classController = $this->getCallback($command);

        if (!$classController) {
            if ($classController === false) {
                throw new NotFoundException();
            }
        }

        $controller = new $classController;
        $action = $this->getAction($command);

        return call_user_func([$controller, $action], $this->input);
    }

    /**
     * Renderiza una vista con los parámetros dados.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Parámetros para pasar a la vista.
     * @return mixed Resultado de la vista renderizada.
     */
    public function renderView($view, $params = [])
    {
        return App::$app->view->renderView($view, $params);
    }
}
