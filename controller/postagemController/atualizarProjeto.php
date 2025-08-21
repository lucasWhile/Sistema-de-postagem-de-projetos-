<?php
include_once '../../model/Projeto.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_postagem = intval($_POST['id_postagem']);
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $id_categoria = intval($_POST['id_categoria']);
    $id_usuario = $_SESSION['id_usuario'];
    $data = date('Y-m-d'); 

    // Colete os IDs das imagens que DEVEM SER REMOVIDAS
    $idsRemover = $_POST['remover_imagens'] ?? [];

    // Trate o upload das novas imagens e colete seus nomes
    $novasImagens = [];
    if (!empty($_FILES['imagens']['name'][0])) {
        foreach ($_FILES['imagens']['name'] as $index => $nomeArquivo) {
            if ($_FILES['imagens']['error'][$index] === UPLOAD_ERR_OK) {
                $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
                $novoNome = uniqid() . '.' . $extensao;
                $caminhoDestino = '../../uploads/' . $novoNome;

                if (!is_dir('../../uploads/')) {
                    mkdir('../../uploads/', 0777, true);
                }

                move_uploaded_file($_FILES['imagens']['tmp_name'][$index], $caminhoDestino);
                $novasImagens[] = ['nome' => $novoNome];
            }
        }
    }

    // Crie o objeto do projeto
$projeto = new Projeto($titulo, $descricao, $data, $id_usuario, $id_categoria, $id_postagem);

    // Chame o método de atualização com os IDs a remover e as novas imagens
    if ($projeto->atualizarComImagens($idsRemover, $novasImagens)) {
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