<?php
class Conexao {
    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '';
    private $banco = 'workshow';

    private $conn;
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);

        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }
    public function getConnection() {
        return $this->conn;
    }
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
 

?>