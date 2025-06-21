<?php
include_once __DIR__ . '/../conexao/banco.php';

class Categoria {
    private $id_categoria;
    private $nome;
    private $data;
    private $id_usuario;

    // Construtor
    public function __construct($nome, $data, $id_usuario) {

        $this->nome = $nome;
        $this->data = $data;
        $this->id_usuario = $id_usuario;
    }

    // Getters

    public function getNome() {
        return $this->nome;
    }

    public function getData() {
        return $this->data;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    // Método para salvar a categoria no banco de dados
    public function salvar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("INSERT INTO categorias (nome, data, id_usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $this->nome, $this->data, $this->id_usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para listar todas as categorias
    public static function listar() {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    $stmt = $conn->prepare("SELECT * FROM categorias");
    $stmt->execute();
    $result = $stmt->get_result();

    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;  // Salva como array associativo
    }

    return $categorias;
}
    // Método para buscar uma categoria pelo ID
    public static function buscarPorId($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();  // Retorna a categoria como array associativo
    }

    public static function atualizar($nome, $id_categoria) {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    $stmt = $conn->prepare("UPDATE categorias SET nome = ? WHERE id_categoria = ?");
    $stmt->bind_param("si", $nome, $id_categoria);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    }
    // Método para excluir uma categoria pelo ID
    public static function excluir($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function temProjetosVinculados($id_categoria) {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM postagem WHERE id_categoria = ?");
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return ($row['total'] > 0);
}

public static function existeCategoria() {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    $sql = "SELECT COUNT(*) AS total FROM categorias";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return ($row['total'] > 0);
    } else {
        return false;
    }
}




    
}
?>
