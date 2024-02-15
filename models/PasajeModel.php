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
            $sql = "SELECT COUNT(identificador) 'Num pasajeros' FROM $this->table where identificador='" . $id . "' GROUP BY identificador";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            // Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getPasjeIdentificadores() {
        try {
            $sql = "SELECT identificador FROM $this->table GROUP BY identificador;";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            // Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

  public function deletebyId($id) {
    try {
        $sql = "DELETE FROM pasaje WHERE idpasaje ='".$id."';";
        $rowCount = $this->conexion->exec($sql);
        
        if ($rowCount > 0) {
            return ["success" => true, "message" => "Registro eliminado correctamente"];
        } else {
            return ["success" => false, "message" => "No se encontró el registro para eliminar"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "ERROR AL ELIMINAR: " . $e->getMessage()];
    }
}

    }

