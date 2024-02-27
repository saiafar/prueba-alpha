<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace Core;

/**
 * Clase para manejar la entrada de comandos.
 *
 * Esta clase proporciona métodos para acceder a los parámetros de la línea de comandos.
 */
class Input{

    /** @var array Argumentos de la línea de comandos. */
    protected array $line_args = [];

    /**
     * Constructor de la clase Input.
     *
     * @param array $args Argumentos de la línea de comandos.
     */
    public function __construct($args)
    {   
        $this->line_args = $args;
    }

    /**
     * Obtiene el comando de la línea de comandos.
     *
     * @return string El comando.
     */
    public function getCommand()
    {
        $command = $this->line_args[1];
        return $command;
    }

    /**
     * Obtiene los argumentos del comando de la línea de comandos.
     *
     * @return array Los argumentos del comando.
     */
    public function getArguments()
    {
         $args_command = array_slice($this->line_args, 2);
         return $args_command;
    }

    /**
     * Obtiene el argumento en el índice dado.
     *
     * @param int $index El índice del argumento.
     * @return mixed El argumento en el índice dado.
     */
    public function getArg($index)
    {
        if(!array_key_exists($index+2,$this->line_args)) {
            return "";
        }
        return $this->line_args[$index+2];
    }
}
