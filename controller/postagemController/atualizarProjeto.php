<?php
include_once '../../model/Projeto.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_postagem = intval($_POST['id_postagem']);
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $id_categoria = intval($_POST['id_categoria']);
    $data = date('Y-m-d');  // Atualiza a data para a data atual
    $id_usuario =  $_SESSION['id_usuario'];; // Ajuste se quiser pegar o id_usuario da sessão futuramente

    // Buscar o projeto atual para manter a imagem antiga caso não envie uma nova
    $projetoExistente = Projeto::buscarPorId($id_postagem);

    if (!$projetoExistente) {
        header("Location: ../../view/postagem/listarProjetos.php?msg=Projeto não encontrado.");
        exit;
    }

    // Tratando upload de nova imagem (se o usuário enviou)
    $imagemNome = $projetoExistente['imagem']; // Mantém a imagem antiga por padrão

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagemNome = uniqid() . '.' . $extensao;
        $caminhoDestino = '../../uploads/' . $imagemNome;

        // Cria a pasta se não existir
        if (!is_dir('../../uploads/')) {
            mkdir('../../uploads/', 0777, true);
        }

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino);
    }

    // Criando objeto Projeto para atualização
    $projetoAtualizado = new Projeto($titulo, $descricao, $imagemNome, $data, $id_usuario, $id_categoria, $id_postagem);

    if ($projetoAtualizado->atualizar()) {
        header("Location: ../../view/postagem/listarProjeto.php?msg=Projeto atualizado com sucesso!");
        exit;
    } else {
        header("Location: ../../view/postagem/editarProjeto.php?id=$id_postagem&msg=Erro ao atualizar o projeto.");
        exit;
    }

} else {
    echo "Requisição inválida.";
}
?>
