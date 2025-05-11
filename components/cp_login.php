<section class="container-fluid vh-100">
    <div class="row justify-content-center align-items-center h-100 fundoBranco">
        <div class="card col-6 p-5 justify-content-center fundoAzul">
            <div class="text-center">
                <img src="imgs/logotipo_login.png" alt="logotipo" width="25%">
            </div>
            <div class="px-4 py-4 text-black">
                <form id="loginForm" method="post" action="./scripts/sc_login.php">
                    <h3 class="text-black">Introduz os teus dados</h3>
                    <div class="mb-3 mt-3">
                        <label for="login" class="form-label">Email:</label>
                        <input type="email" class="form-control border-black" id="login" placeholder="Insere o teu email" name="email" required="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Código de Acesso:</label>
                        <input type="password" class="form-control border-black" id="password" placeholder="Insere o teu código de acesso" name="password" required="">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <h5 class="form-text">Ainda não tens uma conta? <span class="fw-bold letrasEscuro"><a href="registo.php">Regista-te aqui.</a></span></h5>
                    </div>
                </form>
            </div>
        </div>
                <div class=" d-flex justify-content-center">
                     <button id="submitButton" class="btn btn-primary mt-3 btn-lg border-black text-black col-2"><strong>ENTRAR</strong></button>
                </div>
    </div>
</section>

<script>
    // Envia o formulário quando o botão é clicado
    // não estava a dar sem o script porque o botão esta fora do formulário
    document.getElementById("submitButton").addEventListener("click", function() {
        document.getElementById("loginForm").submit();
    });
</script>

