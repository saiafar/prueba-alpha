<?php

namespace Migrations;

use Core\DataBase\Migration;

class m_002_tipoExamenes extends Migration
{
    public function up()
    {
        $db = \Core\App::$app->db;
        $this->SQL = "CREATE TABLE IF NOT EXISTS tipoExamenes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                descripcion VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $db->pdo->exec($this->SQL);
    }

    public function down()
    {
        $db = \Core\App::$app->db;
        $SQL = "DROP TABLE tipoExamenes;";
        $db->pdo->exec($this->SQL);
    }
}
