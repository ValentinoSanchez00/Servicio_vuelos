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
            $sql = "SELECT 
    v.identificador,
    v.aeropuertoorigen AS codigo_origen,
    ao.nombre AS nombre_origen,
    v.aeropuertodestino AS codigo_destino,
    ad.nombre AS nombre_destino,
    v.tipovuelo,
    v.fechavuelo,
    v.descuento,
    COUNT(p.identificador) AS numpasajero
FROM $this->table v
LEFT JOIN pasaje p ON v.identificador = p.identificador    
JOIN aeropuerto ao ON v.aeropuertoorigen = ao.codaeropuerto
JOIN aeropuerto ad ON v.aeropuertodestino = ad.codaeropuerto
GROUP BY 
    v.identificador,
    v.aeropuertoorigen,
    ao.nombre,
    v.aeropuertodestino,
    ad.nombre,
    v.tipovuelo,
    v.fechavuelo,
    v.descuento;
";

            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            // Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getUnVuelo($identificador) {
        try {
            $sql = "SELECT 
    v.identificador,
    v.aeropuertoorigen AS codigo_origen,
    ao.nombre AS nombre_origen,
    v.aeropuertodestino AS codigo_destino,
    ad.nombre AS nombre_destino,
    v.tipovuelo,
    v.fechavuelo,
    v.descuento,
    COUNT(p.identificador) AS numpasajero
FROM $this->table v
LEFT JOIN pasaje p ON v.identificador = p.identificador    
JOIN aeropuerto ao ON v.aeropuertoorigen = ao.codaeropuerto
JOIN aeropuerto ad ON v.aeropuertodestino = ad.codaeropuerto
WHERE v.identificador = '" . $identificador . "'
GROUP BY 
    v.identificador,
    v.aeropuertoorigen,
    ao.nombre,
    v.aeropuertodestino,
    ad.nombre,
    v.tipovuelo,
    v.fechavuelo,
    v.descuento";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            // Retorna el array de registros
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getidentificadores() {
        try {
            $sql = "SELECT CONCAT(identificador, ' - ', aeropuertoorigen, ' - ', aeropuertodestino) AS identificadores FROM vuelo;";
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
