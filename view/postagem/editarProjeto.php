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
            max-width: 700px;
            margin: 40px auto;
        }
        .carousel-item img {
            max-height: 300px;
            object-fit: cover;
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background-color: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-weight: bold;
            color: #dc3545;
            cursor: pointer;
            z-index: 10;
        }
        .carousel-item {
            position: relative;
        }
        #novasImagensPreview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .preview-img-container {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .preview-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
        .preview-remove-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-weight: bold;
            color: #dc3545;
            cursor: pointer;
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

        <form action="../../controller/postagemController/atualizarProjeto.php" method="POST" enctype="multipart/form-data" id="formProjeto">
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

            <!-- Carrossel das imagens atuais -->
            <div class="mb-3">
                <label class="form-label">Imagens Atuais:</label>
                <?php if (!empty($projeto['imagens'])): ?>
                    <div id="carousel-<?php echo $projeto['id_postagem']; ?>" class="carousel slide mb-3" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-inner-<?php echo $projeto['id_postagem']; ?>">
                            <?php foreach ($projeto['imagens'] as $index => $img): ?>
                                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>" data-id="<?php echo $img['id_imagem']; ?>">
                                    <img src="../../uploads/<?php echo htmlspecialchars($img['nome']); ?>" class="d-block w-100" alt="Imagem do Projeto">
                                    <?php if(count($projeto['imagens']) > 1): ?>
                                        <button type="button" class="remove-btn" onclick="removerImagemAtual(this, <?php echo $img['id_imagem']; ?>)">×</button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($projeto['imagens']) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $projeto['id_postagem']; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $projeto['id_postagem']; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p>Sem imagens cadastradas.</p>
                <?php endif; ?>
            </div>

            <!-- Campo oculto para IDs das imagens removidas -->
            <input type="hidden" name="remover_imagens[]" id="removerImagens">

            <!-- Upload de novas imagens -->
            <div class="mb-3">
                <label for="imagens" class="form-label">Adicionar Novas Imagens</label>
                <input class="form-control" type="file" id="imagens" name="imagens[]" accept="image/*" multiple onchange="previewNovasImagens(event)">
                <small class="text-muted">Você pode selecionar mais de uma imagem.</small>

                <!-- Preview das novas imagens -->
                <div id="novasImagensPreview"></div>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-2">Salvar Alterações</button>
            <a href="../../view/index.php" class="btn btn-secondary w-100">Cancelar / Voltar</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let imagensRemovidas = [];
    let novasImagens = [];

    function removerImagemAtual(btn, id) {
        const item = btn.closest('.carousel-item');
        const carouselInner = item.parentNode;

        // Garante que sempre reste pelo menos uma imagem
        if(carouselInner.querySelectorAll('.carousel-item').length <= 1){
            alert('É obrigatório manter pelo menos uma imagem!');
            return;
        }

        imagensRemovidas.push(id);
        document.getElementById('removerImagens').value = imagensRemovidas.join(',');

        item.remove();

        // Ativa o primeiro item restante
        const firstItem = carouselInner.querySelector('.carousel-item');
        if(firstItem) firstItem.classList.add('active');
    }

    function previewNovasImagens(event){
        const previewContainer = document.getElementById('novasImagensPreview');
        previewContainer.innerHTML = ''; // Limpa preview antigo
        novasImagens = Array.from(event.target.files); // Armazena arquivos selecionados

        novasImagens.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e){
                const div = document.createElement('div');
                div.classList.add('preview-img-container');

                const img = document.createElement('img');
                img.src = e.target.result;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.classList.add('preview-remove-btn');
                btn.innerHTML = '×';
                btn.onclick = function(){
                    novasImagens.splice(index, 1);
                    div.remove();
                    // Atualiza input do form com novos arquivos
                    atualizarInputFiles();
                }

                div.appendChild(img);
                div.appendChild(btn);
                previewContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
        atualizarInputFiles();
    }

    function atualizarInputFiles(){
        const dataTransfer = new DataTransfer();
        novasImagens.forEach(file => {
            dataTransfer.items.add(file);
        });
        document.getElementById('imagens').files = dataTransfer.files;
    }
</script>
</body>
</html>
