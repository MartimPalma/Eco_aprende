<?php

    include_once "../connections/connection.php";

    session_start();

    if (isset($_GET['id_modulo']) && isset($_SESSION['id_utilizador'])) {
        $query = "INSERT INTO modulos_concluidos ref_modulos, ref_utilizadores , concluido VALUES (?, ?, 1)";
        $link = new_db_connection();
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_result($stmt, $concluido);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['id_modulo'], $_SESSION['id_utilizador']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);

        if ($concluido == 1) {
            header('Location: ../pontuacaoFinal.php?id_modulo=' . $_GET['id_modulo']);
        } else {
            header('Location: ../index.php?modulobloqueado');
        }

        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }

?>
