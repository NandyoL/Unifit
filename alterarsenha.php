<?php

session_start();
include 'conexao.php';
include 'registralog.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['usuario']['id'];
$mensagem = "";

if ($_POST) {
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($nova_senha === $confirma_senha) {
        $novaSenhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$novaSenhaHash, $id]);

        registrarLog($pdo, $id, $_SESSION['usuario']['nome'], 'Alteração de Senha', 'Usuário alterou sua senha');

        $mensagem = "<p style='color: green;'>Senha alterada com sucesso! Redirecionando...</p>";
        header("refresh:3;url=index.php");
    } else {
        $mensagem = "<p style='color: red;'>As senhas não são iguais!</p>";
    }
}
?> 