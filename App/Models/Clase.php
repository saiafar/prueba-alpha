<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace App\Models;

use Core\DataBase\Model;
use Core\DataBase\TableName;

class Clase extends Model implements TableName
{
    protected array $fills = ["id", "nombre", "ponderacion"];

    public static function tableName(): string
    {
        return 'clases';
    }
}

?>