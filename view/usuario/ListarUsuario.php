<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-table {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        .table thead th {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<div class="container container-table">
    <h2 class="mb-4 text-center">Lista de Usuários</h2>


    <?php
    include_once '../../model/Usuario.php';
    $usuarios = Usuario::buscarTodos();
    if (isset($_GET['msg'])) {
        $mensagem = htmlspecialchars($_GET['msg']);
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                $mensagem
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }

    if (count($usuarios) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nível</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td><?= htmlspecialchars($usuario['nivel']) ?></td>
                            <td class="text-center">
                                <a href="EditarUsuario.php?id=<?= urlencode($usuario['id_usuario']) ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                <a href="../../controller/usuarioController/deletarUsuario.php?id=<?= urlencode($usuario['id_usuario']) ?>" class="btn btn-sm btn-danger" onclick="return confirmarExclusao('<?= addslashes($usuario['nome']) ?>')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Nenhum usuário encontrado.</div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="cadastroUsuario.php" class="btn btn-success">Cadastrar Novo Usuário</a>
        <a href="../index.php" class="btn btn-secondary ms-2">Voltar</a>
    </div>
</div>

<script>
    function confirmarExclusao(nome) {
        return confirm('Tem certeza que deseja excluir o usuário "' + nome + '"? Esta ação não poderá ser desfeita.');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
