<?php
session_start();
require_once 'conexao.php';

$mensagem = "";
$erros = [];

function limparTexto($str) {
    return trim(strip_tags($str));
}

// Função para validar CPF com cálculo do dígito verificador
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Guarda dados antigos
    $_SESSION['old'] = $_POST;

    $nome         = limparTexto($_POST['nome'] ?? '');
    $nomeMaterno  = limparTexto($_POST['nomeMaterno'] ?? '');
    $cpf          = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
    $email        = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $dataNasc     = $_POST['dataNasc'] ?? '';
    $telefone     = preg_replace('/[^0-9]/', '', $_POST['telefone'] ?? '');
    $celular      = preg_replace('/[^0-9]/', '', $_POST['celular'] ?? '');
    $cep          = preg_replace('/[^0-9]/', '', $_POST['cep'] ?? '');
    $bairro       = limparTexto($_POST['bairro'] ?? '');
    $cidade       = limparTexto($_POST['cidade'] ?? '');
    $login        = limparTexto($_POST['login'] ?? '');
    $senha        = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';

    // Validações
    if (strlen($nome) < 3) $erros[] = "Nome deve ter pelo menos 3 caracteres.";
    if (empty($nomeMaterno)) $erros[] = "Nome materno é obrigatório.";
    if (!validarCPF($cpf)) $erros[] = "CPF inválido.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido.";
    if (empty($dataNasc) || strtotime($dataNasc) >= time()) $erros[] = "Data de nascimento inválida.";
    if (!empty($telefone) && !is_numeric($telefone)) $erros[] = "Telefone deve conter apenas números.";
    if (strlen($celular) < 8 || !is_numeric($celular)) $erros[] = "Celular inválido.";
    if (strlen($cep) != 8) $erros[] = "CEP deve conter 8 dígitos.";
    if (empty($bairro)) $erros[] = "Bairro é obrigatório.";
    if (empty($cidade)) $erros[] = "Cidade é obrigatória.";
    if (strlen($login) < 5) $erros[] = "Login deve ter pelo menos 5 caracteres.";
    if (strlen($senha) < 6) $erros[] = "Senha deve ter pelo menos 6 caracteres.";
    if ($senha !== $confirmarSenha) $erros[] = "As senhas não coincidem.";

    if (!empty($erros)) {
            $mensagem .= '<div class="alert alert-danger"><ul>';
        foreach ($erros as $erro) {
        $mensagem .= "<li>$erro</li>";
        }
        $mensagem .= '</ul></div>';

        $_SESSION['mensagem'] = $mensagem;
        header("Location: cadastro.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (
                nome, nomeMaterno, cpf, email, dataNasc, telefone, celular, cep, bairro, cidade, login, senha
            ) VALUES (
                :nome, :nomeMaterno, :cpf, :email, :dataNasc, :telefone, :celular, :cep, :bairro, :cidade, :login, :senha
            )
        ");

        $stmt->execute([
            ':nome'         => $nome,
            ':nomeMaterno'  => $nomeMaterno,
            ':cpf'          => $cpf,
            ':email'        => $email,
            ':dataNasc'     => $dataNasc,
            ':telefone'     => $telefone,
            ':celular'      => $celular,
            ':cep'          => $cep,
            ':bairro'       => $bairro,
            ':cidade'       => $cidade,
            ':login'        => $login,
            ':senha'        => password_hash($senha, PASSWORD_DEFAULT)
        ]);

        $mensagem = '<div class="alert alert-success">Usuário cadastrado com sucesso! Redirecionando...</div>';

        unset($_SESSION['old']); // limpa os dados
        header("refresh:3;url=login.php");
    } catch (PDOException $e) {
        $mensagem = '<div class="alert alert-danger">Erro ao salvar no banco de dados: ' . $e->getMessage() . '</div>';

        $_SESSION['mensagem'] = $mensagem;
        header("Location: cadastro.php");
        exit;
    }
} else {
    $mensagem = "<p>Requisição inválida.</p>";
    $_SESSION['mensagem'] = $mensagem;
    header("Location: cadastro.php");
    exit;
}
