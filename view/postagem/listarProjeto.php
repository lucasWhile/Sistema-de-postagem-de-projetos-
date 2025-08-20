<?php
include_once '../../model/Projeto.php';
include_once '../../model/Categoria.php';

session_start();
// Verifica se o usuário está logado


if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'professor' ) {
  $projetos = Projeto::listarPorUsuario(($_SESSION['id_usuario']));
}
else if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'administrador' ){
    $projetos = Projeto::listar(); 
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Projetos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-responsive {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Lista de Projetos</h2>

    <?php
    if (isset($_GET['msg'])) {
        echo '<div class="alert alert-success">'.htmlspecialchars($_GET['msg']).'</div>';
    }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projetos)) : ?>
                    <?php foreach ($projetos as $projeto) : ?>
                        <tr>
                            <td><?php echo $projeto['id_postagem']; ?></td>
                            <td><?php echo htmlspecialchars($projeto['titulo']); ?></td>
                            <td><?php echo $projeto['id_categoria']; // Pode fazer join se quiser o nome da categoria ?></td>
                            <td><?php echo date('d/m/Y', strtotime($projeto['data'])); ?></td>
                            <td>
                                <?php if (!empty($projeto['imagem'])) : ?>
                                    <img src="../../uploads/<?php echo $projeto['imagem']; ?>" alt="Imagem" style="width: 80px; height: auto;">
                                <?php else : ?>
                                    Sem imagem
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="editarProjeto.php?id=<?php echo $projeto['id_postagem']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="../../controller/postagemController/deletarProjeto.php?id=<?php echo $projeto['id_postagem']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este projeto?');">Excluir</a>
                                <a href="visualizarProjeto.php?id=<?php echo $projeto['id_postagem']; ?>" class="btn btn-sm btn-primary">Visualizar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">Nenhum projeto cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="../../view/index.php" class="btn btn-secondary mt-3">Voltar ao Início</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
