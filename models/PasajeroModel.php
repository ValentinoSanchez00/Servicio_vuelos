<?php

class PasajeroModel extends Basedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "pasajero";
        $this->conexion = $this->getConexion();
    }

    public function getAll() {
        try {
            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
// Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getNombres() {
        try {
            $sql = "SELECT CONCAT(pasajerocod, '- ', nombre) AS nombre_concatenado FROM pasajero;";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
// Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getvalidar($nombre, $identificador, $numasiento, $clase, $pvp) {
        try {
            $id= intval($nombre);
            $sql = "SELECT count(*) 'count' FROM $this->table WHERE pasajerocod = " . $id . " AND NOT EXISTS (SELECT 1 FROM pasaje WHERE pasajero.pasajerocod = pasaje.pasajerocod  AND pasaje.identificador = '" . $identificador . "');";
            $statement = $this->conexion->query($sql);
            $registros1 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador = $registros1[0];
            if ($contador['count'] <= 0) {
                return false;
            }

            $sql = "SELECT count(*) 'count' FROM pasaje WHERE identificador = '" . $identificador . "' AND numasiento = " . $numasiento;
            $statement = $this->conexion->query($sql);
            $registros2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador2 = $registros2[0];
            if ($contador2['count'] > 0) {
                return false;
            }

            if ($registros1 && $registros2) {
                try {
                    $sql3 = "insert into pasaje (pasajerocod,identificador,numasiento,clase,pvp) values (?,?,?,?,?)";
                    $sentencia = $this->conexion->prepare($sql3);
                    $sentencia->bindParam(1, $id);
                    $sentencia->bindParam(2, $identificador);
                    $sentencia->bindParam(3, $numasiento);
                    $sentencia->bindParam(4, $clase);
                    $sentencia->bindParam(5, $pvp);
                    $num = $sentencia->execute();
                    return "Registro insertado: " . $identificador;
                } catch (PDOException $e) {
                    return "Error al grabar.<br>" . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }
}

//SELECT count(*) 'count' FROM pasajero WHERE nombre = "ATONIO MART?NEZ" AND pasajerocod NOT IN(SELECT pasajerocod FROM pasaje WHERE identificador = 'AVI-345');