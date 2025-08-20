<?php
include_once __DIR__ . '/../conexao/banco.php';

class Projeto {
    public $id_postagem;
    public $titulo;
    public $descricao;
    public $imagem;
    public $data;
    public $id_usuario;
    public $id_categoria;

    // Construtor
    public function __construct($titulo, $descricao, $imagem, $data, $id_usuario, $id_categoria, $id_postagem = null) {
        $this->id_postagem = $id_postagem;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->imagem = $imagem ;
        $this->data = $data ;
        $this->id_usuario = $id_usuario;
        $this->id_categoria = $id_categoria;
    }

    // Cadastrar Projeto
    public function salvar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("INSERT INTO postagem (titulo, descricao, imagem, data, id_usuario, id_categoria) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $this->titulo, $this->descricao, $this->imagem, $this->data, $this->id_usuario, $this->id_categoria);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Listar todos os projetos
  public static function listar($id_categoria = null) {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    if ($id_categoria) {
        $stmt = $conn->prepare("SELECT * FROM postagem WHERE id_categoria = ? ORDER BY id_postagem DESC");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM postagem ORDER BY id_postagem DESC");
    }

    $projetos = [];
    while ($row = $result->fetch_assoc()) {
        $projetos[] = $row;
    }

    return $projetos;
    }


    // Buscar projeto por ID
    public static function buscarPorId($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT * FROM postagem WHERE id_postagem = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Atualizar projeto (Exemplo: atualizar apenas título e descrição)
    public function atualizar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("UPDATE postagem SET titulo = ?, descricao = ?, imagem = ?, data = ?, id_usuario = ?, id_categoria = ? WHERE id_postagem = ?");
        $stmt->bind_param("ssssiii", $this->titulo, $this->descricao, $this->imagem, $this->data, $this->id_usuario, $this->id_categoria, $this->id_postagem);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Deletar projeto
    public static function deletar($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("DELETE FROM postagem WHERE id_postagem = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function listarPorUsuario($id_usuario) {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();

    $stmt = $conn->prepare("SELECT * FROM postagem WHERE id_usuario = ? ORDER BY id_postagem DESC");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $projetos = [];
    while ($row = $result->fetch_assoc()) {
        $projetos[] = $row;
    }

    return $projetos;
}

}
?>
