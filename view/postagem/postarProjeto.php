<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Projeto</title>
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
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-card">
        <h2 class="mb-4 text-center">Cadastro de Projeto</h2>

        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-success">'.htmlspecialchars($_GET['msg']).'</div>';
        }
        ?>

        <form action="../../controller/postagemController/cadastroprojeto.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Projeto</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Digite a descrição" required></textarea>
            </div>

            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoria</label>
                <select class="form-select" id="id_categoria" name="id_categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    include_once '../../model/Categoria.php';
                     if (!Categoria::existeCategoria()) {
                        header("Location:../categoria/cadastrarcategoria.php?msg=Você precisa cadastrar uma categoria antes de criar projetos.");
                        exit;
                    }
                    $categorias = Categoria::listar();
                    foreach ($categorias as $categoria) {
                        echo '<option value="'.$categoria['id_categoria'].'">'.htmlspecialchars($categoria['nome']).'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Projeto</label>
                <input class="form-control" type="file" id="imagem" name="imagem" accept="image/*" onchange="previewImagem()" required>
                <img id="preview-img" src="#" alt="Pré-visualização da imagem">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Salvar Projeto</button>

        </form>

        <!-- Botão Voltar -->
        <a href="../../view/index.php" class="btn btn-secondary w-100">Voltar</a>

    </div>
</div>

<script>
    function previewImagem() {
        const input = document.getElementById('imagem');
        const preview = document.getElementById('preview-img');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
