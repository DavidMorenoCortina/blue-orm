<?php

namespace DavidMorenoCortina\ORM\Repository;


use PDO;

abstract class BaseRepository {
    /**
     * @var PDO
     */
    protected $connection;

    /**
     * BaseModel constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }
}