
var formulario = document.getElementById('id_formulario');

formulario.addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio do formulário

    // Declaração de variáveis
    let login = document.getElementById('idLogin').value.trim();
    let senha = document.getElementById('idSenha').value.trim();

    // Variável localStorage
    let local = localStorage.getItem("usuario");

    // Verifica se há dados armazenados no localStorage
    if (!local) {
        showModal("Usuário não encontrado! Por favor, cadastre-se.");
        return; // Se não encontrar o usuário, não continua o código
    }

    let obj = JSON.parse(local); // Converte o dado de string para objeto

    // Validações
    if (login === obj.login && senha === obj.senha) {
        
        // Garante que o usuário esteja logado
        obj.logado = true;
        localStorage.setItem("usuario", JSON.stringify(obj));

        // Login e senha corretos
        showModal("Login realizado com sucesso!");
        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000) // Aguarda 1 segundos antes de redirecionar
    } else {
        // Login ou senha incorretos
        showModal("Login ou senha incorretos!");
    }

    
});

// Função para exibir o modal com a mensagem
function showModal(mensagem) {
    let mensagem_erro = document.getElementById('MensagemDeErro');
    mensagem_erro.textContent = mensagem;
    let erroModal = new bootstrap.Modal(document.getElementById('erroModal'));
    erroModal.show();
}


