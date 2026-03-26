<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/Database.php';

  class Museo {
    private mysqli $connection;

    public function __construct() {
      try {
        $this->connection = (new Database())->connect();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "__construct() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_all(): array {
      $query = "
        SELECT MM_CodiceMuseo, MM_Nome, MM_Citta
        FROM musei
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_all() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_id(string $id): ?array {
      $query = "
        SELECT MM_Nome, MM_Citta
        FROM musei
        WHERE MM_CodiceMuseo = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "s",
          $id
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_by_id() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>