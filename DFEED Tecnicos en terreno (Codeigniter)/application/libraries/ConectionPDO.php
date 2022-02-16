<?php
class conectionPdo
{

    public function __construct()
    {
        $this->result = 0;
    }

    //obtener la conexion a la base de datos MYSQL
    public function obtenerConexionMy()
    {
        try {
            $conectarMYSQL = new PDO("mysql:host=" . HOST_DB . ";", USER_DB, PASS_DB, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conectarMYSQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conectarMYSQL;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function arrayConsulta($campos, $tablas, $consultas = '1=1', $modulo = null, $controler = null, $debug = false, $accion = 'consult')
    {
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = ("SELECT $campos FROM $tablas WHERE $consultas");
            $preparar = $conectar->prepare($sql);
            $preparar->execute();
            $resultado = $preparar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return $resultado;
    }

    public function arrayConsultanum($campos, $tablas, $consultas, $modulo = null, $controler = null, $debug = false, $accion = 'count')
    {
        /*
          |--------------------------------------------------------------------------
          | Hacemos la conexion a MYSQL
          |--------------------------------------------------------------------------
          | Esto es para llamar a la conexion en PDO que creamos
          |--------------------------------------------------------------------------
         */
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = ("SELECT $campos FROM $tablas WHERE $consultas");
            $preparar = $conectar->prepare($sql);
            $preparar->execute();
            $resultado = $preparar->rowCount();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return $resultado;
    }

    public function arrayDelete($consultas, $tabla, $modulo = null, $controler = null, $debug = true, $accion = 'delete')
    {
        /*
          |--------------------------------------------------------------------------
          | Hacemos la conexion a MYSQL
          |--------------------------------------------------------------------------
          | Esto es para llamar a la conexion en PDO que creamos
          |--------------------------------------------------------------------------
         */
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        try {
            //echo "DELETE FROM $tabla WHERE $consultas";
            $sql = ("DELETE FROM $tabla WHERE $consultas");
            $preparar = $conectar->prepare($sql);
            $delete = $preparar->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return $delete;
    }

    public function arrayUpdate($campo, $tabla, $consulta, $modulo = null, $controler = null, $debug = true, $accion = 'update')
    {
        /*
          |--------------------------------------------------------------------------
          | Hacemos la conexion a MYSQL
          |--------------------------------------------------------------------------
          | Esto es para llamar a la conexion en PDO que creamos
          |--------------------------------------------------------------------------
         */
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = ("UPDATE $tabla SET  $campo WHERE $consulta");
            $preparar = $conectar->prepare($sql);
            $preparar->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return "OK";
    }

    public function arrayInserte($campo1, $tabla, $campo2, $modulo = null, $controler = null, $debug = true, $accion = 'insert')
    {
        /*
          |--------------------------------------------------------------------------
          | Hacemos la conexion a MYSQL
          |--------------------------------------------------------------------------
          | Esto es para llamar a la conexion en PDO que creamos
          |--------------------------------------------------------------------------
         */
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        //$campo2 = strtolower($campo2);
        try {
            $sql = ("INSERT INTO $tabla ($campo1) VALUES ($campo2)");
            $preparar = $conectar->prepare($sql);
            $insert = $preparar->execute();
            $result = $conectar->lastInsertId();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return $result;
    }

    public function arrayejecutar($consulta, $modulo = null, $controler = null, $debug = true, $accion = 'execute')
    {
        /*
          |--------------------------------------------------------------------------
          | Hacemos la conexion a MYSQL
          |--------------------------------------------------------------------------
          | Esto es para llamar a la conexion en PDO que creamos
          |--------------------------------------------------------------------------
         */
        $conexion = new conectionPdo();
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = $consulta;
            $preparar = $conectar->prepare($sql);
            $execution = $preparar->execute();
            $resultado = $preparar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $conexion->Logs_sistema($sql, $modulo, $error);
            return "NOK";
        }
        if ($debug) {
            $conexion->Logs_operaciones($sql, $modulo, $controler, $accion);
        }
        $conexion = null;
        $conectar = null;
        return $resultado;
    }

    public function Logs_operaciones($description, $modulo, $controler, $accion)
    {
        $idUser = $_SESSION['user_id'];
        if(!$idUser){
            $idUser = 0;
        }
        $conexion = new conectionPdo();
        $description = Tools::sanitize($description);
        $modulo = Tools::sanitize($modulo);
        $accion = Tools::sanitize($accion);
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = "INSERT INTO " . ESQUEMA_SMP . ".DATA_LOG_OPERATIONS (op_description,op_UserId,op_module,op_controler, op_accion,op_ambiente) VALUES ('{$description}', {$idUser} ,'{$modulo}','{$controler}', '{$accion}', 'web')";
            $preparar = $conectar->prepare($sql);
            $preparar->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $sql = Tools::sanitize($sql);
            $error = Tools::sanitize($error);
            //conectionPdo::Logs_sistema($sql, $modulo, $error);
        }
        $conectar = null;
        return $error;
        $conectar = null;
    }

    public function Logs_sistema($description, $modulo, $error)
    {
        $idUser = $_SESSION['user_id'];
        if(!$idUser){
            $idUser = 0;
        }
        $conexion = new conectionPdo();

        $description = Tools::sanitize($description);
        $description = str_replace("'", "\"", $description);
        $modulo = Tools::sanitize($modulo);
        $error = Tools::sanitize($error);
        $error = str_replace("'", "\"", $error);
        $conectar = $conexion->obtenerConexionMy();
        try {
            $sql = "INSERT INTO " . ESQUEMA_SMP . ".DATA_LOG_SYSTEM (log_description,log_UserId,log_module, log_error,log_ambiente) VALUES ('{$description}', {$idUser} ,'{$modulo}', '{$error}', 'web')";
            $preparar = $conectar->prepare($sql);
            $preparar->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
        $conectar = null;
        return $error;
    }
}
