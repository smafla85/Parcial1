<?php
require_once('../config/config.php');

class Peliculas {
    public function todos() {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM peliculas ORDER BY titulo";
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
        $cadena = "SELECT * FROM peliculas WHERE pelicula_id = $id";
        $datos = mysqli_query($con, $cadena);
        if (!$datos) {
            return "Error en la consulta: " . mysqli_error($con);
        }
        $con->close();
        return mysqli_fetch_assoc($datos);
    }

    public function insertar($titulo, $genero, $anyo, $director) {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $titulo = mysqli_real_escape_string($con, $titulo);
            $genero = mysqli_real_escape_string($con, $genero);
            $anyo = intval($anyo);
            $director = mysqli_real_escape_string($con, $director);

            $cadena = "INSERT INTO peliculas (titulo, genero, año, director) 
                       VALUES ('$titulo', '$genero', $anyo, '$director')";
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

    public function actualizar($id, $titulo, $genero, $anyo, $director) {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $id = intval($id);
            $titulo = mysqli_real_escape_string($con, $titulo);
            $genero = mysqli_real_escape_string($con, $genero);
            $anyo = intval($anyo);
            $director = mysqli_real_escape_string($con, $director);

            $cadena = "UPDATE peliculas SET 
                       titulo = '$titulo', 
                       genero = '$genero', 
                       año = $anyo, 
                       director = '$director' 
                       WHERE pelicula_id = $id";
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
            $cadena = "DELETE FROM peliculas WHERE pelicula_id = $id";
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