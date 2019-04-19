<?php

namespace DavidMorenoCortina\ORM\Command;


use PDO;

abstract class BaseCommand {
    const EOL = "\r\n";

    /**
     * @var array $argv
     */
    protected $argv;

    /**
     * @var PDO
     */
    protected $connection;

    /**
     * Command constructor.
     * @param array $argv
     * @param PDO $connection
     */
    public function __construct(array $argv, PDO $connection) {
        $this->argv = $argv;
        $this->connection = $connection;
    }

    public abstract function execute();
}