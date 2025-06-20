<?php
include_once '../../model/Usuario.php';
 $nome=$_GET['nome'];
 $email=$_GET['email'];
 $senha=sha1($_GET['senha']);
 $nivel=$_GET['nivel'];


$usuario = new Usuario($nome, $email, $senha, $nivel);

if ($usuario->salvar()) {
    header("Location: ../../view/usuario/NovoUsuario.php?msg=Usuário cadastrado com sucesso!");
    exit();
} else {
    echo "Erro ao cadastrar usuário.";
}


?>