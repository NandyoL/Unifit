<?php
session_start();
include 'conexao.php';
include 'registralog.php';

if ($_POST) {
    registrarLog($pdo, $_SESSION['usuario']['id'], $_SESSION['usuario']['nome'], 'Cadastro', 'Cadastrou um novo usuário com o nome ' . $_POST['nome'] ?? 'N/A');

    $sql = "INSERT INTO usuarios (nome, nomeMaterno, cpf, email, dataNasc, telefone, celular, cep, bairro, cidade, login, senha, perfil)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt->execute([
        $_POST['nome'], $_POST['nomeMaterno'], $_POST['cpf'], $_POST['email'],
        $_POST['dataNasc'], $_POST['telefone'], $_POST['celular'], $_POST['cep'],
        $_POST['bairro'], $_POST['cidade'], $_POST['login'], $senhaHash, $_POST['perfil']
    ]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Usuario</title>
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

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <h4>Erros encontrados:</h4>
                <ul>
                    <?php foreach ($errors as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="cadastroUnifit" method="POST">
            <h1>Adicionar novo Usuário</h1>

            <label>Nome Completo</label><br>
            <input class="form-control" name="nome" type="text" placeholder="Digite seu nome" maxlength="80"
                   value="<?= htmlspecialchars($old['nome'] ?? '') ?>" />

            <label>Nome Materno</label><br>
            <input class="form-control" name="nomeMaterno" type="text" placeholder="Digite o nome da sua mãe" maxlength="80"
                   value="<?= htmlspecialchars($old['nome_materno'] ?? '') ?>" />

            <label>CPF</label><br>
            <input class="form-control" name="cpf" type="text" placeholder="Digite o CPF"
                   value="<?= htmlspecialchars($old['cpf'] ?? '') ?>" />

            <label>E-mail</label><br>
            <input class="form-control" name="email" type="email" placeholder="seuemail@unifit.com.br"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>" />

            <div class="row g-3" id="linha-sexo-data">
                <div class="col-sm-6" id="coluna-sexo">
                    <label>Sexo</label>
                    <select class="form-select" name="sexo">
                        <option value="" disabled <?= empty($old['sexo']) ? 'selected' : '' ?>>Selecione uma opção</option>
                        <option value="Masculino" <?= (isset($old['sexo']) && $old['sexo'] === 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                        <option value="Feminino" <?= (isset($old['sexo']) && $old['sexo'] === 'Feminino') ? 'selected' : '' ?>>Feminino</option>
                        <option value="Não informar" <?= (isset($old['sexo']) && $old['sexo'] === 'Não informar') ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>
                <div class="col-sm-6" id="coluna-nascimento">
                    <label>Data de Nascimento</label><br>
                    <input class="form-control" name="dataNasc" size="50" type="date"
                           value="<?= htmlspecialchars($old['dataNasc'] ?? '') ?>" />
                </div>
            </div>

            <div class="row g-3" id="linha-contatos">
                <div class="col-sm-6" id="coluna-telefone">
                    <label>Telefone</label><br>
                    <input class="form-control" name="telefone" size="50" type="tel" placeholder="55 (xx) xxxx-xxxx"
                           value="<?= htmlspecialchars($old['telefone'] ?? '') ?>" />
                </div>
                <div class="col-sm-6" id="coluna-celular">
                    <label>Celular</label><br>
                    <input class="form-control" name="celular" type="tel" placeholder="55 (xx) xxxx-xxxx"
                           value="<?= htmlspecialchars($old['celular'] ?? '') ?>" />
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-4">
                    <label>CEP</label><br>
                    <input class="form-control" name="cep" type="text" placeholder="CEP"
                           value="<?= htmlspecialchars($old['cep'] ?? '') ?>" />
                </div>
                <div class="col-sm-5">
                    <label>Rua</label><br>
                    <input class="form-control" name="rua" type="text" placeholder="Digite sua rua"
                           value="<?= htmlspecialchars($old['rua'] ?? '') ?>" />
                </div>
                <div class="col-sm-2">
                    <label>UF</label><br>
                    <input class="form-control" name="uf" type="text" placeholder="UF"
                           value="<?= htmlspecialchars($old['uf'] ?? '') ?>" />
                </div>
                <div class="col-sm-4">
                    <label>Complemento</label><br>
                    <input class="form-control" name="complemento" type="text" placeholder="Complemento"
                           value="<?= htmlspecialchars($old['complemento'] ?? '') ?>" />
                </div>
                <div class="col-sm-5">
                    <label>Número</label><br>
                    <input class="form-control" name="numero" type="text" placeholder="Número"
                           value="<?= htmlspecialchars($old['numero'] ?? '') ?>" />
                </div>
                <div class="col-sm-6">
                    <label>Bairro</label><br>
                    <input class="form-control" name="bairro" type="text" placeholder="Digite seu bairro"
                           value="<?= htmlspecialchars($old['bairro'] ?? '') ?>" />
                </div>
                <div class="col-sm-2"></div>
                <label>Cidade</label><br>
                <input class="form-control" name="cidade" type="text" placeholder="Digite sua cidade"
                       value="<?= htmlspecialchars($old['cidade'] ?? '') ?>" />
            </div>

            <label>Login</label><br>
            <input class="form-control" name="login" type="text" maxlength="6" placeholder="Digite o login (6 caracteres)"
                   value="<?= htmlspecialchars($old['login'] ?? '') ?>" />

            <label>Senha</label><br>
            <input class="form-control" name="senha" type="password" maxlength="8" placeholder="Digite a senha (máx. 8 caracteres)" />

            <label>Perfil:</label> 
            <select name="perfil">
                <option value="COMUM">COMUM</option>
                <option value="ADMIN">ADMIN</option>
            </select><br><br>
            <button type="submit">Salvar</button>
            <button type="reset">Limpar</button>
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
