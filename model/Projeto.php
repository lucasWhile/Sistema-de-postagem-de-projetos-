<?php
include_once __DIR__ . '/../conexao/banco.php';

class Projeto {
    public $id_postagem;
    public $titulo;
    public $descricao;
    public $data;
    public $id_usuario;
    public $id_categoria;

    // Construtor
    public function __construct($titulo, $descricao, $data, $id_usuario, $id_categoria, $id_postagem = null) {
        $this->id_postagem = $id_postagem;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->data = $data;
        $this->id_usuario = $id_usuario;
        $this->id_categoria = $id_categoria;
    }

    // Salvar projeto
    public function salvar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("INSERT INTO postagem (titulo, descricao, data, id_usuario, id_categoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $this->titulo, $this->descricao, $this->data, $this->id_usuario, $this->id_categoria);

        if ($stmt->execute()) {
            $this->id_postagem = $conn->insert_id;
            $stmt->close();
            $conexao->closeConnection();
            return $this->id_postagem;
        } else {
            $stmt->close();
            $conexao->closeConnection();
            return false;
        }
    }

    // Atualizar projeto
    public function atualizar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("UPDATE postagem SET titulo = ?, descricao = ?, data = ?, id_usuario = ?, id_categoria = ? WHERE id_postagem = ?");
        $stmt->bind_param("sssiii", $this->titulo, $this->descricao, $this->data, $this->id_usuario, $this->id_categoria, $this->id_postagem);

        $resultado = $stmt->execute();
        $stmt->close();
        $conexao->closeConnection();
        return $resultado;
    }

    // Deletar projeto
    public static function deletar($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        // Deleta imagens relacionadas
        $stmtImg = $conn->prepare("DELETE FROM imagem WHERE id_postagem = ?");
        $stmtImg->bind_param("i", $id);
        $stmtImg->execute();
        $stmtImg->close();

        $stmt = $conn->prepare("DELETE FROM postagem WHERE id_postagem = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        $stmt->close();
        $conexao->closeConnection();
        return $resultado;
    }

    // Listar projetos
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
            // Buscar imagens relacionadas
            $stmtImg = $conn->prepare("SELECT * FROM image WHERE id_postagem = ?");
            $stmtImg->bind_param("i", $row['id_postagem']);
            $stmtImg->execute();
            $resultImg = $stmtImg->get_result();

            $imagens = [];
            while ($img = $resultImg->fetch_assoc()) {
                $imagens[] = $img;
            }

            $row['imagens'] = $imagens;
            $projetos[] = $row;

            $stmtImg->close();
        }

        $conexao->closeConnection();
        return $projetos;
    }

    // Listar projetos de um usuário específico
    public static function listarPorUsuario($id_usuario) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT * FROM postagem WHERE id_usuario = ? ORDER BY id_postagem DESC");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        $projetos = [];
        while ($row = $result->fetch_assoc()) {
            $stmtImg = $conn->prepare("SELECT * FROM imagem WHERE id_postagem = ?");
            $stmtImg->bind_param("i", $row['id_postagem']);
            $stmtImg->execute();
            $resultImg = $stmtImg->get_result();

            $imagens = [];
            while ($img = $resultImg->fetch_assoc()) {
                $imagens[] = $img;
            }

            $row['imagens'] = $imagens;
            $projetos[] = $row;

            $stmtImg->close();
        }

        $conexao->closeConnection();
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
        $projeto = $result->fetch_assoc();

        if ($projeto) {
            $stmtImg = $conn->prepare("SELECT * FROM imagem WHERE id_postagem = ?");
            $stmtImg->bind_param("i", $id);
            $stmtImg->execute();
            $resultImg = $stmtImg->get_result();

            $imagens = [];
            while ($img = $resultImg->fetch_assoc()) {
                $imagens[] = $img;
            }
            $projeto['imagens'] = $imagens;
            $stmtImg->close();
        }

        $stmt->close();
        $conexao->closeConnection();
        return $projeto;
    }
}
?>
