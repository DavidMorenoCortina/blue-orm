<?php

namespace DavidMorenoCortina\ORM\CommandLineUI;


use DavidMorenoCortina\ORM\Command\BaseCommand;
use DavidMorenoCortina\ORM\Command\MigrateCreateCommand;
use DavidMorenoCortina\ORM\Command\MigrateDownCommand;
use DavidMorenoCortina\ORM\Command\MigrateLastMigrationCommand;
use DavidMorenoCortina\ORM\Command\MigrateUpCommand;
use DavidMorenoCortina\ORM\Command\UnknownCommand;
use PDO;

class CommandLine {
    /**
     * @param array $argv
     * @param PDO $connection
     */
    public function run(array $argv, PDO $connection) :void {
        if(count($argv) === 1){
            $this->showHelp();
        }else{
            switch(mb_strtolower($argv[1])){
                case 'migrate:create':
                    $command = new MigrateCreateCommand($argv, $connection);
                    break;
                case 'migrate:up':
                    $command = new MigrateUpCommand($argv, $connection);
                    break;
                case 'migrate:down':
                    $command = new MigrateDownCommand($argv, $connection);
                    break;
                case 'migrate:last-migration':
                    $command = new MigrateLastMigrationCommand($argv, $connection);
                    break;
                default:
                    $command = new UnknownCommand($argv, $connection);
            }

            $command->execute();
        }
    }

    private function showHelp() {
        $commands = [
            'migrate:create',
            'migrate:up',
            'migrate:down'
        ];

        $msg = 'Available commands' . BaseCommand::EOL;
        foreach($commands as $command){
            $msg .= '- ' . $command . BaseCommand::EOL;
        }

        echo $msg;
    }
}