<?php
include_once '../../model/Projeto.php';
include_once '../../model/Image.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $id_categoria = $_POST['id_categoria'];
    $id_usuario = $_SESSION['id_usuario'];
    $data = date('Y-m-d');

    // Cria o projeto
    $projeto = new Projeto($titulo, $descricao, $data, $id_usuario, $id_categoria);

    if ($id_postagem = $projeto->salvar()) { // salvar() retorna o ID do projeto
        // Agora processa múltiplas imagens
        if (isset($_FILES['imagens']) && count($_FILES['imagens']['name']) > 0) {
            for ($i = 0; $i < count($_FILES['imagens']['name']); $i++) {
                if ($_FILES['imagens']['error'][$i] === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($_FILES['imagens']['name'][$i], PATHINFO_EXTENSION);
                    $imagemNome = uniqid() . '.' . $extensao;
                    $caminhoDestino = '../../uploads/' . $imagemNome;

                    if (!is_dir('../../uploads/')) {
                        mkdir('../../uploads/', 0777, true);
                    }

                    move_uploaded_file($_FILES['imagens']['tmp_name'][$i], $caminhoDestino);

                    // Agora usa o model Image para salvar no banco
                    $image = new Image($imagemNome, $id_postagem);
                    $image->salvar();
                }
            }
        }

        header("Location: ../../view/postagem/postarProjeto.php?msg=Projeto cadastrado com sucesso!");
        exit;
    } else {
        header("Location: ../../view/projeto/postarProjeto.php?msg=Erro ao salvar o projeto.");
        exit;
    }
}

?>
