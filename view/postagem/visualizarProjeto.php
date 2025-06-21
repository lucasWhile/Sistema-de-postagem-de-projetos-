<?php
include_once '../../model/Projeto.php';
include_once '../../model/Categoria.php';
include_once '../../model/Usuario.php';

// Verificar se veio o ID do projeto
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

// Buscar nome da categoria
$categoria = Categoria::buscarPorId($projeto['id_categoria']);
$nomeCategoria = $categoria ? $categoria['nome'] : 'Sem categoria';

// Buscar nome do usuário
$usuario = Usuario::buscarPorId($projeto['id_usuario']);
$nomeUsuario = $usuario ? $usuario['nome'] : 'Autor não informado';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($projeto['titulo']); ?> - WorkShow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .projeto-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 40px auto;
        }
        .projeto-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="projeto-card">
        <h2 class="mb-4 text-center"><?php echo htmlspecialchars($projeto['titulo']); ?></h2>

        <?php if (!empty($projeto['imagem'])) : ?>
            <img src="../../uploads/<?php echo $projeto['imagem']; ?>" alt="Imagem do Projeto" class="projeto-img">
        <?php endif; ?>

        <p><strong>Descrição:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>

        <hr>

        <p><strong>Categoria:</strong> <?php echo htmlspecialchars($nomeCategoria); ?></p>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($nomeUsuario); ?></p>
        <p><strong>Publicado em:</strong> <?php echo date('d/m/Y', strtotime($projeto['data'])); ?></p>

        <div class="mt-4 text-center">
            <a href="../index.php" class="btn btn-secondary">← Voltar para os Projetos</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
