<?php 
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Artista.php';

  class ArtistaController {
    private Artista $model;

    public function __construct() {
      $this->model = new Artista();
    }

    public function index(): void {
      try {
        $artisti = $this->model->get_all();
        http_response_code(200);
        echo (json_encode($artisti));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "index() Fallita: " . $error->getMessage()]));
      }
    }

    public function select(string $id): void {
      try {
        $artista = $this->model->get_by_id($id);
        if ($artista) {
          http_response_code(200);
          echo (json_encode($artista));
        } else {
          http_response_code(404);
          echo (json_encode(["errore" => "Artista non Trovato"]));
        }
      } catch (Exception $error) {
         http_response_code(500);
        die(json_encode(["errore" => "select() Fallita: " . $error->getMessage()]));
      }
    }

    public function create(array $data): void {
      if (empty($data["AR_CodiceArtista"]) || empty($data["AR_Nome"])) {
        http_response_code(404);
        die(json_encode(["errore" => "Codice e Nome sono Obbligatorie"]));
      }
      try {
        $this->model->create(
          $data["AR_CodiceArtista"],
          $data["AR_Nome"],
          $data["AR_Alias"],
          (int)$data["dataNascita"],
          (int)$data["dataMorte"]
        );
        http_response_code(201);
        echo json_encode(["messaggio" => "Artista Creato"]);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita: " . $error->getMessage()]));  
      }
    }

    public function update(string $id, array $data): void {
      if (empty($id)) {
        http_response_code(404);
        die(json_encode(["errore" => "Codice e Obbligatorio"]));
      }
      try {
        $this->model->update(
          $id,
          $data["AR_Nome"],
          $data["AR_Alias"],
          (int)$data["AR_DataNascita"],
          (int)$data["AR_DataMorte"]
        );
        http_response_code(200);
        echo json_encode(["messaggio" => "Artista Aggiornato"]);
      } catch (Exception $error) {
         http_response_code(500);
         die(json_encode(["errore" => "update() Fallita: " . $error->getMessage()])); 
      }
    }

    public function delete(string $id): void {
      if (empty($id)) {
        http_response_code(404);
        die(json_encode(["errore" => "Codice e Obbligatorio"]));
      }
      try {
        $this->model->delete($id);
        http_response_code(200);
        echo json_encode(["messaggio" => "Artista Eliminato con Successo"]);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_anni(int $dal, int $al): void {
      if (empty($al) || empty($dal)) {
        http_response_code(404);
        die(json_encode(["errore" => "Dal e Al sono Obbligatori"]));
      }
      try {
        $artisti = $this->model->get_by_anni($dal, $al);
        http_response_code(200);
        echo json_encode($artisti);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_by_anni() Fallita: " . $error->getMessage()]));
      }
    }

    public function quadri(string $id): void {
      if (empty($id)) {
        http_response_code(404);
        die(json_encode(["errore" => "Id e Obbligatorio"]));
      }
      try {
        $quadri = $this->model->get_quadri($id);
        http_response_code(200);
        echo json_encode($quadri);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "quadri() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>