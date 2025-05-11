
<?php
    include_once "./connections/connection.php";
?>

<section class="container-fluid vh-100">
    <div class="row justify-content-center align-items-center h-100 fundoBranco">
        <div class="card col-6 p-5 justify-content-center fundoAzul">
            <div class="text-center">
                <img src="imgs/logotipo_login.png" alt="logotipo" width="25%">
            </div>
            <div class="px-4 py-4 text-dark">
                <!--Passa os dados por post para a proxima pagina do registo-->
                <form id="loginForm" method="post" action="registo_2.php">
                    <div class="mb-3">
                        <label for="escola" class="form-label">Escola</label>
                        <select class="form-select mb-3 border-black" aria-label="Default select example" id="escola" name="escola" required>
                            <option selected disabled>Indica a tua escola</option>
                            <?php
                                $query = "SELECT nome, id_escola FROM escolas";
                                $link = new_db_connection();
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, $query);
                                mysqli_stmt_bind_result($stmt, $nome, $id_escola);
                                mysqli_stmt_execute($stmt);

                                while (mysqli_stmt_fetch($stmt)) {
                                    echo '<option value="' . $id_escola . '">' . $nome . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estatuto" class="form-label">Estatuto</label>
                        <select class="form-select mb-3 border-black" aria-label="Default select example" id="estatuto" name="estatuto" required>
                            <option selected disabled>Seleciona o teu estatuto</option>

                            <?php
                                $query = "SELECT tipo , id_perfil FROM perfis";
                                $link = new_db_connection();
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, $query);
                                mysqli_stmt_bind_result($stmt, $perfil, $id_perfil);
                                mysqli_stmt_execute($stmt);

                                while (mysqli_stmt_fetch($stmt)) {

                                    echo '<option value="' . $id_perfil . '">' . $perfil . '</option>';
                                }

                            ?>
                        </select>
                        <h5 class="form-text">Já tens uma conta? <span class="fw-bold letrasEscuro"><a href="login.php">Entra aqui.</a></span></h5>
                    </div>
                </form>
            </div>
        </div>
        <div class=" d-flex justify-content-center">
            <button id="submitButton" class="btn btn-primary btn-lg text-white  col-2 borda_azul_escura"><strong>SEGUINTE</strong></button>
        </div>
    </div>
</section>

<script>
    // Envia o formulário quando o botão é clicado, pois o botao esta fora do form
    document.getElementById("submitButton").addEventListener("click", function() {
        document.getElementById("loginForm").submit();
    });
</script>