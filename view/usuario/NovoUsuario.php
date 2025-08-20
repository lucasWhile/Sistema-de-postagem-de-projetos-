<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
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

        <h2 class="form-title mb-4 text-center">Cadastro de Usuário</h2>

        <?php
        if (isset($_GET['msg'])) {
            $mensagem = htmlspecialchars($_GET['msg']);
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    $mensagem
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

        <form action="../../controller/usuarioController/cadastroUsuario.php" method="GET">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="mb-3">
                <label for="nivel" class="form-label">Nível</label>
                <select class="form-select" id="nivel" name="nivel" required>
                    <option value="">Selecione o nível</option>
                    <option value="administrador">Administrador</option>
                    <option value="professor">Professor</option>
                    <option value="convidado">Convidado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>

        <div class="mt-3">
            <a href="../index.php" class="btn btn-secondary w-100">Sair</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
