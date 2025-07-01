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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>UniFit - Home</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg bg-body-color" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">UniFit</a>
    
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
    </nav> 
</header>

<section id="modalAlterarSenha">
    <div class="modal fade" id="alterarSenhaModal" tabindex="-1" aria-labelledby="alterarSenhaLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="alterarSenhaLabel">Alterar Senha</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="alterarsenha.php" id="alterarSenhaForm" method="POST">
                <div class="mb-3">
                  <label for="novaSenha" class="form-label">Nova Senha</label>
                  <input type="password" class="form-control" name="nova_senha" id="nova_senha" maxlength="8" required>
                </div>
                <div class="mb-3">
                  <label for="confirmarSenha" class="form-label">Confirmar Nova Senha</label>
                  <input type="password" class="form-control" name="confirma_senha" id="confirma_senha" maxlength="8" required>
                </div>
              <?php if (!empty($mensagem)) echo $mensagem; ?>            
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="salvarSenhaBtn">Salvar</button>
            </div>
              </form>
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


<!--CARROSEL -->
<section id="carousel">
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <!-- Slide 1 -->
          <div class="carousel-item active">
              <img src="Imagens/crossfit.jpg" id="crossfit" class="d-block w-100 img-fluid" alt="Primeiro slide">
              <div class="carousel-caption custom-caption">
                  <h2 class="display-4">Transforme-se com <span id="titulo-slide" class="display-4">CROSSFIT</span></h2>
                  <p class="lead">Descubra o poder do treino de alta intensidade.</p>
                  <a href="#atividades" class="btn btn-primary btn-lg">Saiba Mais</a>
              </div>
          </div>
          <!-- Slide 2 -->
          <div class="carousel-item">
              <img src="Imagens/mulheres-treinando.jpg" class="d-block w-100 img-fluid" alt="Segundo slide">
              <div class="carousel-caption custom-caption">
                  <h2 class="display-4">Seja aluno</h2>
                  <span class="h3">UniFit</span>
                  <p id="slide2" class="lead">Aproveite nossos benefícios, descontos exclusivos e parcerias</p>
                  <a href="#gympass" class="btn btn-primary btn-lg">Matricule-se já</a>
              </div>
          </div>
          <!-- Slide 3 -->
          <div class="carousel-item">
              <img src="Imagens/alteres3.jpg" id="alteres3" class="d-block w-100 img-fluid" alt="Terceiro slide">
              <div class="carousel-caption custom-caption">
                  <h2 class="display-4">Treine com segurança e <span id="titulo-slide" class="display-4">eficiência</span></h2>
                  <p id="slide3" class="lead">Maximize seus resultados com treinos personalizados</p>
              </div>
          </div>
      </div>
      <!-- Navegação -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </button>
  </div>
</section>

<!--CARROSEL -->

<main>
  <!--Seção de Atividades-->
    <section class="atividades" id="atividades">
        <div id="titulo-atividades">
            <h6>Serviços</h6>
            <h2>Conheça <br> as nossas <span>atividades</span> </h2>
        </div>
        <div class="cards-container">
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="Imagens/homem-segunrando-haltere.jpg" alt="Aulas de Musculação">
                        <h3>Musculação</h3>
                    </div>
                    <div class="card-back">
                        <p>Treinos personalizados com acompanhamento de profissionais qualificados.</p>
                    </div>
                </div>
            </div>
    
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="Imagens/hl-4126241286-1-852x565.jpg" alt="Treinamento Funcional">
                        <h3>Treinamento Funcional</h3>
                    </div>
                    <div class="card-back">
                        <p>Aumente sua força e resistência com treinos dinâmicos e eficientes.</p>
                    </div>
                </div>
            </div>
    
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="Imagens/crossfit.jpg" alt="CrossFit">
                        <h3>CrossFit</h3>
                    </div>
                    <div class="card-back">
                        <p>Desafios intensos para aumentar seu desempenho físico e mental.</p>
                    </div>
                </div>
            </div>
    
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="Imagens/spinning.jpg" alt="Aulas de Spinning">
                        <h3>Spinning</h3>
                    </div>
                    <div class="card-back">
                        <p>Treinos de ciclismo indoor para queimar calorias de forma divertida.</p>
                    </div>
                </div>
            </div>
        </div>
