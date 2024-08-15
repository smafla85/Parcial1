<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/actores.model.php');

$actores = new Actores;

switch ($_GET["op"]) {
    case 'todos': 
        $datos = $actores->todos();
        $todos = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        $id = $_POST["id"] ?? null;
        if ($id) {
            $datos = $actores->uno($id);
            echo json_encode($datos);
        } else {
            echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
        }
        break;

    case 'insertar':
        $nombre = $_POST["nombre"] ?? null;
        $apellido = $_POST["apellido"] ?? null;
        $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? null;
        $nacionalidad = $_POST["nacionalidad"] ?? null;

        if ($nombre && $apellido && $fecha_nacimiento && $nacionalidad) {
            $datos = $actores->insertar($nombre, $apellido, $fecha_nacimiento, $nacionalidad);
            if (is_numeric($datos)) {
                echo json_encode(["status" => "success", "message" => "Actor insertado correctamente", "id" => $datos]);
            } else {
                echo json_encode(["status" => "error", "message" => $datos]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        }
        break;

    case 'actualizar':
        $id = $_POST["id"] ?? null;
        $nombre = $_POST["nombre"] ?? null;
        $apellido = $_POST["apellido"] ?? null;
        $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? null;
        $nacionalidad = $_POST["nacionalidad"] ?? null;

        if ($id && $nombre && $apellido && $fecha_nacimiento && $nacionalidad) {
            $datos = $actores->actualizar($id, $nombre, $apellido, $fecha_nacimiento, $nacionalidad);
            if (is_numeric($datos)) {
                echo json_encode(["status" => "success", "message" => "Actor actualizado correctamente"]);
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
            $datos = $actores->eliminar($id);
            if ($datos === 1) {
                echo json_encode(["status" => "success", "message" => "Actor eliminado correctamente"]);
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