<?php

namespace DavidMorenoCortina\ORM\Command;


use PDO;

class MigrateLastMigrationCommand extends BaseCommand {

    public function execute() {
        $stmt = $this->connection->prepare('SELECT * FROM migration ORDER BY version DESC LIMIT 1');
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if(empty($data)){
            echo '' . self::EOL;
        }else{
            echo $data['version'] . self::EOL;
        }
    }
}