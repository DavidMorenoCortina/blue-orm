<?php

namespace DavidMorenoCortina\ORM\Command;


use DavidMorenoCortina\ORM\Migration\BaseMigration;

class MigrateDownCommand extends BaseCommand {

    public function execute() {
        $dir = BLUEORM_ROOT . 'migrations/';

        $done = false;
        $files = scandir($dir, SCANDIR_SORT_DESCENDING);
        foreach($files as $file){
            if(strcmp('.', $file) !== 0 && strcmp('..', $file) !== 0){
                require ($dir . $file);

                $className = str_replace('.php', '', $file);
                /** @var BaseMigration $migration */
                $migration = new $className($this->connection);

                $this->connection->beginTransaction();
                if($migration->isExecuted()) {
                    $migration->tearDown();
                    $migration->wasDownExecuted();
                    $done = true;
                }
                $this->connection->commit();

                if($done){
                    break;
                }
            }
        }
    }
}