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
        <a class="navbar-brand" href="index.php">WorkShow</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Início</a></li>
        

            
                    <?php
                    if(isset($_SESSION['nivel']) && $_SESSION['nivel']=='administrador' ) {  ?>
                        
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Opções Usuários</a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="../view/usuario/NovoUsuario.php">Cadastrar Usuários</a></li>
                             <li><a class="dropdown-item" href="../view/usuario/ListarUsuario.php">Listar Usuários</a></li>
                        </ul>
                     </li>     

                    <?php   } 
                    ?>


                     <?php
                 if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'professor' || $_SESSION['nivel'] == 'administrador')) {  ?>

                  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Opções Projetos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../view/postagem/postarProjeto.php">Cadastrar Projetos</a></li>
                            <li><a class="dropdown-item" href="../view/postagem/listarProjeto.php">Listar Projetos</a></li>
            
                        </ul>
                 </li>

                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Opções Categorias</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../view/categoria/cadastrarcategoria.php">Cadastrar Categoria</a></li>
                    </ul>
                </li>

                  <?php   } 
                ?>


         

                <?php if (isset($_SESSION['id_usuario'])) { ?>
                    <li class="nav-item"><a class="nav-link" href="../controller/usuarioController/logoutUsuario.php">Sair</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="../view/usuario/LogarUsuario.php">Entrar</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<?php
if (isset($_GET['msg'])) {
    $mensagem = htmlspecialchars($_GET['msg']);
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
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



       <div class="col-12 col-md-3 mb-3">
    <div class="sidebar">
        <?php
        include_once '../model/Categoria.php';
        $categorias = Categoria::listar();

        $categoriaSelecionada = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : null;

        // Definindo o texto do botão principal
        $nomeCategoriaSelecionada = "Categorias";
        if (!is_null($categoriaSelecionada)) {
            foreach ($categorias as $categoria) {
                if ($categoria['id_categoria'] == $categoriaSelecionada) {
                    $nomeCategoriaSelecionada = htmlspecialchars($categoria['nome']);
                    break;
                }
            }
        }

        // Classe para o link "Ver Todos"
        $classeTodos = is_null($categoriaSelecionada) ? 'active' : '';
        ?>

        <h5>
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#menuLateral" aria-expanded="false" aria-controls="menuLateral">
                <?php echo $nomeCategoriaSelecionada; ?>
            </button>
        </h5>

        <div class="collapse d-md-block" id="menuLateral">
            <div class="list-group mt-2">
                <a href="index.php" class="list-group-item list-group-item-action <?php echo $classeTodos; ?>">
                    Ver Todos
                </a>

                <?php
                if (!empty($categorias)) {
                    foreach ($categorias as $categoria) {
                        $classeAtiva = ($categoriaSelecionada == $categoria['id_categoria']) ? 'active' : '';
                        ?>
                        <a href="index.php?id_categoria=<?php echo $categoria['id_categoria']; ?>" class="list-group-item list-group-item-action <?php echo $classeAtiva; ?>">
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


        <!-- Área de Projetos -->
        <div class="col-12 col-md-9">
            <div class="row g-3">

                <?php
                include_once '../model/Projeto.php';
                $id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : null;
                $projetos = Projeto::listar($id_categoria);

                if (!empty($projetos)) {
                    foreach ($projetos as $projeto) { ?>
                        <div class="col-12 col-sm-6">
                            <div class="card h-100">
                                <?php if (!empty($projeto['imagem'])) : ?>
                                    <img src="../uploads/<?php echo $projeto['imagem']; ?>" class="card-img-top" alt="Imagem do Projeto">
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="Imagem Padrão">
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($projeto['titulo']); ?></h5>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>
                                    <a href="../view/postagem/visualizarProjeto.php?id=<?php echo $projeto['id_postagem']; ?>" class="btn btn-outline-primary">Ver Mais</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo '<p>Nenhum projeto cadastrado nesta categoria.</p>';
                }
                ?>

            </div>
        </div>

    </div>
</div>

<!-- Rodapé -->
<footer>
    <div class="container text-center">
        <p>&copy; 2025 WorkShow. Todos os direitos reservados.</p>
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
