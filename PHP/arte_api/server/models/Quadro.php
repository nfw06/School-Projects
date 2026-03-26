<?php 
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/Database.php';

  class Quadro {
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
        SELECT QQ_TitoloQuadro, QQ_CodiceArtista, QQ_AnnoEsecuzione, QQ_Tecnica, QQ_Altezza, QQ_Larghezza, QQ_CodiceMuseo, QQ_Note, QQ_Url, AR_Nome, MM_Nome, MM_Citta
        FROM quadri
        JOIN artisti ON AR_CodiceArtista = QQ_CodiceArtista
        JOIN musei ON MM_CodiceMuseo = QQ_CodiceMuseo
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
         http_response_code(500);
        die(json_encode(["errore" => "get_all() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_titolo(string $titolo): ?array {
      $query = "
        SELECT QQ_TitoloQuadro, QQ_CodiceArtista, QQ_AnnoEsecuzione, QQ_Tecnica, QQ_Altezza, QQ_Larghezza, QQ_CodiceMuseo, QQ_Note, QQ_Url
        FROM quadri
        WHERE QQ_TitoloQuadro = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "s", 
          $titolo
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_by_titolo() Fallita: " . $error->getMessage()]));
      } 
    }

    public function create(string $titolo, string $id_artista, int $anno, string $tecnica, int $altezza, int $larghezza, string $id_museo, string $note, string $url): void {
      $query = "
        INSERT INTO quadri (QQ_TitoloQuadro, QQ_CodiceArtista, QQ_AnnoEsecuzione, QQ_Tecnica, QQ_Altezza, QQ_Larghezza, QQ_CodiceMuseo, QQ_Note, QQ_Url)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "ssisiisss",
          $titolo,
          $id_artista,
          $anno,
          $tecnica,
          $altezza,
          $larghezza,
          $id_museo,
          $note,
          $url
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita: " . $error->getMessage()]));
      }
    }

    public function update(string $titolo, int $anno, string $tecnica, int $altezza, int $larghezza, string $id_museo, string $note, string $url): void {
      $query = "
        UPDATE quadri
        SET QQ_AnnoEsecuzione = ?, QQ_Tecnica = ?, QQ_Altezza = ?, QQ_Larghezza = ?, QQ_CodiceMuseo = ?, QQ_Note = ?, QQ_Url = ?
        WHERE QQ_TitoloQuadro = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "isiissss",
          $anno,
          $tecnica,
          $altezza,
          $larghezza,
          $id_museo,
          $note,
          $url,
          $titolo
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita: " . $error->getMessage()]));
      }
    }

    public function delete(string $titolo): void {
      $query = "
        DELETE FROM quadri
        Where QQ_TitoloQuadro = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
          "s",
          $titolo
        );
        $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "delete() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_museo(string $id): array {
      $query = "
        SELECT QQ_TitoloQuadro, QQ_CodiceArtista, QQ_AnnoEsecuzione, QQ_Tecnica, QQ_Altezza, QQ_Larghezza, QQ_CodiceMuseo, QQ_Note, QQ_Url
        FROM quadri
        WHERE QQ_CodiceMuseo = ?
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
        die(json_encode(["errore" => "get_by_museo() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>