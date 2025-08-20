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
$id = $_GET['id'];
$categorias = Categoria::buscarPorId($id);
?>

<div class="container mt-5">
    <div class="form-card">
        <h2 class="mb-4">Editar Categoria</h2>

        <?php
        if (isset($_GET['msg'])) {
            $mensagem = htmlspecialchars($_GET['msg']);
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    $mensagem
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

        <form action="../../controller/categoriaController/atualizarCategoria.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome da categoria" required value="<?php echo htmlspecialchars($categorias['nome']); ?>">
            </div>

            <input type="hidden" name="id_categoria" value="<?php echo htmlspecialchars($categorias['id_categoria']); ?>">

            <button type="submit" class="btn btn-success w-100 mb-2">Salvar Edição</button>
        </form>

        <!-- Botão Voltar -->
        <a href="cadastrarCategoria.php" class="btn btn-secondary w-100">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
