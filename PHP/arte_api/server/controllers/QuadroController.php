<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Quadro.php';

  class QuadroController {
    private Quadro $model;

    public function __construct() {
      $this->model = new Quadro();
    }

    public function index(): void {
      try {
        $quadri = $this->model->get_all();
        http_response_code(200);
        echo (json_encode($quadri));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "index() Fallita" . $error->getMessage()]));
      }
    }

    public function select(string $titolo): void {
      try {
        $quadro = $this->model->get_by_titolo($titolo);
        if ($quadro) {
          http_response_code(200);
          echo (json_encode($quadro));
        } else {
          http_response_code(404);
          echo (json_encode(["errore" => "Quadro non Trovato"]));
        }
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "select() Fallita" . $error->getMessage()]));
      }
    }

    public function create(array $data): void {
      if (empty($data["QQ_TitoloQuadro"])) {
        http_response_code(404);
        die(json_encode(["errore" => "Il Titolo del Quadro è Obbligatorio"]));
      }
      try {
        $this->model->create(
          $data["QQ_TitoloQuadro"],
          $data["QQ_CodiceArtista"],
          (int)$data["QQ_AnnoEsecuzione"],
          $data["QQ_Tecnica"],
          (int)$data["QQ_Altezza"],
          (int)$data["QQ_Larghezza"],
          $data["QQ_CodiceMuseo"],
          $data["QQ_Note"],
          $data["QQ_Url"]
        );
        http_response_code(201);
        echo json_encode(["messaggio" => "Quadro Creato con Successo"]);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita" . $error->getMessage()]));
      }
    }

    public function update(string $titolo, array $data): void {
      if (empty($titolo)) {
        http_response_code(404);
        die(json_encode(["errore" => "Il Titolo del Quadro è Obbligatorio"]));
      }
      try {
        $this->model->update(
          $titolo,
          (int)$data["QQ_AnnoEsecuzione"],
          $data["QQ_Tecnica"],
          (int)$data["QQ_Altezza"],
          (int)$data["QQ_Larghezza"],
          $data["QQ_CodiceMuseo"],
          $data["QQ_Note"],
          $data["QQ_Url"]
        );
        http_response_code(200);
        echo json_encode(["messaggio" => "Quadro Aggiornato con Successo"]);
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita" . $error->getMessage()]));
      }
    }

    public function delete(string $titolo): void {
      if (empty($titolo) || $titolo === "") {
        http_response_code(404);
        die(json_encode(["errore" => "Il Titolo del Quadro e Obbligatorio"]));
      }
      try {
        $this->model->delete($titolo);
        http_response_code(200);
        echo (json_encode(["messaggio" => "Quadro Eliminato con Successo"]));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "delete() Fallita: " . $error->getMessage()]));
      }
    }

    public function get_by_museo(string $id): void {
      if (empty($id)) {
        http_response_code(404);
        die(json_encode(["errore" => "l'ID del Museo e Obbligatorio"]));
      }
      try {
        $quadro = $this->model->get_by_museo($id);
        http_response_code(200);
        echo (json_encode($quadro));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "get_by_museo() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>
