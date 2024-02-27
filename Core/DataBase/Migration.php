<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace Core\DataBase;

/**
 * Clase abstracta base para las migraciones de la base de datos.
 */
abstract class Migration{

    /** @var string Sentencia SQL de la migración. */
    protected string $SQL;

    /**
     * Método abstracto para aplicar la migración.
     *
     * Este método debe ser implementado por las clases hijas para aplicar la migración.
     *
     * @return void
     */
    abstract public function Up();

    /**
     * Método abstracto para revertir la migración.
     *
     * Este método debe ser implementado por las clases hijas para revertir la migración.
     *
     * @return void
     */
    abstract public function Down();
}
