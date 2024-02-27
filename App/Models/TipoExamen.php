<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace App\Models;

use Core\DataBase\Model;
use Core\DataBase\TableName;

class TipoExamen extends Model implements TableName
{

    protected array $fills = ["id", "descripcion"];

    public static function tableName(): string
    {
        return 'tipoExamenes';
    }
}

?>