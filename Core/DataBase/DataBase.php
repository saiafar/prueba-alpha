<?php
/* 
*
*   @autor Rafaias Villan
*
*/
namespace Core\DataBase;

use Core\App;

/**
 * Clase para interactuar con la base de datos.
 */
class Database
{
    /** @var \PDO Objeto PDO para la conexión a la base de datos. */
    public \PDO $pdo;

    /**
     * Constructor de la clase Database.
     *
     * Establece la conexión a la base de datos utilizando las credenciales del entorno.
     */
    public function __construct()
    {
        $dbdns = $_ENV['DB_DNS'] ?? '';
        $username = $_ENV['DB_USER'] ?? '';
        $password = $_ENV['DB_PASS'] ?? '';

        $this->pdo = new \PDO($dbdns, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Ejecuta las migraciones de la base de datos.
     *
     * Lee los archivos de migración disponibles y ejecuta las migraciones que no han sido aplicadas.
     */
    public function runMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(App::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once App::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $className = 'Migrations\\'.$className;
            $instance = new $className();
            $this->log("Ejecutando Migracion $migration");
            $instance->up();
            $this->log("Migracion Ejecutada $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("No hay Migraciones para ejecutar");
        }
    }

    /**
     * Crea la tabla de migraciones si no existe.
     */
    protected function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    /**
     * Obtiene las migraciones que han sido aplicadas.
     *
     * @return array Las migraciones que han sido aplicadas.
     */
    protected function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Guarda las migraciones que han sido aplicadas.
     *
     * @param array $newMigrations Las nuevas migraciones que han sido aplicadas.
     */
    protected function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }

    /**
     * Prepara una sentencia SQL para su ejecución.
     *
     * @param string $sql La sentencia SQL a preparar.
     * @return \PDOStatement La sentencia preparada.
     */
    public function prepare($sql): \PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Registra un mensaje de log con la marca de tiempo.
     *
     * @param string $message El mensaje a registrar.
     */
    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}
