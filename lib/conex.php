<?php
class MySQL {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli(
            "172.20.100.33",
            "admin", 
            "Control2023*.", 
            "dashboard_gnp");
        if ($this->conexion->connect_error) {
            die("Connection failed: " . $this->conexion->connect_error);
        }
        $this->conexion->set_charset("utf8");
    }

    public function query($consulta) {
        $resultado = $this->conexion->query($consulta);
        if (!$resultado) {
            throw new Exception('MySQL Error: ' . $this->conexion->error);
        }
        return $resultado;
    }

    public function prepare($consulta) {
        $stmt = $this->conexion->prepare($consulta);
        if (!$stmt) {
            throw new Exception('MySQL Prepare Error: ' . $this->conexion->error);
        }
        return $stmt;
    }

    public function execute_prepared($stmt, $params = []) {
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        if (!$stmt->execute()) {
            throw new Exception('MySQL Execute Error: ' . $stmt->error);
        }
        return $stmt->get_result();
    }

    public function fetch_array($consulta) {
        return $consulta->fetch_array();
    }

    public function fetch_associative_array($consulta) {
        return $consulta->fetch_assoc();
    }

    public function escape_string($string) {
        return $this->conexion->real_escape_string($string);
    }

    public function HallaValorUnico($consulta) {
        $val = $this->query($consulta);
        $data = $this->fetch_array($val);
        return $data[0];
    }

    public function Totalregistros($consulta) {
        $val = $this->query($consulta);
        $row_cnt = $val->num_rows;
        return $row_cnt;
    }

    public function last_insert_id() {
        return $this->conexion->insert_id;
    }

    public function begin_transaction() {
        $this->conexion->begin_transaction();
    }

    public function commit() {
        $this->conexion->commit();
    }

    public function rollback() {
        $this->conexion->rollback();
    }
}
?>