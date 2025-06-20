<?php

include_once '../../model/Categoria.php';
Categoria::excluir($_GET['id']);

 header("Location: ../../view/categoria/cadastrarcategoria.php?msg=Categoria excluída com sucesso");

?>