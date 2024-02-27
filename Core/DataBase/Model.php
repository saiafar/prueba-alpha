<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace Core\DataBase;

use Core\App;

/**
 * Clase abstracta base para los modelos de la base de datos.
 */
abstract class Model
{
    /** @var string Nombre de la clave primaria por defecto. */
    protected string $primary = "id";

    /** @var string Nombre de la tabla asociada al modelo. */
    protected string $table_name = "";

    /** @var array Errores del modelo. */
    public array $errors = [];

    /** @var array Relaciones que tiene el modelo. */
    public array $relationsHave = [];

    /** @var array Columnas a seleccionar en las consultas. */
    private array $select = [];

    /** @var array Relaciones para cargar con la consulta. */
    protected array $with = [];

    /** @var array Condiciones WHERE para la consulta. */
    protected array $where = [];

    /** @var array Columnas que se pueden llenar con datos. */
    protected array $fills = [];

    /**
     * Devuelve el nombre de la tabla asociada al modelo.
     *
     * @return string Nombre de la tabla asociada al modelo.
     */
    public abstract static function tableName(): string;

    /**
     * Devuelve una instancia única del modelo.
     *
     * @return Model Instancia única del modelo.
     */
    public static function getInstance(): Model
    {
        if (!isset($instance)) {
            $instance = new static();
        }
        return $instance;
    }

    /**
     * Agrega una condición WHERE a la consulta.
     *
     * @param string $col Columna a comparar.
     * @param string $operator Operador de comparación.
     * @param mixed $value Valor a comparar.
     * @return Model Instancia del modelo con la condición WHERE agregada.
     */
    public static function where($col, $operator, $value)
    {
        $instance = static::getInstance();
        $instance->where[] = "$col $operator " . (is_string($value) ? "'$value'" : $value);
        return $instance;
    }

    /**
     * Agrega una relación para cargar con la consulta.
     *
     * @param string $scope Nombre del método de relación.
     * @return Model Instancia del modelo con la relación agregada.
     */
    public function with($scope)
    {
        $this->$scope();
        return $this;
    }

    /**
     * Agrega columnas seleccionadas a la consulta.
     *
     * @param string $tableName Nombre de la tabla.
     * @param array $fills Columnas a seleccionar.
     * @return void
     */
    protected function addSelect($tableName, $fills)
    {
        foreach ($fills as $fill) {
            array_push($this->select, $tableName . "." . $fill);
        }
    }

    /**
     * Construye la parte JOIN de la consulta.
     *
     * @return string Parte JOIN de la consulta.
     */
    protected function buildJoin()
    {
        $sql = " ";
        foreach ($this->relationsHave as $model => $reldet) {
            $class = new $model();
            $tableName = $class::tableName();
            $sql .= $reldet[1] . " JOIN ";
            $sql .= $tableName;
            $sql .= " ON (" . $tableName . "." . $this->primary . " = " . static::tableName() . "." . $reldet[0] . ") ";
            $this->addSelect($tableName, $reldet[2]);
        }
        return $sql;
    }

    /**
     * Realiza la consulta y devuelve una colección de modelos.
     *
     * @return array Colección de modelos.
     */
    public function get()
    {
        $tableName = static::tableName();
        $this->addSelect($tableName, $this->fills);
        $sql = " FROM $tableName";

        $sql .= $this->buildJoin();
        if (!empty($this->where)) {
            $sql .= " WHERE ";
            foreach ($this->where as $where) {
                $sql .= $where;
            }
        }

        $sql = "SELECT " . implode(", ", $this->select) . $sql;
        $statement = self::prepare($sql);
        $statement->execute();
        $resulset = $statement->fetchAll();

        $collection = [];
        foreach ($resulset as $result) {
            $model = new static();
            // Asignar propiedades al modelo basado en los resultados de la consulta
            foreach ($result as $key => $value) {
                $model->$key = $value;
            }
            $collection[] = $model;
        }
        return $collection;
    }

    /**
     * Guarda el modelo en la base de datos.
     *
     * @return void
     */
    public static function create($values)
    {
        $instance = static::getInstance();
        $tableName = static::tableName();
        array_shift($instance->fills);
        $sql = " INSERT INTO ".$tableName." (".implode(",", $instance->fills).") VALUES (".implode(",", $values).")";
        print($sql."\n");
        $statement = self::prepare($sql);
        $statement->execute();
    }

    /**
     * Prepara una sentencia SQL para su ejecución.
     *
     * @param string $sql La sentencia SQL a preparar.
     * @return \PDOStatement La sentencia preparada.
     */
    public static function prepare($sql): \PDOStatement
    {
        return App::$app->db->prepare($sql);
    }

    /**
     * Encuentra un modelo por su ID.
     *
     * @param mixed $id El ID del modelo.
     * @return mixed El modelo encontrado.
     */
    public function findOne($id)
    {
        //TODO
    }

    /**
     * Establece una relación de pertenencia entre modelos.
     *
     * @param string $model Modelo con el que se establece la relación.
     * @param string $foreing_key Clave foránea para la relación.
     * @param string $type_join Tipo de JOIN para la relación.
     * @param array $fills Columnas a llenar con datos para la relación.
     * @return void
     */
    public function haveRelation($model, $foreing_key, $type_join = "", $fills = [])
    {
        $this->relationsHave[$model] = [$foreing_key, $type_join, $fills];
    }
}