</section>
    

<!--Seção Sobre Nós-->
<section id="sobre-nos" class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-start">
        <!-- Imagem -->
        <div class="col-md-6">
          <img src="Imagens/academia.avif" class="img-fluid rounded" alt="Imagem da academia">
        </div>
        <!-- Texto -->
        <div class="col-md-6">
          <div>
            <h2 class="mb-3">Sobre Nós</h2>
            <p class="mb-4">
              Nossa academia foi fundada com o objetivo de proporcionar um ambiente saudável e motivador para todos
              que buscam melhorar sua qualidade de vida. Com profissionais experientes e equipamentos modernos,
              oferecemos atividades para todas as idades e níveis de condicionamento.
            </p>
            <a href="sobrenos.php" class="btn btn-primary">Saiba Mais</a>
          </div>
        </div>
      </div>
    </div>
</section>

<!--Seção Gympass-->
<section id="gympass">
    <div class="gympass-container">
        <div class="gympass-info">
          <h2>Parceria Gympass <br>Agora ficou mais fácil ser nosso aluno</h2>
          <div class="gympass-content">
            <ul>
              <li>Acesso a todas as atividades no plano Silver</li>
              <li>Experimente várias modalidades de treino</li>
              <li>Acompanhe seu progresso e atinja seus objetivos</li>
              <li>Saúde e bem-estar ao seu alcance</li>
            </ul>
          </div>
          <div class="gympass-download">
            <span>Baixe o app Gympass agora!</span>
            <div class="gympass-download-links">
              <ul class="gympass-badges">
                <li>
                  <a href="https://play.google.com/store/apps/details?id=com.gympass.app" target="_blank">
                    <img src="Imagens/googleplay.png" id="googlepaly" alt="Google Play">
                  </a>
                </li>
                <li>
                  <a href="https://apps.apple.com/br/app/gympass/id1234567890" target="_blank">
                    <img src="Imagens/applestore.png" id="applestore" alt="App Store">
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="gympass-image">
          <img src="Imagens/gympassapp.png" alt="Gympass App">
        </div>
      </div>
</section>

<!--Seção Matricula-->
<section id="homeCadastroClienteSection" class="section_cta-matricula bg-light">
    <div class="padding-section">
      <div class="cta-matricula-wrapper">
        <div class="cta-matricula-image-wrapper">
          <img src="Imagens/professoracademia.jpg" alt="Comece a Treinar Hoje Mesmo" class="image-cover">
        </div>
        <div class="cta-matricula-content-wrapper">
          <div class="section-title">
            <h5>Pronto para começar sua <span>jornada fitness?</span></h5>
          </div>
          <div class="cta-matricula-benefits">
            <p>Seja nosso aluno e aproveite os benefícios exclusivos:</p>
            <ul>
              <li>Treinamento personalizado</li>
              <li>Acesso a diversas modalidades</li>
              <li>Acompanhamento profissional contínuo</li>
              <li>Ambiente Moderno e Tecnológico</li>  
            </ul>
          </div>
          <a href="cadastro.php" id="botaomatricula" class="btn btn-primary">Matricule-se agora</a>
        </div>
      </div>
    </div>
</section>
</main>

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
                <p><a href="#atividades" class="text-white">Musculação</a></p>
                <p><a href="#atividades" class="text-white">Spinning</a></p>
                <p><a href="#" class="text-white">CrossFit</a></p>
                <p><a href="#atividades" class="text-white">Treinamento Funcional</a></p>
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
<script src="index.js"></script>
</html>
