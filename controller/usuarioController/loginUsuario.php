<?php
include_once '../../model/Usuario.php'; // Ajuste o caminho conforme seu projeto

$email = $_POST['email'];
$senha = $_POST['senha'];

// Faz o login apenas uma vez e armazena o resultado
$usuario = Usuario::login($email, $senha);

if ($usuario) {
    session_start();
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['nivel'] = $usuario['nivel'];

    echo "Usuário logado com sucesso!";
     header("Location: ../../view/index.php?msg=Logado com sucesso");
} else {
    
     header("Location: ../../view/usuario/LogarUsuario.php?msg=E-mail ou senha inválidos");
}
?>
