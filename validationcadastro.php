<?php
session_start();
require_once 'conexao.php';

$erros = [];

function limparTexto($str) {
    return trim(filter_var($str, FILTER_SANITIZE_STRING));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitização e validação básica
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

    // Validações
    if (strlen($nome) < 3) $erros[] = "Nome deve ter pelo menos 3 caracteres.";
    if (empty($nomeMaterno)) $erros[] = "Nome materno é obrigatório.";
    if (strlen($cpf) != 11) $erros[] = "CPF deve conter 11 dígitos numéricos.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido.";
    if (empty($dataNasc) || strtotime($dataNasc) >= time()) $erros[] = "Data de nascimento inválida.";
    if (!empty($telefone) && !is_numeric($telefone)) $erros[] = "Telefone deve conter apenas números.";
    if (strlen($celular) < 8 || !is_numeric($celular)) $erros[] = "Celular inválido.";
    if (strlen($cep) != 8) $erros[] = "CEP deve conter 8 dígitos.";
    if (empty($bairro)) $erros[] = "Bairro é obrigatório.";
    if (empty($cidade)) $erros[] = "Cidade é obrigatória.";
    if (strlen($login) < 5) $erros[] = "Login deve ter pelo menos 5 caracteres.";
    if (strlen($senha) < 6) $erros[] = "Senha deve ter pelo menos 6 caracteres.";

    if (!empty($erros)) {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
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

        echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erro ao salvar no banco de dados: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Requisição inválida.</p>";
}
?>
