<?php
include_once '../../model/Projeto.php';
include_once '../../model/Categoria.php';

// Verifica se veio o ID do projeto pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Projeto não encontrado.";
    exit;
}

$id = intval($_GET['id']);
$projeto = Projeto::buscarPorId($id);

if (!$projeto) {
    echo "Projeto não encontrado.";
    exit;
}

// Carregar categorias para o select
$categorias = Categoria::listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Projeto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }
        #preview-img {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-card">
        <h2 class="mb-4 text-center">Editar Projeto</h2>

        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-success">'.htmlspecialchars($_GET['msg']).'</div>';
        }
        ?>

        <form action="../../controller/postagemController/atualizarProjeto.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para o ID -->
            <input type="hidden" name="id_postagem" value="<?php echo $projeto['id_postagem']; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Projeto</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($projeto['descricao']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoria</label>
                <select class="form-select" id="id_categoria" name="id_categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    foreach ($categorias as $categoria) {
                        $selected = ($projeto['id_categoria'] == $categoria['id_categoria']) ? 'selected' : '';
                        echo '<option value="'.$categoria['id_categoria'].'" '.$selected.'>'.htmlspecialchars($categoria['nome']).'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem Atual:</label><br>
                <?php if (!empty($projeto['imagem'])) : ?>
                    <img src="../../uploads/<?php echo $projeto['imagem']; ?>" id="preview-img" alt="Imagem Atual">
                <?php else : ?>
                    <p>Sem imagem cadastrada.</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Alterar Imagem (opcional)</label>
                <input class="form-control" type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success w-100 mb-2">Salvar Alterações</button>
            <a href="../../view/index.php" class="btn btn-secondary w-100">Cancelar / Voltar</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
