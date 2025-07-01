<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtem os dados do formulário
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // Valida se campos estão preenchidos
    if (empty($login) || empty($senha)) {
        header("Location: login.php?erro=campos");
    exit;
    }

    try {
        // Consulta o usuário no banco
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login LIMIT 1");
        $stmt->execute([':login' => $login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login e senha corretos
            $_SESSION['usuario'] = [
                'id'    => $usuario['id'],
                'nome'  => $usuario['nome'],
                'login' => $usuario['login'],
                'perfil' => $usuario['perfil']
            ];
            header("refresh:3;url=index.php"); // Redireciona após 3 segundos
            exit;

        } else {
            // Login ou senha incorretos
            header("Location: login.php?erro=login");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: login.php?erro=banco");
        exit;
    }
} else {
    echo "<script>
        document.getElementById('MensagemDeErro').textContent = 'Requisição inválida.';
        let erroModal = new bootstrap.Modal(document.getElementById('erroModal'));
        erroModal.show();
    </script>";
}
?>
