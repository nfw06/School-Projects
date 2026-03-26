<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/Database.php';

  class Artista {
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
        SELECT AR_CodiceArtista, AR_Nome, AR_Alias, AR_DataNascita, AR_DataMorte
        FROM artisti
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
        SELECT AR_CodiceArtista, AR_Nome, AR_Alias, AR_DataNascita, AR_DataMorte
        FROM artisti
        WHERE AR_CodiceArtista = ?
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

    public function create(string $id, string $nome, string $alias, int $data_nascita, int $data_morte): void {
      $query = "
        INSERT INTO artisti (AR_CodiceArtista, AR_Nome, AR_Alias, AR_DataNascita, AR_DataMorte)
        VALUES (?, ?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
        "sssii",
        $id,
        $nome,
        $alias,
        $data_nascita,
        $data_morte
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita: " . $error->getMessage()]));
      }
    }

    public function update(string $id, string $nome, string $alias, int $data_nascita, int $data_morte): void {
      $query = "
        UPDATE artisti
        SET AR_Nome = ?, AR_Alias = ?, AR_DataNascita = ?, AR_DataMorte = ?
        WHERE AR_CodiceArtista = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
        "ssiis",
        $nome,
        $alias,
        $data_nascita,
        $data_morte,
        $id
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita: " . $error->getMessage()]));
      }
    }

    public function delete(string $id): void {
      $query ="
        DELETE FROM artisti
        WHERE AR_CodiceArtista = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "s",
          $id
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "delete() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_anni(int $dal, int $al): array {
      $query = "
        SELECT AR_CodiceArtista, AR_Nome, AR_Alias, AR_DataNascita, AR_DataMorte
        FROM artisti
        WHERE AR_DataNascita BETWEEN ? AND ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "ii",
          $dal,
          $al
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_by_anni() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_quadri(string $id): array {
      $query = "
        SELECT QQ_TitoloQuadro, QQ_AnnoEsecuzione, QQ_Tecnica, QQ_Altezza, QQ_Larghezza, QQ_CodiceMuseo, QQ_Note, QQ_Url, MM_Nome, MM_Citta
        FROM quadri
        JOIN musei ON MM_CodiceMuseo = QQ_CodiceMuseo
        WHERE QQ_CodiceArtista = ? 
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "s",
          $id
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_quadri() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>
