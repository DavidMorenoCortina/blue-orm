<?php

namespace Functional;


use PHPUnit\Framework\TestCase;

class MigrationTest extends TestCase {
    public function testMigration() {
        $command = 'php ' . __DIR__ . '/../../blueorm.php ';
        $migrationDir = __DIR__ . '/../../migrations/';

        if(!is_dir($migrationDir)){
            mkdir($migrationDir);
        }

        exec($command);

        $files = scandir($migrationDir);
        $this->assertCount(2, $files);

        exec($command . 'migrate:create');

        $files = scandir($migrationDir);

        foreach($files as $file){
            if(strcmp('.', $file) !== 0 && strcmp('..', $file) !== 0){
                $migration = file_get_contents($migrationDir . $file);
                $migration = str_replace('public function setUp() :void {', 'public function setUp() :void { (new \DavidMorenoCortina\ORM\Config\ConfigDatabase())->setUp($this->connection);', $migration);
                $migration = str_replace('public function tearDown() :void {', 'public function tearDown() :void { (new \DavidMorenoCortina\ORM\Config\ConfigDatabase())->tearDown($this->connection);', $migration);
                file_put_contents($migrationDir . $file, $migration);
            }
        }

        exec($command . 'migrate:up');

        $responseUp = [];
        exec($command . 'migrate:last-migration', $responseUp);

        $responseDown = [];
        exec($command . 'migrate:down', $responseDown);

        foreach($files as $file){
            if(strcmp('.', $file) !== 0 && strcmp('..', $file) !== 0){
                unlink($migrationDir . $file);
            }
        }

        $this->assertNotEmpty($responseUp[0]);

        $this->assertEmpty($responseDown);

        $this->assertCount(3, $files);

        $files = scandir($migrationDir);

        $this->assertCount(2, $files);
    }
}