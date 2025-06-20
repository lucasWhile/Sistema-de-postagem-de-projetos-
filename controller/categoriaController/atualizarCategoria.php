<?php
$nome=$_POST['nome'];
$id_categoria=$_POST['id_categoria'];

include_once '../../model/Categoria.php';

Categoria::atualizar($nome,$id_categoria);
header("Location: ../../view/categoria/editarcategoria.php?id=$id_categoria&msg=Categoria atualizada com sucesso");

?>