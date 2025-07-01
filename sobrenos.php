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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sobre Nós</title>
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--CSS e Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="sobrenos.css" />
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

    <div>
        <h2>Sobre Nós</h2>
        <p>A UniFit é uma academia moderna e completa, dedicada a promover saúde e bem-estar. Desde a nossa inauguração em 2020, temos como missão ajudar nossos alunos a alcançarem seus objetivos fitness de maneira saudável e eficaz.</p>
        
        <h2>Nossos Valores</h2>
        <p>Na UniFit, acreditamos que cada pessoa é única. Por isso, oferecemos:</p>
        <ul>
            <li>Treinamento personalizado</li>
            <li>Aulas variadas para todos os níveis</li>
            <li>Ambiente acolhedor e motivador</li>
            <li>Equipe de profissionais qualificados</li>
        </ul>

        <h2>Nossas Instalações</h2>
        <p>Contamos com uma infraestrutura moderna, incluindo:</p>
        <ul>
            <li>Equipamentos de última geração</li>
            <li>Salas de aula climatizadas</li>
            <li>Área de musculação ampla</li>
            <li>Piscina para atividades aquáticas</li>
        </ul>

        <h2>Junte-se a Nós!</h2>
        <p>Venha fazer parte da família UniFit e comece a sua jornada de transformação hoje mesmo. Estamos prontos para te ajudar a conquistar seus objetivos!</p>
    </div>
</body>
</html>
