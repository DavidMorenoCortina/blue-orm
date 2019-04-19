<?php

namespace DavidMorenoCortina\ORM\Config;


use PDO;

class ConfigDatabase {
    /**
     * @param PDO $connection
     */
    public function setUp(PDO $connection) :void {
        $stmt = $connection->prepare('
CREATE TABLE IF NOT EXISTS `migration` (
	`version` VARCHAR(255) NOT NULL
)
COLLATE=\'utf8_general_ci\'
ENGINE=InnoDB
;
        ');
        $stmt->execute();
        $stmt->closeCursor();
    }
    /**
     * @param PDO $connection
     */
    public function tearDown(PDO $connection) :void {
        $stmt = $connection->prepare('DROP TABLE `migration`');
        $stmt->execute();
        $stmt->closeCursor();
    }
}