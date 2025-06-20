<?php
include_once __DIR__ . '/../conexao/banco.php';
class Usuario 
{
    private $nome;
    private $email;
    private $senha;
    private $nivel;

    public function __construct($nome, $email, $senha, $nivel) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->nivel = $nivel;
    }
    public function salvar() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->nome, $this->email, $this->senha, $this->nivel);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function buscarTodos() {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $result = $conn->query("SELECT * FROM usuarios");
        $usuarios = [];

        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    public static function buscarPorId($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public static function atualizarComSenha($id, $nome, $email, $senha, $nivel) {
    // Exemplo usando PDO
    $conexao = new Conexao();
    $conn = $conexao->getConnection();
    $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, nivel = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    return $stmt->execute([$nome, $email, $senhaHash, $nivel, $id]);
}

public static function atualizarSemSenha($id, $nome, $email, $nivel) {
    $conexao = new Conexao();
    $conn = $conexao->getConnection();
    $sql = "UPDATE usuarios SET nome = ?, email = ?, nivel = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$nome, $email, $nivel, $id]);
}

    public static function excluir($id) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public static function login($email, $senha) {
        $conexao = new Conexao();
        $conn = $conexao->getConnection();

        $senhaSha1 = sha1($senha); // Criptografa a senha informada

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
        $stmt->bind_param("ss", $email, $senhaSha1);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            return $usuario; // Login OK - Retorna os dados do usuário
        } else {
            return false; // Login inválido
        }
    }

    public static function logout () {
        session_start();
        session_unset(); // Limpa todas as variáveis de sessão
        session_destroy(); // Destroi a sessão
      
    }

    




    
}

?>