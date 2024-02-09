<?php

class VuelosModel extends Basedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "vuelo";
        $this->conexion = $this->getConexion();
    }

    public function getAll() {
        try {
            $sql = "SELECT v.identificador,v.aeropuertoorigen,v.aeropuertodestino,v.tipovuelo,v.fechavuelo,v.descuento,COUNT(p.identificador) 'numpasajero' FROM $this->table v  LEFT JOIN pasaje p ON (v.identificador=p.identificador) GROUP BY v.identificador";
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
