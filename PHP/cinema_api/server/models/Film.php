<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/Database.php';

  class Film {
    private mysqli $connection;

    public function __construct() {
      try {
        $this->connection = (new Database)->connect();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["error" => "__construct() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_film($id_regista): ?void {
      $query = "
        SELECT * 
        FROM film
        JOIN film.ID == dirige.film
        JOIN dirige.regista = regista.ID
        WHERE regista.ID = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "i", 
          $id_regista
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_film() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>