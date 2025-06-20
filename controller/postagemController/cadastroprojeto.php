<?php
include_once '../../model/Projeto.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebendo os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $id_categoria = $_POST['id_categoria'];
    $id_usuario = $_SESSION['id_usuario']; // Aqui você pode trocar para pegar o id_usuario da sessão se quiser
    $data = date('Y-m-d'); // Data atual (ou você pode pegar de um campo oculto se quiser)

    // Tratando o upload da imagem
    $imagemNome = null;

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

    // Criando objeto projeto
    $projeto = new Projeto($titulo, $descricao, $imagemNome, $data, $id_usuario, $id_categoria);

    if ($projeto->salvar()) {
        header("Location: ../../view/postagem/postarProjeto.php?msg=Projeto cadastrado com sucesso!");
        exit;
    } else {
        header("Location: ../../view/projeto/postarProjeto.php?msg=Erro ao salvar o projeto.");
        exit;
    }

} else {
    echo "Método de requisição inválido!";
}
?>
