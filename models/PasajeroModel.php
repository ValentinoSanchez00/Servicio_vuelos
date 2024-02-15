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
            $sql = "SELECT * FROM pasajero WHERE nombre = '" . $nombre . "' AND NOT EXISTS (SELECT 1 FROM pasaje WHERE pasajero.pasajerocod = pasaje.pasajerocod  AND pasaje.identificador = '" . $identificador . "');";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;

            return $registros;
            
            //<b>Warning</b>:  Array to string conversion in <b>C:\xampp\htdocs\_servWeb\vueloservice\Pasajero.php</b> on line <b>19</b><br />
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function getvalidarasiento($asiento, $identificador) {
        try {
            $sql = "SELECT * FROM pasaje WHERE identificador = '" . $identificador . "' AND numasiento = " . $asiento;
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
//<b>Warning</b>:  Array to string conversion in <b>C:\xampp\htdocs\_servWeb\vueloservice\Pasajero.php</b> on line <b>23</b><br />
            return $registros;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }
}
