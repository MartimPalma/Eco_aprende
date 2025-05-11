
<?php
    include_once "./connections/connection.php";
    session_start();

    // Verifica se passaram os dados
    if (isset($_POST['estatuto']) && $_POST['escola']) {

        $_SESSION['escola'] = $_POST['escola'];
        $_SESSION['estatuto'] = $_POST['estatuto'];

    } else {
        header('Location: registo.php');
        exit();
    }
?>

<section class="container-fluid vh-100 bg-secondary">
    <div class="row justify-content-center align-items-center h-100 fundoBranco">
        <div class="card col-6 p-5 justify-content-center fundoAzul">
            <div class="text-center">
                <img src="imgs/logotipo_login.png" alt="logotipo" width="25%">
            </div>
            <div class="px-4 py-4 text-white">
                <!--Passa os dados por post para a proxima pagina do registo-->
                <form id="loginForm" method="post" action="./scripts/sc_registo.php">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control border-black" id="nome" name="nome" placeholder="Coloca o teu nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control border-black" id="email" name="email" placeholder="Coloca o teu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="turma" class="form-label">Turma</label>
                        <select class="form-select mb-3 border-black" aria-label="Default select example" id="turma" name="turma" required>
                            <option selected disabled>Indica a tua Turma</option>
                            <?php
                                $query = "SELECT DISTINCT letra  FROM turmas";
                                $link = new_db_connection();
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, $query);
                                mysqli_stmt_bind_result($stmt, $letra);
                                mysqli_stmt_execute($stmt);

                                while (mysqli_stmt_fetch($stmt)) {
                                    echo '<option value="' . $letra . '">' . $letra . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div >
                        <label for="ano" class="form-label">Ano</label>
                        <select class="form-select border-black" aria-label="Default select example" id="ano" name="ano" required>
                            <option selected disabled>Seleciona o teu Ano</option>
                            <?php
                                $query = "SELECT DISTINCT(ano) FROM turmas";
                                $link = new_db_connection();
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, $query);
                                mysqli_stmt_bind_result($stmt, $ano);
                                mysqli_stmt_execute($stmt);

                                while (mysqli_stmt_fetch($stmt)) {
                                    echo '<option value="' . $ano . '">' . $ano . ' º ano</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <?php
                        if (isset($_POST['estatuto']) && $_POST['estatuto'] == "1" || $_POST['estatuto'] == "3") {
                            echo '
                                    <div class="mt-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control border-black" id="password" name="password" placeholder="Coloca a tua password" required>
                                    </div>
                            ';
                        }
                    ?>

                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="registo.php" class="btn btn-primary btn-lg text-dark border-black ms-auto me-3 col-2"><strong>ANTERIOR</strong></a>
            <button id="submitButton" class="btn btn-primary btn-lg text-dark border-black me-auto col-2"><strong>AVANÇAR</strong></button>
        </div>
    </div>
</section>

<script>
    // Envia o formulário quando o botão é clicado, pois o botao esta fora do form
    document.getElementById("submitButton").addEventListener("click", function() {
        document.getElementById("loginForm").submit();
    });
</script>