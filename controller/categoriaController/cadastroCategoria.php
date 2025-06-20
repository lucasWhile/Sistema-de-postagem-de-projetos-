<?php

include_once '../../model/Categoria.php';
include_once '../../conexao/banco.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $data = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['id_usuario'];


    // Cria uma nova instância de Categoria
    $categoria = new Categoria($nome, $data, $id_usuario);

    // Salva a categoria no banco de dados
    if ($categoria->salvar()) {
        header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Categoria cadastrada com sucesso");
        exit();
    } else {
        header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Erro ao cadastrar categoria");
        exit();
    }
}
?>