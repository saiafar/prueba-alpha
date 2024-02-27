<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace App\Models;

use Core\DataBase\Model;
use Core\DataBase\TableName;

class Examen extends Model implements TableName
{
    protected array $fills = ["id", "nombre", "tipoExamen_id"];

    public static function tableName(): string
    {
        return 'examenes';
    }

    public function TipoExamen()
    {
        $this->haveRelation('App\Models\TipoExamen', 'tipoExamen_id', "INNER", ["descripcion"]);
    }
}

?>