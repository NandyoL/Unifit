<?php require_once 'conexao.php'; ?>
<?php
session_start();

// Recupera valores anteriores para repopular o formulário
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

// Limpa os dados da sessão após pegar
unset($_SESSION['old'], $_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--CSS e Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cadastro.css" />

    <!--JQuery e biblioteca de mascara (opcional, pode tirar se quiser)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="JS/jquery.mask.js"></script>

    <title>Cadastro</title>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg bg-body-color" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">UniFit</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastre-se</a></li>
                <li class="nav-item"><a class="nav-link" href="planos.php">Planos</a></li>
                <li class="nav-item"><a class="nav-link" href="sobrenos.php">Sobre nós</a></li>
            </ul>
        </div>

        <div id="userDropdown" class="dropdown ms-auto" style="display: none;">
            <a class="btn btn-secondary dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="Imagens/userIcon.webp" alt="Usuário" class="rounded-circle me-2" style="width: 30px; height: 30px;" />
                <span id="usuarioLogado"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><button class="dropdown-item" id="alterarSenha" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">Alterar Senha</button></li>
                <li><button class="dropdown-item" id="logoutBtn">Logout</button></li>
            </ul>
        </div>
    </div>
</nav>
</header>

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

        <form id="cadastroUnifit" action="validationcadastro.php" method="POST">
            <h1>Vem pra UniFit</h1>

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

            <label>Confirme a senha</label><br>
            <input class="form-control" name="confirmarSenha" type="password" maxlength="8" placeholder="Confirmar senha (máx. 8 caracteres)" />

            <button type="submit" id="cadastrarBtn">Enviar</button>
            <button type="reset">Limpar</button>
        </form>
    </div>
</section>
</main>

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

</body>
</html>
