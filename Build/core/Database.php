<?php

namespace app\core;

/**
 * 
 * Class Database
 *
 * @author Yagya
 * @package app\core
 *  
 * 
 *  */

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        // $dsn = $config['dsn'] ?? '';
        // $user = $config['user'] ?? '';
        // $password = $config['password'] ?? '';

        // $this->pdo = new \PDO($dsn, $user, $password);
        // $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // return $this->pdo;

        // echo "<pre>";
        // // echo $config;
        // var_dump($config);
        // echo "</pre>";
        // exit;

        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        try {
            $this->pdo = new \PDO($dsn, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {

            // echo "<pre>";
            // var_dump($e);
            // echo "</pre>";
            die("Connection failed: " . $e->getMessage());
        }
    }


    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppledMigrations();

        $newMigrations = [];

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {

            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");

            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }


    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE_TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        migration VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
        ENGINE=INNODB; ");
    }


    public function getAppledMigrations()
    {
        $statement =  $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }



    public function saveMigrations(array $migrations)
    {

        $str = implode(",", array_map(fn ($m) => "('$m')", $migrations));

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES
        $str        
        ");

        $statement->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }


    protected function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] -' . $message . PHP_EOL;
    }
}
