<?php
include_once '../../model/Categoria.php';

$id = intval($_GET['id']);

if (Categoria::temProjetosVinculados($id)) {
    header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Erro: Esta categoria possui projetos vinculados. Exclua ou mova os projetos antes de apagar a categoria.");
    exit;
}

if (Categoria::excluir($id)) {
    header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Categoria excluída com sucesso!");
} else {
    header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Erro ao excluir a categoria.");
}
?>
