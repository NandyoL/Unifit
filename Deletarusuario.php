<?php
session_start();
include 'conexao.php';
include 'registralog.php';
registrarLog($pdo, $_SESSION['usuario']['id'], $_SESSION['usuario']['nome'], 'Exclusão', 'Excluiu o usuário ID ' . $_GET['id']);


$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit;
