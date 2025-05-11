<?php
    include_once "./connections/connection.php";

    session_start();

    // verifica se passou o id_modulo por GET do cp.content.php
    if (isset($_GET['id_modulo'])) {

        $id_modulo = $_GET['id_modulo'];
        $link = new_db_connection();
        $id_utilizador = $_SESSION['id_utilizador'];


        // seleciona os dados do modulo
        $sql = "
            SELECT modulos.titulo, infos.sabias_que, infos.intro, imagens_carousel.foto 
            FROM modulos 
            JOIN infos ON modulos.ref_infos = infos.id_info
            JOIN imagens_carousel ON infos.id_info = imagens_carousel.ref_infos
            WHERE modulos.id_modulo = ?
        ";

        $stmt = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id_modulo);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $titulo, $sabias_que, $intro, $foto);

            // guarda num array todas as imagens
            $imagens = [];
            $fetch = false;

            while (mysqli_stmt_fetch($stmt)) {
                // adiciona a imagem ao array de imagens
                $imagens[] = $foto;

                // debug , com problemas para mostrar as imagens
                /*if (!$fetch) {
                    $fetch = true;
                }*/
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da consulta.";
            exit;
        }

        /*if (!$fetched) {
            echo "Nenhuma imagem encontrada.";
            exit;
        }*/
    } else {
        echo "ID inválido.";
        exit;
    }
?>

<div class="fundoBranco">
    <section class="container vh-100 d-flex flex-column">
        <div class="row flex-grow-1 mt-2">
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div class="fundoCinzento rounded-3 p-1 mb-2">
                    <h3 class="letrasEscuro fs-2 mt-1 fw-bolder ms-3"><?= $titulo ?></h3>
                    <div class="ms-3">
                        <p class="fs-5">
                            <?= $intro ?>
                        </p>
                    </div>
                </div>
                <div class="fundoCinzento rounded-3 p-1 mb-2">
                    <h5 class="letrasAzul fs-2 fw-bolder mt-1 ms-3">SABIAS QUE...</h5>
                    <p class="fs-5 ms-3">
                        <?= $sabias_que ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div id="carouselExampleSlidesOnly" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        <?php foreach ($imagens as $index => $imagem): ?>
                            <?php
                                if($id_modulo == 1){
                                    ?>
                                        <div class="carousel-item mt-5   <?= $index === 0 ? 'active' : '' ?> " data-bs-interval="3000">
                                            <img src="./imgs/<?=$imagem ?>" class="d-block w-100 h-100 rounded-3 img-fluid" alt="Imagem">
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                        <div class="carousel-item mt-3  <?= $index === 0 ? 'active' : '' ?> h-100" data-bs-interval="3000">
                                            <img src="./imgs/<?=$imagem ?>" class="d-block w-100 h-100 rounded-3 img-fluid" alt="Imagem">
                                        </div>
                                    <?php
                                }
                            ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-6 d-flex justify-content-start">
                <a class="btn btn-primary btn-lg fundoAzulEscuro fw-bold borda_branco px-5" href="./video.php?id_modulo=<?= $id_modulo ?>">VIDEO</a>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <?php
                // verifica se o utilizador tiver concluído o módulo
                $check_query = "SELECT concluido FROM modulos_concluidos WHERE ref_modulos = ? AND ref_utilizadores = ?";
                $stmt_check = mysqli_stmt_init($link);

                if (mysqli_stmt_prepare($stmt_check, $check_query)) {
                    mysqli_stmt_bind_param($stmt_check, 'ii', $id_modulo, $id_utilizador);
                    mysqli_stmt_execute($stmt_check);
                    mysqli_stmt_bind_result($stmt_check, $concluido);
                    mysqli_stmt_fetch($stmt_check);
                    mysqli_stmt_close($stmt_check);
                }

                $pergunta_id = 0;

                if ($id_modulo == 1) {
                    $pergunta_id = 1;
                } elseif ($id_modulo == 2) {
                    $pergunta_id = 11;
                } elseif ($id_modulo == 3) {
                    $pergunta_id = 21;
                }

                if (!$concluido) { // Se o utilizador não tiver concluído o módulo aparece o botão de quiz, caso contrário o botão de quiz não aparece
                    ?>
                    <a class="btn btn-primary btn-lg fundoAzulClaro borda_azul_escura fw-bold me-5 px-5" href="quiz.php?id_modulo=<?= $id_modulo ?>&pergunta_id=<?= $pergunta_id ?>">QUIZ</a>
                    <?php
                }

                mysqli_close($link);
                ?>
            </div>
        </div>
    </section>
</div>
