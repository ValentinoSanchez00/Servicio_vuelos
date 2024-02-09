<?php
require $_SERVER['DOCUMENT_ROOT'] . '/_servWeb/vueloservice/config/config.php';


abstract class Basedatos {
    private $conexion;
    private $mensajeerror = "";

    # Conectar a la base de datos
    public function getConexion() {
        global $nombreservidor, $nombrebd, $nombreusr, $contrasena;

        try {
            $this->conexion = new PDO("mysql:host=$nombreservidor;dbname=$nombrebd;charset=utf8", $nombreusr, $contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            $this->mensajeerror = $e->getMessage();
        }
    }

    # Desconectar la base de datos
    public function closeConexion() {
        $this->conexion = null;
    }

    # Devolver mensaje de error, por si hay error.
    public function getMensajeError() {
        return $this->mensajeerror;
    }
}
