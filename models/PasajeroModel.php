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

    public function getvalidarnombre($nombre, $identificador) {
        try {
            $sql = "SELECT pasajerocod FROM pasajero WHERE pasajerocod NOT IN (SELECT pasajerocod FROM pasaje WHERE identificador='" . $identificador . "') AND nombre=" . $nombre;
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $hayRegistros = count($registros) > 0;

            return $hayRegistros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getvalidarasiento($asiento, $identificador) {
        try {
            $sql = "SELECT * FROM pasaje WHERE identificador='" . $identificador . "') AND asiento=" . $asiento;
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $hayRegistros = count($registros) > 0;

            return $hayRegistros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }
}
