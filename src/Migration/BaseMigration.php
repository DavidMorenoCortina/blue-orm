<?php

namespace DavidMorenoCortina\ORM\Migration;


use Exception;
use PDO;

abstract class BaseMigration {
    /**
     * @var PDO
     */
    protected $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public abstract function getVersionName() :string ;

    public abstract function setUp() :void;

    public abstract function tearDown() :void ;

    public function isExecuted(){
        try {
            $stmt = $this->connection->prepare('SELECT * FROM migration WHERE version = :version');
            $stmt->execute([
                ':version' => $this->getVersionName()
            ]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        }catch (Exception $e){
            $data = null;
        }

        return !empty($data);
    }

    public function wasExecuted() {
        $stmt = $this->connection->prepare('INSERT INTO migration (version) VALUES (:version)');
        $stmt->execute([
            ':version' => $this->getVersionName()
        ]);
        $stmt->closeCursor();
    }

    public function wasDownExecuted() {
        $stmt = $this->connection->prepare('DELETE FROM migration WHERE version = :version LIMIT 1');
        $stmt->execute([
            ':version' => $this->getVersionName()
        ]);
        $stmt->closeCursor();
    }
}