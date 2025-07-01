<?php
session_start();
include 'conexao.php';

// Verificar se está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Verificar se é ADMIN
if ($_SESSION['usuario']['perfil'] !== 'ADMIN') {
    echo "<script>
        alert('Acesso negado. Você não tem permissão para acessar esta página.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

// Dados do usuário logado
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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <title>Log de Atividades</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-color" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">UniFit</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Tabela de Usuários</a></li>
                    <li class="nav-item"><a class="nav-link active" href="logtable.php">Tabela de Logs</a></li>
                </ul>
            </div>

            <?php if ($usuarioLogado): ?>
            <div id="userDropdown" class="dropdown ms-auto">
                <a class="btn btn-secondary dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="Imagens/userIcon.webp" alt="Usuário" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                    <span><?= htmlspecialchars($nomeUsuario) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>
</header>

<h2>Log de Atividades</h2>

<div class="botoes-superiores">
    <a href="index.php" class="voltar">Voltar ao Início</a>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="adicionar">Atualizar</a>

</div>

<table>
    <tr>
        <th>ID</th><th>ID Usuário</th><th>Nome</th><th>Ação</th><th>Descrição</th><th>IP</th><th>Data/Hora</th>
    </tr>
    <?php
    $sql = "SELECT * FROM log_atividades ORDER BY id DESC";
    foreach ($pdo->query($sql) as $row) {
        echo "<tr>
            <td data-label='ID'>{$row['id']}</td>
            <td data-label='ID Usuário'>{$row['id_usuario']}</td>
            <td data-label='Nome'>{$row['nome_usuario']}</td>
            <td data-label='Ação'>{$row['acao']}</td>
            <td data-label='Descrição'>{$row['descricao']}</td>
            <td data-label='IP'>{$row['ip']}</td>
            <td data-label='Data/Hora'>{$row['data_hora']}</td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
