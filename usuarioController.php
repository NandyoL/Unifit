<?php
// usuarioController.php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'alterarSenha') {
    $senhaAtual = $_POST['senhaAtual'] ?? '';
    $novaSenha = $_POST['novaSenha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';

    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php?erro=notlogged");
        exit;
    }

    $usuario = $_SESSION['usuario'];
    $idUsuario = $usuario['id'];

    $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE id = ?");
    $stmt->execute([$idUsuario]);
    $hash = $stmt->fetchColumn();

    if (!password_verify($senhaAtual, $hash)) {
        header("Location: index.php?erro=senha_incorreta");
        exit;
    }

    if (strlen($novaSenha) !== 8 || $novaSenha !== $confirmarSenha) {
        header("Location: index.php?erro=validacao_senha");
        exit;
    }

    $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmt->execute([$novaHash, $idUsuario]);

    header("Location: index.php?msg=senha_alterada");
    exit;
}
?>