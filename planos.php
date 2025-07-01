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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Links Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>UniFit - Planos</title>
    <link rel="stylesheet" href="planos.css">
</head>
<body>
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

<!--Modal de Alteração de Senha-->
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

  <!--seção de Planos-->  
    <section class="plans">
        <div class="plan">
            <img src="https://saude.sesisc.org.br/wp-content/uploads/sites/13/2023/09/Beneficios-de-fazer-academia-Para-sua-saude-e-seu-corpo-1536x1024.jpg" alt="Plano Básico">
            <h2>Plano Básico</h2>
            <p>Ideal para quem está começando.</p>
            <ul>
                <li>Acesso à academia</li>
                <li>Horário comercial</li>
                <li>Suporte básico</li>
            </ul>
            <button href="">Assine Agora</button>
        </div>
        
        <div class="plan">
            <img src="https://blog.lionfitness.com.br/wp-content/uploads/2018/10/muscula%C3%A7%C3%A3o-benef%C3%ADcios.jpg" alt="Plano Premium">
            <h2>Plano Premium</h2>
            <p>Para treinos mais intensos.</p>
            <ul>
                <li>Acesso ilimitado</li>
                <li>Consultoria de personal trainer</li>
                <li>Suplementação incluída</li>
            </ul>
            <button>Assine Agora</button>
        </div>
        
        <div class="plan">
            <img src="https://img.freepik.com/fotos-gratis/pessoas-malhando-em-ambientes-fechados-com-halteres_23-2149175410.jpg" alt="Plano VIP">
            <h2>Plano VIP</h2>
            <p>Experiência exclusiva de treino.</p>
            <ul>
                <li>Acesso VIP 24/7</li>
                <li>Consultoria avançada</li>
                <li>Aulas exclusivas</li>
            </ul>
            <button>Assine Agora</button>
        </div>
    </section>
<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row align-items-start">
            <div class="col-md-6 col-lg-4">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">UniFit</h5>
                <p>
                    A UniFit é uma academia moderna e completa, dedicada a promover saúde e bem-estar. Desde a nossa inauguração em 2020, temos como missão ajudar nossos alunos a alcançarem seus objetivos fitness de maneira saudável e eficaz.
                </p>
            </div>

            <div class="col-md-3 col-lg-2">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Institucional</h5>
                <p><a href="sobrenos.php" class="text-white">Sobre nós</a></p>
                <p><a href="#" class="text-white">Fale Conosco</a></p>
                <p><a href="#" class="text-white">Cetral de Ajuda</a></p>
                <p><a href="#" class="text-white">Privacidade</a></p>
            </div>

            <div class="col-md-3 col-lg-2">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning ">Atividades</h5>
                <p><a href="#" class="text-white">Musculação</a></p>
                <p><a href="#" class="text-white">Spinning</a></p>
                <p><a href="#" class="text-white">CrossFit</a></p>
                <p><a href="#" class="text-white">Treinamento Funcional</a></p>
            </div>

            <div class="col-md-4 col-lg-4">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning" id="contato">Contatos</h5>
                <p><i class="fas fa-home mr-3"></i> Avenida Paris, 84 - Bonsucesso - RJ</p>
                <p><i class="fas fa-envelope mr-3"></i> contato@unifit.com.br</p>
                <p><i class="fas fa-phone mr-3"></i> (21) 9 9999-9999</p>
                <p><i class="fas fa-phone mr-3"></i> (21) 9 9999-9999</p>
            </div>

            <div class="col-md-12">
                <hr class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <p>&copy; 2024 UniFit. Todos os direitos reservados.
                        </p>
                    </div>

                    <div class="col-md-5">
                        <div class="text-center text-md-right">
                            <ul class="list-unstyled list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-whatsapp"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="userLogado.js"></script>
</html>
