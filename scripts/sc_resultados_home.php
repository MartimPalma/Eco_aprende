<?php

    include_once "../connections/connection.php";
    session_start();

    if (isset($_SESSION['id_utilizador'])) {
        $id_utilizador = $_SESSION['id_utilizador'];

        $link = new_db_connection();

        // Verificar todos os módulos concluídos pelo utilizador
        $query_todos_modulos = "SELECT ref_modulos FROM modulos_concluidos WHERE ref_utilizadores = ? AND concluido = 1";
        $stmt_todos_modulos = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt_todos_modulos, $query_todos_modulos)) {
            mysqli_stmt_bind_param($stmt_todos_modulos, 'i', $id_utilizador);
            mysqli_stmt_execute($stmt_todos_modulos);
            mysqli_stmt_bind_result($stmt_todos_modulos, $modulo_concluido);

            $modulos_concluidos = [];
            while (mysqli_stmt_fetch($stmt_todos_modulos)) {
                // guarda os módulos concluídos num array para depois serem passados para a página de resultados
                $modulos_concluidos[] = $modulo_concluido;
            }

            mysqli_stmt_close($stmt_todos_modulos);
            mysqli_close($link);

            // Se a variavel não estiver vazia, significa que o utilizador tem pelo menos um módulo concluído
            if (!empty($modulos_concluidos)) {
                // junta os módulos concluídos numa string , permite a consulta a todos os módulos concluídos
                // por exemplo: 1,2,3
                $ids_modulos = implode(",", $modulos_concluidos);
                header("Location: ../resultados_home.php?id_modulo=" . $ids_modulos);
                exit;
            } else {
                header("Location: ../index.php?nenhum_modulo_concluido");
                echo "Nenhum módulo foi concluído.";
                exit;
            }
        } else {
            echo "Erro na preparação da consulta: " . mysqli_stmt_error($stmt_todos_modulos);
            mysqli_close($link);
        }
    } else {
        echo "Sessão expirada ou utilizador não autenticado.";
        exit;
    }

?>
