<?php
  declare(strict_types = 1);

  class Database {
    private const HOST = 'localhost';
    private const USER = 'root';
    private const PASSWORD = '';
    private const DB = 'cinema';

    private mysqli $connection;

    public function __construct() {
      try {
        $this->connection = new mysqli(self::HOST, self::USER, self::PASSWORD, self::DB);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "__construct() Fallita: " . $error->getMessage()]));
      }
    }

    public function connect() {
      return $this->connection;
    }
  }
?>