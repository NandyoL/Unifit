// Função para realizar logout
function logout() {
    // Recupera os dados do usuário
    let usuario = JSON.parse(localStorage.getItem("usuario"));

    if (usuario) {
        // Atualiza o estado de login para falso
        usuario.logado = false;
        localStorage.setItem("usuario", JSON.stringify(usuario));
    }

    // Redireciona para a página de login
    alert("Você saiu com sucesso! Redirecionando para a página de login...");
       
    // Aguardar o tempo necessário para o redirecionamento
    setTimeout(() => {
        window.location.href = "login.php"; // Redireciona após 1 segundo
    }, 1000);

     // Oculta o dropdown do usuário
     if(usuario.logado === false){
        document.getElementById("userDropdown").style.display = "none";
     }
}

// Adiciona evento ao botão de logout
document.getElementById("logoutBtn").addEventListener("click", logout);

// Exibe o nome do usuário logado no dropdown
function exibirUsuarioLogado() {
    let usuario = JSON.parse(localStorage.getItem("usuario"));

    if (usuario && usuario.logado && usuario.login) {
        // Mostra o dropdown do usuário
        document.getElementById("userDropdown").style.display = "block";

        // Extrai o primeiro nome do campo `nome`
        let primeiroNome = usuario.nome.split(" ")[0];

        // Transforma a primeira letra em maiúscula
        primeiroNome = primeiroNome.charAt(0).toUpperCase() + primeiroNome.slice(1).toLowerCase();

        // Atualiza o nome do usuário
        let usuarioLogado = document.getElementById("usuarioLogado");
        usuarioLogado.textContent = ` ${primeiroNome}`;
    } else {
        // Oculta o dropdown caso o usuário não esteja logado
        document.getElementById("userDropdown").style.display = "none";
    }
}

// Chama a função ao carregar a página
window.onload = exibirUsuarioLogado;

//Alteração de Senha
document.getElementById("salvarSenhaBtn").addEventListener("click", function () {
    // Armazena os valores dos campos
    let senhaAtual = document.getElementById("senhaAtual").value.trim();
    let novaSenha = document.getElementById("novaSenha").value.trim();
    let confirmarSenha = document.getElementById("confirmarSenha").value.trim();
  
    // Recupera o usuário do localStorage
    let usuario = JSON.parse(localStorage.getItem("usuario"));
  
    // Validações
    if (!usuario || senhaAtual !== usuario.senha) {
      showModal("Senha atual incorreta!");
      return;
    }
  
    if (novaSenha.length !== 8) {
      showModal("A nova senha deve ter exatamente 8 caracteres.");
      return;
    }
  
    if (novaSenha !== confirmarSenha) {
      showModal("As senhas não coincidem!");
      return;
    }
  
    // Atualiza a senha no localStorage
    usuario.senha = novaSenha;
    localStorage.setItem("usuario", JSON.stringify(usuario));

    usuario.confirmarSenha = confirmarSenha;
    localStorage.setItem("usuario", JSON.stringify(usuario));
  
    // Exibe mensagem de sucesso e fecha o modal
    showModal("Senha alterada com sucesso!");
    document.getElementById("alterarSenhaForm").reset(); // Limpa os campos
    let alterarSenhaModal = bootstrap.Modal.getInstance(document.getElementById("alterarSenhaModal"));
    alterarSenhaModal.hide();
  });
  
// Função para exibir o modal com a mensagem
function showModal(mensagem) {
    let mensagem_erro = document.getElementById('MensagemDeErro');
    mensagem_erro.textContent = mensagem;
    let erroModal = new bootstrap.Modal(document.getElementById('erroModal'));
    erroModal.show();
}