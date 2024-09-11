function toggleForms() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    }
}


function verifyPassword(event) {
    // Previne o envio do formulário se os dados forem inválidos
    event.preventDefault();

    var senha = document.getElementById('register-senha').value;
    var nome = document.getElementById('register-nome').value;
    var regex = /[^a-zA-Z0-9]/;

    if(nome.length < 2){
        alert("Preencha todos os campos");
        return false;
    }

    if (regex.test(nome)) {
        alert("O nome contém caracteres inválidos. Use apenas letras.");
        return false;
    }
    

    if (senha.length < 5) {
        alert("Digite uma senha com pelo menos 5 caracteres");
        return false;
    }

    if (regex.test(senha)) {
        alert("A senha contém caracteres inválidos. Use apenas letras e números.");
        return false;
    }

    // Se os dados forem válidos, permite o envio do formulário
    document.getElementById('register-form').submit();
}
