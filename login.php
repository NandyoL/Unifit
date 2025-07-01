<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
$usuarioLogado = $_SESSION['usuario'] ?? null;
$nomeUsuario = '';

if ($usuarioLogado) {
    $primeiroNome = explode(' ', $usuarioLogado['nome'])[0];
    $nomeUsuario = ucfirst(strtolower($primeiroNome));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="login.css" />
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-color" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">UniFit</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastre-se</a></li>
                        <li class="nav-item"><a class="nav-link" href="planos.php">Planos</a></li>
                        <li class="nav-item"><a class="nav-link" href="sobrenos.php">Sobre nós</a></li>
                    </ul>
                </div>

            <!-- Dropdown do usuário -->
            <?php if ($usuarioLogado): ?>
            <div id="userDropdown" class="dropdown ms-auto">
                <a 
                    class="btn btn-secondary dropdown-toggle d-flex align-items-center" 
                    href="#" 
                    role="button" 
                    id="dropdownUser" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false"
                >
                    <img 
                        src="Imagens/userIcon.webp" 
                        alt="Usuário" 
                        class="rounded-circle me-2" 
                        style="width: 30px; height: 30px;"
                    >
                    <span id="usuarioLogado"><?= htmlspecialchars($nomeUsuario) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">
                            Alterar Senha
                        </button>
                    </li>
                            <?php if ($_SESSION['usuario']['perfil'] === 'ADMIN'): ?>
          <li>
          <a class="dropdown-item" href="dashboard.php">Dashboard</a>
          </li>
        <?php endif; ?> 
                    <li>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
</header>

    <main class="flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="box-login">
            <h1 class="title_login"><i class="icon icon-key-1"></i> Login </h1>

            <form action="validationlogin.php" method="post" class="form login" id="id_formulario">

                <div class="form_field">
                    <label for="idLogin">
                        <i class="icon icon-user-1"></i>
                        <span class="hidden">Login</span>
                    </label>
                    <input name="login" autocomplete="off" id="idLogin" size="30" maxlength="50" type="text" class="form_input" placeholder="Login" required />
                </div>

                <div class="form_field">
                    <label for="idSenha">
                        <i class="icon icon-lock"></i>
                        <span class="hidden">Senha</span>
                    </label>
                    <input name="senha" type="password" id="idSenha" maxlength="50" class="form_input" placeholder="Digite a senha" required />
                </div>

                <?php
                        if (isset($_GET['erro'])) {
                            $mensagem = '';
                            if ($_GET['erro'] === 'campos') {
                                $mensagem = 'Por favor, preencha todos os campos.';
                            } elseif ($_GET['erro'] === 'login') {
                                $mensagem = 'Login ou senha incorretos!';
                            } elseif ($_GET['erro'] === 'banco') {
                                $mensagem = 'Erro ao acessar o banco de dados.';
                            }
                            if ($mensagem) {
                                echo "<div class='alert alert-danger'>$mensagem</div>";
                            }
                        }
                        ?>

                <div class="form_field d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    <button type="reset" class="btn btn-secondary">Limpar</button>
                </div>
            </form>

            <p class="resgatar-senha">
                <!-- <a href="esqueceusenha.html">Esqueci a Senha</a> -->
                <a href="cadastro.php">Ainda não tenho cadastro</a>
            </p>
        </div>
    </main>
 
    <!-- Modal de erro -->
    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="erroModalLabel">Mensagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="MensagemDeErro">
                        
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
