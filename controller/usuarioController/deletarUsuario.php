<?php
include_once '../../model/Usuario.php';

// Verifica se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $resultado = Usuario::excluir($id);

    if ($resultado) {
        header('Location: ../../view/usuario/listarUsuario.php?msg=Usuário excluído com sucesso');
        exit;
    } else {
        header('Location: ../../view/usuario/listarUsuario.php?msg=Erro ao excluir o usuário');
        exit;
    }
} else {
    header('Location: ../../view/usuario/listarUsuario.php?msg=ID do usuário não informado');
    exit;
}
?>
