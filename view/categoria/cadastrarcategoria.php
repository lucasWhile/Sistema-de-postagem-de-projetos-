<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .card-categoria {
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        .btn-group-custom button {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<?php
include_once '../../model/Categoria.php';
$categorias = Categoria::listar();
?>

<div class="container mt-5">
    <div class="form-card">
        <h2 class="mb-4">Cadastro de Categoria</h2>

        <?php
        if (isset($_GET['msg'])) {
            $mensagem = htmlspecialchars($_GET['msg']);
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    $mensagem
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

        <form action="../../controller/categoriaController/cadastroCategoria.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome da categoria" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar Categoria</button>
        </form>
    </div>

    <!-- Listagem de Categorias -->
    <div class="mt-5">
        <h3>Categorias Cadastradas</h3>
        <div class="row g-3">

            <?php if (!empty($categorias)) : ?>
                <?php foreach ($categorias as $categoria) : ?>
                    <div class="col-12 col-md-4">
                        <div class="card card-categoria">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($categoria['nome']); ?></h5>
                               

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="../../view/categoria/editarcategoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="btn btn-warning">Editar</a>
                                    <a href="../../controller/categoriaController/deletarCategoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar esta categoria?');">Apagar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Nenhuma categoria cadastrada.</p>
            <?php endif; ?>

        </div>

        <!-- Botão Voltar -->
        <div class="mt-4">
            <a href="../../view/index.php" class="btn btn-secondary w-100">Voltar</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
