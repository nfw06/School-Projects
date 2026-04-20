<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/Database.php';

  class Regista {
    private mysqli $connection;

    public function __construct() {
      try {
        $this->connection = (new Database)->connect();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "__construct() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_regista(string $cognome, string $nome): ?array{
      $query = "
        SELECT *
        FROM regista
        WHERE cognome = ? AND nome = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_regista() Fallita: " . $error->getMessage()]));
      }
    }

    public function create(string $cognome, string $nome): void {
      $query = "
        INSERT INTO regista (cognomeNome, cognome, nome)
        VALUES (?, ?, ?)
      ";
      try {
        $cognomeNome = ucfirst($cognome) . " " . ucfirst($nome);
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "sss",
          $cognomeNome, $cognome, $nome
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita" . $error->getMessage()]));
      }
    }

    public function update($id, $cognome, $nome): void {
      $query = "
        UPDATE regista
        SET cognomeNome = ?, cognome = ?, nome = ?
        WHERE ID = ?
      ";
      try {
        $cognomeNome = ucfirst($cognome) . " " . ucfirst($nome);
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "iss",
          $cognomeNome, $cognome, $nome, $id
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita: "] . $error->getMessage()));
      }
    }

    public function delete($id): void {
      $query = "
        DELETE FROM artisti
        WHERE ID = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "i",
          $id  
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "delete() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>