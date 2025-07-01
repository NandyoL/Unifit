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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Dashboard de Usuários</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                        <a class="nav-link" href="dashboard.php">Tabela de Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logtable.php">Tabela de Logs</a>
                </ul>
            </div>

                <!-- Dropdown do usuário -->
                <?php if ($usuarioLogado): ?>
                <div id="userDropdown" class="dropdown ms-auto">
                    <a 
                        class="btn btn-secondary dropdown-toggle d-flex align-items-center" 
                        href="" 
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
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>           
        </div>
    </nav> 
</header>

    <h2>Usuários Cadastrados</h2>
    
    <div class="botoes-superiores">
    <a href="index.php" class="voltar">Voltar ao Início</a>
    <a href="AdicionarUsuario.php" class="adicionar">Adicionar Novo Usuário</a>
    </div>

    <table>
        <tr>
            <th>ID</th><th>Nome</th><th>Login</th><th>Data de Nascimento</th><th>CPF</th><th>Email</th>
            <th>Celular</th><th>Cidade</th><th>Perfil</th><th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>
            <td data-label='ID'>{$row['id']}</td>
            <td data-label='Nome'>{$row['nome']}</td>
            <td data-label='Login'>{$row['login']}</td>
            <td data-label='Data de nascimento'>{$row['dataNasc']}</td>
            <td data-label='CPF'>{$row['cpf']}</td>
            <td data-label='Email'>{$row['email']}</td>            
            <td data-label='Celular'>{$row['celular']}</td>
            <td data-label='Cidade'>{$row['cidade']}</td>
            <td data-label='Perfil'>{$row['perfil']}</td>
            <td data-label='Ações'>
                <a href='EditarUsuario.php?id={$row['id']}'>Editar</a>
                <a href='DeletarUsuario.php?id={$row['id']}' onclick=\"return confirm('Tem certeza?')\">Excluir</a>
            </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
