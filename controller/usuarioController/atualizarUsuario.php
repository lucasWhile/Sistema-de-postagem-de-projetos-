<?php
include_once '../../model/Usuario.php';

// Verifica se os campos obrigatórios foram enviados
if (isset($_POST['id_usuario'], $_POST['nome'], $_POST['email'], $_POST['nivel'])) {
    $id = intval($_POST['id_usuario']);
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $nivel = trim($_POST['nivel']);
    $senha = isset($_POST['senha']) ? sha1(trim($_POST['senha'])) : '';

    // Se o campo senha estiver vazio, significa que o usuário quer manter a senha atual
    if ($senha === '') {
        $atualizacao = Usuario::atualizarSemSenha($id, $nome, $email, $nivel);
    } else {
        // Atualiza incluindo a nova senha
        $atualizacao = Usuario::atualizarComSenha($id, $nome, $email, $senha, $nivel);
    }

    if ($atualizacao) {
    header('Location: ../../view/usuario/editarUsuario.php?id=' . $id . '&msg=Usuário atualizado com sucesso');
        exit;
    } else {
        header('Location: ../../view/usuario/editarUsuario.php?id=' . $id . '&msg=Erro ao atualizar o usuário');
        exit;
    }
} else {
    header('Location: ../../view/usuario/listarUsuarios.php?msg=Dados incompletos para atualização');
    exit;
}
?>
