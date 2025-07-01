<?php
session_start();
include 'conexao.php';
include 'registralog.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if ($_POST) {

    registrarLog($pdo, $_SESSION['usuario']['id'], $_SESSION['usuario']['nome'], 'Edição', 'Editou os dados do usuário Id ' . $_POST['id']);

    $sql = "UPDATE usuarios SET nome=?, nomeMaterno=?, cpf=?, email=?, dataNasc=?, telefone=?, celular=?, cep=?, bairro=?, cidade=?, login=?, perfil=?";
    
    $params = [
        $_POST['nome'], $_POST['nomeMaterno'], $_POST['cpf'], $_POST['email'], $_POST['dataNasc'],
        $_POST['telefone'], $_POST['celular'], $_POST['cep'], $_POST['bairro'], $_POST['cidade'],
        $_POST['login'], $_POST['perfil']
    ];

    if (!empty($_POST['senha'])) {
        $sql .= ", senha=?";
        $params[] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id=?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!--JQuery e biblioteca de mascara (opcional, pode tirar se quiser)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="JS/jquery.mask.js"></script>

    <!--CSS e Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cadastro.css">
</head>

<body class="adicionar-usuario">
<main>
<section id="formulario">
    <div class="container">
        <form id="cadastroUnifit" method="POST">
    <h2>Editar Usuário</h2>
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>"> <!-- Campo oculto para enviar o ID -->
    <label>Nome:</label> <input class="form-control" type="text" name="nome" value="<?= $usuario['nome'] ?>" required><br>
    <label>Nome Materno:</label> <input class="form-control" type="text" name="nomeMaterno" value="<?= $usuario['nomeMaterno'] ?>" required><br>
    <label>CPF:</label> <input class="form-control" type="text" name="cpf" value="<?= $usuario['cpf'] ?>" required><br>
    <label>Email:</label> <input class="form-control" type="email" name="email" value="<?= $usuario['email'] ?>" required><br>
    <label>Data Nascimento:</label> <input class="form-control" type="date" name="dataNasc" value="<?= $usuario['dataNasc'] ?>"><br>
    <label>Telefone:</label> <input class="form-control" type="text" name="telefone" value="<?= $usuario['telefone'] ?>"><br>
    <label>Celular:</label> <input class="form-control" type="text" name="celular" value="<?= $usuario['celular'] ?>"><br>
    <label>CEP:</label> <input class="form-control" type="text" name="cep" value="<?= $usuario['cep'] ?>"><br>
    <label>Bairro:</label> <input class="form-control" type="text" name="bairro" value="<?= $usuario['bairro'] ?>"><br>
    <label>Cidade:</label> <input class="form-control" type="text" name="cidade" value="<?= $usuario['cidade'] ?>"><br>
    <label>Login:</label> <input class="form-control" type="text" name="login" value="<?= $usuario['login'] ?>"><br>
    <label>Senha (deixe em branco para manter a atual):</label> <input class="form-control" type="password" name="senha"><br>
    <label>Perfil: </label>
    <select name="perfil">
        <option value="COMUM" <?= $usuario['perfil'] == 'COMUM' ? 'selected' : '' ?>>COMUM</option>
        <option value="ADMIN" <?= $usuario['perfil'] == 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
    </select><br><br>
    <button type="submit">Atualizar</button>
    <button type="button" onclick="window.location.href='dashboard.php'">Voltar</button>
</form>
</div>
</section>
</main>
</body>

<!-- Mantém as máscaras para ajudar o usuário, mas sem JS customizado -->
<script>
$(document).ready(function(){
    $('input[name="telefone"]').mask('55 (00) 0000-0000');
    $('input[name="celular"]').mask('55 (00) 00000-0000');
    $('input[name="cep"]').mask('00000-000');
    $('input[name="cpf"]').mask('000.000.000-00');
});
</script>


<script>
$(document).ready(function() {
    $('input[name="cep"]').blur(function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON('viacep.php?cep=' + cep, function(data) {
                if (!("erro" in data)) {
                    $('input[name="rua"]').val(data.logradouro);
                    $('input[name="bairro"]').val(data.bairro);
                    $('input[name="cidade"]').val(data.localidade);
                    $('input[name="uf"]').val(data.uf);
                }
            });
        }
    });
});
</script>