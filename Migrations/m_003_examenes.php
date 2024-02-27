<?php

namespace Migrations;

use Core\DataBase\Migration;

class m_003_examenes extends Migration
{
    public function up()
    {
        $db = \Core\App::$app->db;
        $this->SQL = "CREATE TABLE IF NOT EXISTS examenes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                tipoExamen_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (tipoExamen_id)
                REFERENCES tipoExamenes (id)
            )  ENGINE=INNODB;";
        $db->pdo->exec($this->SQL);
    }

    public function down()
    {
        $db = \Core\App::$app->db;
        $SQL = "DROP TABLE examenes;";
        $db->pdo->exec($this->SQL);
    }
}
