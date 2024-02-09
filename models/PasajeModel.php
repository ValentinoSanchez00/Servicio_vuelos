<?php

class PasajeModel extends Basedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "pasaje";
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
    
    public function GetPasajerosidentificador($id) {
        try {
            $sql = "SELECT COUNT(identificador) 'Num pasajeros' FROM $this->table where identificador='".$id."' GROUP BY identificador";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            // Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }


}
