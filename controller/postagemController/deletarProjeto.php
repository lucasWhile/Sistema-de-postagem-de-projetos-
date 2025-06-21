<?php
$id=$_GET['id'];
include_once '../../model/Projeto.php';
if (Projeto::deletar($id)) {
    header("Location: ../../view/postagem/listarProjeto.php?msg=Projeto deletado com sucesso!");
} else {
    header("Location: ../../view/postagem/listarProjeto.php?msg=Erro ao deletar o projeto.");
}

?>