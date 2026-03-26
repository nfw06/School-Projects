<?php
  declare(strict_types = 1);
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  header("Content-Type: application/json;");

  require_once __DIR__ . '/controllers/ArtistaController.php';
  require_once __DIR__ . '/controllers/QuadroController.php';
  require_once __DIR__ . '/controllers/MuseoController.php';

  $request_method = $_SERVER["REQUEST_METHOD"];
  $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
  $base_path = "/php/arte_api/server";
  if (str_starts_with($uri, $base_path)) {
    $uri = substr($uri, strlen($base_path));
  }
  $uri = trim($uri, "/");
  $segments = $uri === "" ? [] : explode("/", $uri);

  // Gestione della Rotta per gli Artisti
  if (count($segments) > 0 && $segments[0] === "artisti") {
    $controller = new ArtistaController();

    // GET - /artisti?dal=&al=Y
    if ($request_method === "GET" && count($segments) === 1 && isset($_GET["dal"], $_GET["al"])) {
      $controller->get_by_anni((int)$_GET["dal"], (int)$_GET["al"]);
      exit;
    }

    // GET - /artisti
    if ($request_method === "GET" && count($segments) === 1 && $segments[0] === "artisti") {
      $controller->index();
      exit;
    }

    // GET - /artisti/{id}
    if ($request_method === "GET" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "artisti") {
      $controller->select($segments[1]);
      exit;
    }

    // GET - /artisti/{id}/quadri
    if ($request_method === "GET" && count($segments) === 3 && isset($segments[0], $segments[1], $segments[2]) && $segments[0] === "artisti" && $segments[2] === "quadri") {
      $controller->quadri($segments[1]);
      exit;
    }

    // POST - /artisti
    if ($request_method === "POST" && count($segments) === 1 && $segments[0] === "artisti") {
      $data = json_decode(file_get_contents("php://input"), true) ?? [];
      $controller->create($data);
      exit;
    }

    // PUT - /artisti/{id}
    if ($request_method === "PUT" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "artisti") {
      $data = json_decode(file_get_contents("php://input"), true) ?? [];
      $controller->update($segments[1], $data);
      exit;
    }

    // DELETE - /artisti/{id}
    if ($request_method === "DELETE" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "artisti") {
      $controller->delete($segments[1]);
      exit;
    }
  }

  // Gestione della Rotta per gli Quadri
  if (count($segments) > 0 && $segments[0] == "quadri") {
    $controller = new QuadroController();

    // GET - /quadri
    if ($request_method === "GET" && count($segments) === 1 && $segments[0] === "quadri") {
      $controller->index();
      exit;
    }

    // GET - /quadri/{titolo}
     if ($request_method === "GET" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "quadri") {
      $controller->select(urldecode($segments[1]));
      exit;
     }

    // POST - /quadri
    if ($request_method === "POST" && count($segments) === 1 && $segments[0] === "quadri") {
      $data = json_decode(file_get_contents("php://input"), true) ?? [];
      $controller->create($data);
      exit;
    }

    // PUT - /quadri/{titolo}
    if ($request_method === "PUT" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "quadri") {
      $data = json_decode(file_get_contents("php://input"), true) ?? [];
      $controller->update(urldecode($segments[1]), $data);
      exit;
    }

    // DELETE /quadri/{titolo}
    if ($request_method === "DELETE" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "quadri") {
      $controller->delete(urldecode($segments[1]));
      exit;
    }
  }

  // Gestione della Roota per i Musei
  if (count($segments) > 0 && $segments[0] === "musei") {
    $controller = new MuseoController();

    // GET - /musei
    if ($request_method === "GET" && count($segments) === 1 && $segments[0] === "musei") {
      $controller->index();
      exit;
    }

    // GET - /musei/{id}
    if ($request_method === "GET" && count($segments) === 2 && isset($segments[0], $segments[1]) && $segments[0] === "musei") {
      $controller->select($segments[1]);
      exit;
    }

    // GET - /musei/{id}/quadri
    if ($request_method === "GET" && count($segments) === 3 && isset($segments[0], $segments[1], $segments[2]) && $segments[0] === "musei" && $segments[2] === "quadri") {
      (new QuadroController)->get_by_museo($segments[1]);
      exit;
    }
  }

  // Fallback - Nel Caso in cui la rotta non esiste
  http_response_code(404);
  echo json_encode(["errore" => "Endpoint non Trovato"]);
?> 
