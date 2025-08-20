<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f3f5;
        }
        .form-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .form-title {
            font-weight: bold;
            color: #343a40;
        }
        .btn-primary, .btn-secondary {
            border-radius: 6px;
        }
        .mb-3 label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="form-card">

        <h2 class="form-title mb-4 text-center">Editar Usuário</h2>

        <?php
        include_once '../../model/Usuario.php';

        if (!isset($_GET['id'])) {
            echo '<div class="alert alert-danger">ID do usuário não informado.</div>';
            exit;
        }

        $id = intval($_GET['id']);
        $usuario = Usuario::buscarPorId($id);

        if (!$usuario) {
            echo '<div class="alert alert-danger">Usuário não encontrado.</div>';
            exit;
        }

        if (isset($_GET['msg'])) {
            $mensagem = htmlspecialchars($_GET['msg']);
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    $mensagem
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

        <form action="../../controller/usuarioController/atualizarUsuario.php" method="POST">

            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">
            </div>

            <div class="mb-3">
                <label for="nivel" class="form-label">Nível</label>
                <select class="form-select" id="nivel" name="nivel" required>
                    <option value="">Selecione o nível</option>
                    <option value="Administrador" <?= $usuario['nivel'] == 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="Usuário" <?= $usuario['nivel'] == 'Usuário' ? 'selected' : '' ?>>Usuário</option>
                    <option value="Convidado" <?= $usuario['nivel'] == 'Convidado' ? 'selected' : '' ?>>Convidado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
        </form>

        <div class="mt-3">
            <a href="ListarUsuario.php" class="btn btn-secondary w-100">Voltar à Lista</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
