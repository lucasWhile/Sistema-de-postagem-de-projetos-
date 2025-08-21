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
        .preview-img {
            max-width: 100%;
            max-height: 250px;
            margin-top: 10px;
            display: block;
            border-radius: 8px;
        }
        .input-group img {
            max-width: 120px;
            max-height: 120px;
            margin-top: 8px;
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

            <!-- Upload de várias imagens -->
          <!-- Upload de várias imagens -->
<div class="mb-3">
    <label class="form-label">Imagens do Projeto</label>
    <div id="image-container" class="row g-3">
        <!-- Um campo inicial -->
        <div class="col-6 col-md-4">
            <div class="card shadow-sm text-center p-2 position-relative">
                <input type="file" name="imagens[]" accept="image/*" class="form-control d-none" onchange="previewImagem(this)">
                <div class="preview-box d-flex align-items-center justify-content-center" style="height:120px; background:#f1f1f1; border-radius:8px; cursor:pointer;" onclick="this.previousElementSibling.click()">
                    <span class="text-muted">Escolher imagem</span>
                </div>
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" onclick="removerCampo(this)" title="Remover imagem">×</button>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-success mt-3" onclick="adicionarCampo()">+ Adicionar Imagem</button>
</div>


            <button type="submit" class="btn btn-primary w-100 mb-2">Salvar Projeto</button>
        </form>

        <!-- Botão Voltar -->
        <a href="../../view/index.php" class="btn btn-secondary w-100">Voltar</a>

    </div>
</div>

<script>
function adicionarCampo() {
    const container = document.getElementById("image-container");

    const col = document.createElement("div");
    col.classList.add("col-6", "col-md-4");

    col.innerHTML = `
        <div class="card shadow-sm text-center p-2 position-relative">
            <input type="file" name="imagens[]" accept="image/*" class="form-control d-none" onchange="previewImagem(this)">
            <div class="preview-box d-flex align-items-center justify-content-center" style="height:120px; background:#f1f1f1; border-radius:8px; cursor:pointer;" onclick="this.previousElementSibling.click()">
                <span class="text-muted">Escolher imagem</span>
            </div>
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" onclick="removerCampo(this)" title="Remover imagem">×</button>
        </div>
    `;

    container.appendChild(col);
}

function removerCampo(button) {
    button.closest(".col-6").remove();
}

function previewImagem(input) {
    const previewBox = input.nextElementSibling;
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewBox.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:120px; object-fit:cover;">`;
        };
        reader.readAsDataURL(file);
    } else {
        previewBox.innerHTML = `<span class="text-muted">Escolher imagem</span>`;
    }
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
