<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Responsivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        @media (max-width: 767.98px) {
            .sidebar {
                margin-bottom: 1rem;
            }
        }
        footer {
            background-color: #0d6efd;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
        footer a {
            color: #ffffff;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Meu Site</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="../view/usuario/NovoUsuario.php">Opções usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opções usuarios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../view/usuario/NovoUsuario.php">Cadastrar Usuarios</a></li>
                        <li><a class="dropdown-item" href="../view/usuario/ListarUsuario.php">Listar Usuarios</a></li>
                        <li><a class="dropdown-item" href="#">Editar Usuarios</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opções Projetos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../view/postagem/postarProjeto.php">Cadastrar Projetos</a></li>
                        <li><a class="dropdown-item" href="../view/usuario/ListarUsuario.php">Listar Usuarios</a></li>
                        <li><a class="dropdown-item" href="#">Editar Usuarios</a></li>
                    </ul>
                </li>

                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opções Categorias
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../view/categoria/cadastrarcategoria.php">Cadastrar Categoria</a></li>
                        <li><a class="dropdown-item" href="#">Listar Usuarios</a></li>
                        <li><a class="dropdown-item" href="#">Editar Usuarios</a></li>
                    </ul>
                </li>


                <?php 
                if(isset($_SESSION['id_usuario']) ){ ?>
                      <li class="nav-item"><a class="nav-link" href="../controller/usuarioController/logoutUsuario.php">Sair</a></li>
                    <?php } else{?>
                <li class="nav-item"><a class="nav-link" href="../view/usuario/LogarUsuario.php">Entrar</a></li>
                     <?php } ?>
            </ul>

            

        </div>
    </div>
</nav>

  <?php
        if (isset($_GET['msg'])) {
            $mensagem = htmlspecialchars($_GET['msg']);
            echo "<div class='alert alert-sucess alert-dismissible fade show' role='alert'>
                    $mensagem
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    ?>

<!-- Banner -->
<div class="container-fluid p-0 m-0">
    <img src="../imagem/teste.png" class="img-fluid w-100 d-block" alt="Banner do Site">
</div>

<!-- Conteúdo Principal -->
<div class="container mt-4">
    <div class="row">

        <!-- Sidebar -->
 <div class="col-12 col-md-3 mb-3">
    <div class="sidebar">
        <h5>
            <button class="btn btn-primary w-100 " type="button" data-bs-toggle="collapse" data-bs-target="#menuLateral" aria-expanded="false" aria-controls="menuLateral">
                Categorias
            </button>
        </h5>

        <!-- Menu: fechado no mobile / aberto no desktop -->
        <div class="collapse d-md-block" id="menuLateral">
            <div class="list-group mt-2">
                <?php
                include_once '../model/Categoria.php';
                $categorias = Categoria::listar();

            
                    if (!empty($categorias)) {
                        foreach ($categorias as $categoria) { ?>
                            <a href="../../view/categoria/cadastrarCategoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="list-group-item list-group-item-action">
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </a>
                        <?php }
                    } else {
                        echo '<span class="list-group-item">Nenhuma categoria cadastrada.</span>';
                    }
                    ?>


            </div>
        </div>

    </div>
</div>


        <!-- Área de Cards -->
        <div class="col-12 col-md-9">
            <div class="row g-3">

                <div class="col-12 col-sm-6">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="Imagem Card 1">
                        <div class="card-body">
                            <h5 class="card-title">Título do Card 1</h5>
                            <p class="card-text">Descrição breve ou conteúdo resumido do card 1.</p>
                            <a href="#" class="btn btn-outline-primary">Ver Mais</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="Imagem Card 2">
                        <div class="card-body">
                            <h5 class="card-title">Título do Card 2</h5>
                            <p class="card-text">Descrição breve ou conteúdo resumido do card 2.</p>
                            <a href="#" class="btn btn-outline-primary">Ver Mais</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Rodapé -->
<footer>
    <div class="container text-center">
        <p>&copy; 2025 Meu Site. Todos os direitos reservados.</p>
        <p>
            <a href="#">Política de Privacidade</a> | 
            <a href="#">Termos de Uso</a> | 
            <a href="#">Contato</a>
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
