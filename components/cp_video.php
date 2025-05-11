<?php
    include_once "./connections/connection.php";

    session_start();

    if (isset($_GET['id_modulo'])) {

        $id_modulo = $_GET['id_modulo'];
        $link = new_db_connection();

        $sql = "SELECT infos.video
                        FROM infos 
                        JOIN modulos ON infos.id_info = modulos.ref_infos
                        WHERE modulos.id_modulo = ?
                    ";
        $stmt = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id_modulo);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $video);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

        } else {
            echo "Erro na preparação da consulta.";
            exit;
        }


    } else {
        echo "ID inválido.";
        exit;
    }
?>



<section class="container vh-100">

    <div class="row justify-content-center align-items-center  h-75">

        <div class="col-11 mt-5 p-0">
            <video class="w-100" controls>
                <source src="imgs/<?= $video ?>" type="video/mp4">
            </video>

            <div class="row justify-content-end px-3">
                <a class="btn btn-primary btn-lg mt-3 col-3 fundoAzulClaro borda_azul_escura fw-bold" href="./info.php?id_modulo=<?= $id_modulo ?>">CURIOSIDADES</a>
            </div>
        </div>

    </div>
</section>
