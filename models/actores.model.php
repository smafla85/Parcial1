<?php
require_once('../config/config.php');

class Actores {
    public function todos() {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM actores ORDER BY apellido, nombre";
        $datos = mysqli_query($con, $cadena);
        if (!$datos) {
            return "Error en la consulta: " . mysqli_error($con);
        }
        $con->close();
        return $datos;
    }

    public function uno($id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $id = mysqli_real_escape_string($con, $id);
        $cadena = "SELECT * FROM actores WHERE actor_id = $id";
        $datos = mysqli_query($con, $cadena);
        if (!$datos) {
            return "Error en la consulta: " . mysqli_error($con);
        }
        $con->close();
        return mysqli_fetch_assoc($datos);
    }

    public function insertar($nombre, $apellido, $fecha_nacimiento, $nacionalidad) {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $nombre = mysqli_real_escape_string($con, $nombre);
            $apellido = mysqli_real_escape_string($con, $apellido);
            $fecha_nacimiento = mysqli_real_escape_string($con, $fecha_nacimiento);
            $nacionalidad = mysqli_real_escape_string($con, $nacionalidad);

            $cadena = "INSERT INTO actores (nombre, apellido, fecha_nacimiento, nacionalidad) 
                       VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$nacionalidad')";
            if (mysqli_query($con, $cadena)) {
                return mysqli_insert_id($con);
            } else {
                return "Error en la consulta: " . mysqli_error($con);
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($id, $nombre, $apellido, $fecha_nacimiento, $nacionalidad) {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $id = intval($id);
            $nombre = mysqli_real_escape_string($con, $nombre);
            $apellido = mysqli_real_escape_string($con, $apellido);
            $fecha_nacimiento = mysqli_real_escape_string($con, $fecha_nacimiento);
            $nacionalidad = mysqli_real_escape_string($con, $nacionalidad);

            $cadena = "UPDATE actores SET 
                       nombre = '$nombre', 
                       apellido = '$apellido', 
                       fecha_nacimiento = '$fecha_nacimiento', 
                       nacionalidad = '$nacionalidad' 
                       WHERE actor_id = $id";
            if (mysqli_query($con, $cadena)) {
                return $id;
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($id) {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $id = intval($id);
            $cadena = "DELETE FROM actores WHERE actor_id = $id";
            if (mysqli_query($con, $cadena)) {
                return 1;
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }
}
?>