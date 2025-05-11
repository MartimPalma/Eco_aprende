<?php

    include_once "../connections/connection.php";
    session_start();

    // Verifica se existem os parâmetros
    if (isset($_GET['resposta']) && isset($_GET['pergunta_id']) && isset($_GET['id_modulo'])) {

        $pergunta_id = $_GET['pergunta_id'];
        $resposta_id = $_GET['resposta'];
        $id_modulo = $_GET['id_modulo'];
        $utilizador_id = $_SESSION['id_utilizador'];

        $link = new_db_connection();

        // Verifica se a resposta é correta
        $query_verifica = "SELECT correta FROM opcoes WHERE id_opcoes = ?";
        $stmt_verifica = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt_verifica, $query_verifica)) {
            mysqli_stmt_bind_param($stmt_verifica, "i", $resposta_id);
            mysqli_stmt_execute($stmt_verifica);
            mysqli_stmt_bind_result($stmt_verifica, $correta);
            mysqli_stmt_fetch($stmt_verifica);
            mysqli_stmt_close($stmt_verifica);

            // resposta correta tem valor 10 e resposta errada tem valor 0
            $pontuacao = ($correta == 1) ? 10 : 0;

            // Insere os resultados
            $query = "INSERT INTO resultados (ref_utilizadores, ref_perguntas, pontuacao) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($link);

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, "iii", $utilizador_id, $pergunta_id, $pontuacao);

                if (mysqli_stmt_execute($stmt)) {
                    // determina o id da ultima pergunta
                    $last_question_id = 0;
                    switch ($id_modulo) {
                        case 1:
                            $last_question_id = 10;
                            break;
                        case 2:
                            $last_question_id = 20;
                            break;
                        case 3:
                            $last_question_id = 30;
                            break;
                        case 4:
                            $last_question_id = 76;
                            break;
                    }

                    // Verifica se a pergunta é a ultima
                    if ($pergunta_id >= $last_question_id) {

                        // Marca o modulo como concluído
                        $query_modulo = "INSERT INTO modulos_concluidos (ref_utilizadores, ref_modulos, concluido) VALUES (?, ?, 1)";
                        $stmt_modulo = mysqli_stmt_init($link);
                        if (mysqli_stmt_prepare($stmt_modulo, $query_modulo)) {
                            mysqli_stmt_bind_param($stmt_modulo, "ii", $utilizador_id, $id_modulo);
                            mysqli_stmt_execute($stmt_modulo);
                            mysqli_stmt_close($stmt_modulo);
                        } else {
                            echo "Erro na preparação da consulta: " . mysqli_stmt_error($stmt_modulo);
                        }
                        // redireciona para a pontuação final
                        header("Location: ../pontuacaoFinal.php?id_modulo=$id_modulo");
                    } else {
                        // mostra a proxima pergunta
                        $proximo_id = $pergunta_id + 1;
                        header("Location: ../quiz.php?id_modulo=$id_modulo&pergunta_id=$proximo_id");
                    }

                } else {
                    echo "Erro ao inserir os resultados: " . mysqli_stmt_error($stmt);
                }

            } else {
                echo "Erro na preparação da consulta: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da verificação: " . mysqli_stmt_error($stmt_verifica);
        }

        mysqli_close($link);
    } else {
        echo "Parâmetros inválidos.";
        exit;
    }
?>
