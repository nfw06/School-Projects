<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Museo.php';

  class MuseoController {
    private Museo $model;

    public function __construct() {
      $this->model = new Museo();
    }

    public function index(): void {
      try {
        $musei = $this->model->get_all();
        http_response_code(200);
        echo(json_encode($musei));
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "index() Fallita: " . $error->getMessage()]));
      }
    }

    public function select(string $id): void {
      try {
        $museo = $this->model->get_by_id($id);
        if($museo) {
          http_response_code(200);
          echo(json_encode($museo));
        } else {
          http_response_code(404);
          echo (json_encode(["errore" => "Museo non Trovato"]));
        }
      } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["errore" => "select() Fallita: " . $error->getMessage()]));
      }
    }
  }
?>