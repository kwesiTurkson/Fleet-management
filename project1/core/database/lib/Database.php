<?php


class Database

{
    private static Database $instance;

    private string $db_host = DB_HOST;
    private string $db_user = DB_USER;
    private string $db_pass = DB_PASS;
    private string $db_name = DB_NAME;
    private string $charset = DB_CHARSET;

    private PDOStatement $statement;
    private PDO $db_handler;
    private string $error;

    public static function getInstance(): Database
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }


    private function __construct()
    {
        $dsn = "mysql:host=" . $this->db_host . ";charset=$this->charset";
        $options = array(
//            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->db_handler = new PDO($dsn, $this->db_user, $this->db_pass, $options);
            $this->db_handler->exec(statement: sprintf("CREATE DATABASE IF NOT EXISTS %s", $this->db_name));
            $this->db_handler->exec(statement: "USE $this->db_name");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function query(string $sql): void
    {
        $this->statement = $this->db_handler->prepare($sql);
    }

    public function bind(mixed $parameter, mixed $value, mixed $type = null): void
    {
        $type = match (is_null($type)) {
            is_int($value) => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            is_null($value) => PDO::PARAM_NULL,
            default => PDO::PARAM_STR,
        };
        $this->statement->bindValue($parameter, $value, $type);
    }


    public function execute(): void
    {
        $this->statement->execute();
    }


    public function resultSet(): array
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }


    public function getSingle(): mixed
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    public function insert(array $values): bool
    {
        if ($this->statement->execute($values)) {
            return true;
        }
        return false;
    }

    public function rowCount(): int
    {
        $this->execute();
        return $this->statement->rowCount();
    }

}