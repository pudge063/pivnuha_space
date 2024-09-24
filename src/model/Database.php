<?php

class Database
{
    private $dbModel;

    private $db_host;
    private $db_user;
    private $db_password;
    private $db_name;

    public $conn;

    public function __construct()
    {
        $this->db_host = getenv("DB_HOST");
        $this->db_user = getenv("MYSQL_USER");
        $this->db_password = getenv("MYSQL_PASSWORD");
        $this->db_name = getenv("db_test");

        $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}
