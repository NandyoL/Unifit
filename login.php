<?php require_once 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="login.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-color" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">UniFit</a>
        
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro.php">Cadastre-se</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="planos.php">Planos</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="sobrenos.php">Sobre nós</a>
                        </li>
                    </ul>
                </div>
        
                <!-- Dropdown do usuário -->
                <div id="userDropdown" class="dropdown ms-auto" style="display: none;">
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
                        <span id="usuarioLogado"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <li><button class="dropdown-item" id="alterarSenha" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">Alterar Senha</button></li> 
                        <li><button class="dropdown-item" id="logoutBtn">Logout</button></li>
                    </ul>
                </div>
            </div>
        </nav>
        
    </header>

    <main class="flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="box-login">

            <h1 class="title_login"><i class="icon icon-key-1"></i> Login </h1>
    
            <form action="#" method="post" class="form login" id="id_formulario">
    
                <div class="form_field">
                
                    <label for="login__username">
                        <i class="icon icon-user-1"></i>
                        <span class="hidden">Login</span>
                    </label>
                    
                    <input autocomplete="off" id="idLogin" size="30" maxlength="6" type="text" class="form_input" placeholder="Login">
    
                </div>
    
                <div class="form_field">
                
                    <label for="login_password">
    
                        <i class="icon icon-lock"></i>
                        <span class="hidden">Senha</span>
                    
                    </label>
                
                    <input type="password" placeholder="Digite a senha (máx 8 caracteres)" id="idSenha" maxlength="8" class="form_input" placeholder="Senha">
              
                </div>
    
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

    <section id="modalAlterarSenha">
        <div class="modal fade" id="alterarSenhaModal" tabindex="-1" aria-labelledby="alterarSenhaLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="alterarSenhaLabel">Alterar Senha</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="alterarSenhaForm">
                    <div class="mb-3">
                      <label for="senhaAtual" class="form-label">Senha Atual</label>
                      <input type="password" class="form-control" id="senhaAtual" maxlength="8" required>
                    </div>
                    <div class="mb-3">
                      <label for="novaSenha" class="form-label">Nova Senha</label>
                      <input type="password" class="form-control" id="novaSenha" maxlength="8" required>
                    </div>
                    <div class="mb-3">
                      <label for="confirmarSenha" class="form-label">Confirmar Nova Senha</label>
                      <input type="password" class="form-control" id="confirmarSenha" maxlength="8" required>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary" id="salvarSenhaBtn">Salvar</button>
                </div>
              </div>
            </div>
        </div>
    </section>

    <!--Modal de erro-->
    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="erroModalLabel">Mensagem</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p id="MensagemDeErro"></p> <!-- Elemento onde a mensagem de erro será exibida -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
    </div>
  
    <script src="login.js"></script>
    <script src="userLogado.js"></script>
</body>
</html>