<?php

namespace Migrations;

use Core\DataBase\Migration;

class m_001_clases extends Migration
{
    public function up()
    {
        $db = \Core\App::$app->db;
        $this->SQL = "CREATE TABLE IF NOT EXISTS clases (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                ponderacion TINYINT UNSIGNED CHECK (ponderacion BETWEEN 1 AND 5),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $db->pdo->exec($this->SQL);
    }

    public function down()
    {
        $db = \Core\App::$app->db;
        $SQL = "DROP TABLE provinces;";
        $db->pdo->exec($this->SQL);
    }
}
