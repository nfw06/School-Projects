<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Regista.php';

  class RegistaController {
    private Regista $model;

    public function __construct() {
      try {
        $this->model = new Regista();
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "__construct() Fallita: " . $error->getMessage()]));
      }
    }

    public function select(array $data): void {
      try {
        $regista = $this->model->get_regista($data["cognome"], $data["nome"]);
        if ($regista) {
          http_response_code(200);
          echo(json_encode($regista));
        } else {
          http_response_code(404);
          echo(json_encode(["errore" => "Regista non Trovato"]));
        }
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "select() Fallita: " . $error->getMessage()]));
      }
    }

    public function create(array $data): void {
      if (empty($data["cognome"] && empty($data["nome"]))) {
        http_response_code(404);
        die(json_encode(["errore" => "Il Cognome e il Nome sono Obbligatorie"]));
      }
      try {
        $this->model->create($data["cognome"], $data["nome"]);
        http_response_code(201);
        echo(json_encode(["messaggio" => "Regista Creato"]));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "create() Fallita: " . $error->getMessage()]));
      }
    }

    public function update(array $data): void {
      if (empty($data["id"]) && empty($data["cognome"] && empty($data["nome"]))) {
        http_response_code(404);
        die(json_encode(["errore" => "Il Cognome e il Nome sono Obbligatorie"]));
      }
      try {
        $this->model->update($data["id"], $data["cognome"], $data["nome"]);
        http_response_code(200);
        echo(json_encode(["messaggio" => "Regista aggiornato con Successo"]));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "update() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>