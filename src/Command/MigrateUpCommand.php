<?php

namespace DavidMorenoCortina\ORM\Command;


use DavidMorenoCortina\ORM\Migration\BaseMigration;

class MigrateUpCommand extends BaseCommand {
    public function execute() {
        $dir = BLUEORM_ROOT . 'migrations/';

        $files = scandir($dir);
        foreach($files as $file){
            if(strcmp('.', $file) !== 0 && strcmp('..', $file) !== 0){
                require ($dir . $file);

                $className = str_replace('.php', '', $file);
                /** @var BaseMigration $migration */
                $migration = new $className($this->connection);

                $this->connection->beginTransaction();
                if(!$migration->isExecuted()) {
                    $migration->setUp();
                    $migration->wasExecuted();
                }
                $this->connection->commit();
            }
        }
    }
}