<?php
include_once '../../model/Usuario.php'; // Ajuste o caminho conforme sua estrutura

Usuario::logout();

echo "Usuário deslogado com sucesso!";
// Ou redirecionamento para página inicial
header("Location: ../../view/index.php?msg=Deslogado com sucesso");
?>
