<?php
/**
 * Clase principal de la aplicación.
 *
 * @autor Rafaias Villan
 */
namespace Core;

use Core\DataBase\Database;

class App
{
    /**
     * Directorio raíz de la aplicación.
     */
    public static string $ROOT_DIR;

    /**
     * Ruta del archivo de configuración de entorno.
     */
    protected string $PATH_ENV = ".env";

    /**
     * Enrutador de comandos.
     */
    public CommandRouter $router;

    /**
     * Manejador de entrada.
     */
    public Input $input;

    /**
     * Instancia de la base de datos.
     */
    public Database $db;

    /**
     * Motor de plantillas de vistas.
     */
    public View $view;

    /**
     * Instancia única de la aplicación.
     */
    public static App $app;

    /**
     * Constructor de la clase App.
     *
     * @param string $rootPath Ruta raíz de la aplicación.
     * @param array $args Argumentos de la línea de comandos.
     */
    public function __construct($rootPath, $args)
    {
        $this->LoadEnv();
        self::$ROOT_DIR = $rootPath;
        $this->input = new Input($args);
        $this->router = new CommandRouter($this->input);
        $this->db = new Database();
        $this->view = new View();
        self::$app = $this;
    }

    /**
     * Ejecuta la aplicación.
     */
    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * Carga las variables de entorno desde el archivo .env.
     *
     * @throws \InvalidArgumentException Si el archivo .env no existe.
     * @throws \RuntimeException Si el archivo .env no puede ser leído.
     */
    public function LoadEnv()
    {
        if (!file_exists($this->PATH_ENV)) {
            throw new \InvalidArgumentException(sprintf('%s No Existe', $this->PATH_ENV));
        }

        if (!is_readable($this->PATH_ENV)) {
            throw new \RuntimeException(sprintf('%s El archivo no puede ser leido', $this->PATH_ENV));
        }

        $lines = file($this->PATH_ENV, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
