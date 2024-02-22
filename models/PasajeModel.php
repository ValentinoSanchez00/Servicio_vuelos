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
    
    public function getPasjebyId($id) {
           try {
            $sql = "SELECT 
            pa.idpasaje,
            pa.pasajerocod,
            pj.nombre,
            pj.pais,
            pa.numasiento,
            pa.clase,
            pa.pvp
        FROM pasaje pa
        JOIN pasajero pj ON pa.pasajerocod = pj.pasajerocod
        WHERE pa.identificador = '".$id."'";
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
            $sql = "DELETE FROM $this->table WHERE idpasaje ='" . $id . "';";
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

    public function actualiza($post) {
        try {

            $sql = "SELECT count(*) pasajerocod FROM $this->table WHERE identificador = '" . $post["identificador"] . "' AND pasajerocod=" . $post["pasajerocod"] . ";";
            $statement = $this->conexion->query($sql);
            $registros1 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador = $registros1[0];
            if ($contador["pasajerocod"] > 0) {
                return "Error el pasajero: " . $post["identificador"] . " ya tiene un vuelo";
            }

            $sql = "SELECT count(*) 'count' FROM $this->table WHERE identificador = '" . $post["identificador"] . "' AND numasiento = " . $post["numasiento"];
            $statement = $this->conexion->query($sql);
            $registros2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador2 = $registros2[0];
            if ($contador2['count'] > 0) {
                return "Error ya hay un asiento cogido en este vuelo";
            }

            if ($registros1 && $registros2) {
                try {
                    // Asumiendo que 'idpasaje' es la clave primaria de la tabla pasaje
                    $sql = "UPDATE pasaje SET pasajerocod=?, identificador=?, numasiento=?, clase=?, pvp=? WHERE idpasaje = ?";
                    $sentencia = $this->conexion->prepare($sql);

                    // Suponiendo que los campos se llaman igual en $post
                    $sentencia->bindParam(1, $post['pasajerocod']);
                    $sentencia->bindParam(2, $post['identificador']);
                    $sentencia->bindParam(3, $post['numasiento']);
                    $sentencia->bindParam(4, $post['clase']);
                    $sentencia->bindParam(5, $post['pvp']);
                    $sentencia->bindParam(6, $post['idPasaje']);  // Asegúrate de que 'idPasaje' sea el nombre correcto

                    $num = $sentencia->execute();

                    if ($sentencia->rowCount() == 0) {
                        return "Registro NO actualizado, o no existe o no hay cambios: " . $post['idPasaje'];
                    } else {
                        return "Registro actualizado: " . $post['idPasaje'];
                    }
                } catch (PDOException $e) {
                    return "Error al actualizar.<br>" . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }

    public function postvalidar($post) {
        try {

            $sql = "SELECT count(*) pasajerocod FROM $this->table WHERE identificador = '" . $post["identificador"] . "' AND pasajerocod=" . $post["pasajerocod"] . ";";
            $statement = $this->conexion->query($sql);
            $registros1 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador = $registros1[0];
            if ($contador["pasajerocod"] > 0) {
                return "Error el pasajero: " . $post["identificador"] . " ya tiene un vuelo";
            }

            $sql = "SELECT count(*) 'count' FROM $this->table WHERE identificador = '" . $post["identificador"] . "' AND numasiento = " . $post["numasiento"];
            $statement = $this->conexion->query($sql);
            $registros2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;
            $contador2 = $registros2[0];
            if ($contador2['count'] > 0) {
                return "Error ya hay un asiento cogido en este vuelo";
            }

            if ($registros1 && $registros2) {
                try {
                    $sql3 = "insert into pasaje (pasajerocod,identificador,numasiento,clase,pvp) values (?,?,?,?,?)";
                    $sentencia = $this->conexion->prepare($sql3);
                    $sentencia->bindParam(1, $post["pasajerocod"]);
                    $sentencia->bindParam(2, $post["identificador"]);
                    $sentencia->bindParam(3, $post["numasiento"]);
                    $sentencia->bindParam(4, $post["clase"]);
                    $sentencia->bindParam(5, $post["pvp"]);
                    $num = $sentencia->execute();
                    return "Registro insertado: " . $post["identificador"];
                } catch (PDOException $e) {
                    return "Error al grabar.<br>" . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            return "ERROR AL CARGAR.<br>" . $e->getMessage();
        }
    }
    
    
    
        public function borrar($id)  {
        try {
            $sql = "delete from $this->table where idpasaje= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $num = $sentencia->execute();
            if ($sentencia->rowCount() == 0)
                return "Registro NO Borrado, no se localiza: " . $id;
            else
                return "Registro Borrado: " . $id;
           } catch (PDOException $e) {
            return "ERROR AL BORRAR.<br>" . $e->getMessage();
        }
    }
}
