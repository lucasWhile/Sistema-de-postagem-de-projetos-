<?php
include_once __DIR__ . '/../conexao/banco.php';
class Image {
    private $id_imagem;
    private $nome;
    private $id_postagem;

    public function __construct($nome, $id_postagem) {
        $this->nome = $nome;
        $this->id_postagem = $id_postagem;
    }

    public function getIdImagem() {
        return $this->id_imagem;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getIdPostagem() {
        return $this->id_postagem;
    }


    

  public function salvar() {
    try {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $sql = "INSERT INTO image (nome, id_postagem) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Erro no prepare: " . $conn->error);
        }

        // "si" = string, int
        $stmt->bind_param("si", $this->nome, $this->id_postagem);

        $resultado = $stmt->execute();

        $stmt->close();
        $conexao->closeConnection();

        return $resultado;
    } catch (Exception $e) {
        error_log("Erro ao salvar imagem: " . $e->getMessage());
        return false;
    }
}



}

?>