

<!-- Tudo ok só falta melhorar aspeto visual-->

<section class="container-fluid vh-100 fundoAzulEscuro">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-6 px-5 py-5 text-white text-center">
            <div class="fs-1 fw-bold"><p>PARABÉNS!!</p></div>

                <img src="./imgs/boneco_pontuacao.png" class="img-fluid" style="height: 350px; width: 350px" id="boneco1" alt="...">
                <img src="./imgs/boneco_pontuacao.png" class="img-fluid" style="height: 350px; width: 350px" id="boneco2" alt="...">
                <img src="./imgs/boneco_pontuacao.png" class="img-fluid" style="height: 350px; width: 350px" id="boneco3" alt="...">
                <img src="./imgs/boneco_pontuacao.png" class="img-fluid" style="height: 350px; width: 350px" id="boneco4" alt="...">

            <?php
                session_start(); // Inicia a sessão

                include_once "./connections/connection.php";

                if (isset($_GET['id_modulo'])) {

                    $id_modulo = $_GET['id_modulo'];
                    $link = new_db_connection();

                    $stmt = mysqli_stmt_init($link);

                    // somar as pontuações do utilizador no módulo
                    $query = "SELECT SUM(pontuacao) AS total_pontuacao FROM resultados
                              INNER JOIN perguntas ON resultados.ref_perguntas = perguntas.id_pergunta
                              WHERE ref_modulos = ? AND ref_utilizadores = ?";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_bind_param($stmt, 'ii' , $id_modulo,$_SESSION['id_utilizador']);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_bind_result($stmt,  $total_pontuacao);

                        while (mysqli_stmt_fetch($stmt)) {
                            ?>
                                <div class="bg-light letrasEscuro rounded-pill p-4 fs-1 fw-bold mt-5 mb-5"><?= $total_pontuacao ?>/100</div>
                            <?php
                        }

                    } else {
                        header("Location: ../index.php?error=sqlerror");
                    }

                    mysqli_stmt_close($stmt);

                }
            ?>

            <button type="submit" class="btn btn-primary mt-4 centro btn-lg fundoAzulEscuro2 borda_branco fw-bold">
                <a href="./index.php">PÁGINA INICIAL</a>
            </button>
        </div>
    </div>
</section>
