<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/peliculas.model.php');

$peliculas = new Peliculas;

switch ($_GET["op"]) {
    case 'todos': 
        $datos = $peliculas->todos();
        $todos = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        $id = $_POST["id"] ?? null;
        if ($id) {
            $datos = $peliculas->uno($id);
            echo json_encode($datos);
        } else {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
        }
        break;

    case 'insertar':
        $titulo = $_POST["titulo"] ?? null;
        $genero = $_POST["genero"] ?? null;
        $anyo = $_POST["año"] ?? null;
        $director = $_POST["director"] ?? null;

        if ($titulo && $genero && $anyo && $director) {
            $datos = $peliculas->insertar($titulo, $genero, $anyo, $director);
            if (is_numeric($datos)) {
                echo json_encode(["status" => "success", "message" => "Película insertada correctamente", "id" => $datos]);
            } else {
                echo json_encode(["status" => "error", "message" => $datos]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        }
        break;

    case 'actualizar':
        $id = $_POST["id"] ?? null;
        $titulo = $_POST["titulo"] ?? null;
        $genero = $_POST["genero"] ?? null;
        $anyo = $_POST["año"] ?? null;
        $director = $_POST["director"] ?? null;

        if ($id && $titulo && $genero && $anyo && $director) {
            $datos = $peliculas->actualizar($id, $titulo, $genero, $anyo, $director);
            if (is_numeric($datos)) {
                echo json_encode(["status" => "success", "message" => "Película actualizada correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => $datos]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        }
        break;

    case 'eliminar':
        $id = $_POST["id"] ?? null;
        if ($id) {
            $datos = $peliculas->eliminar($id);
            if ($datos === 1) {
                echo json_encode(["status" => "success", "message" => "Película eliminada correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => $datos]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Operación no válida"]);
        break;
}
?>