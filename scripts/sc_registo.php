<?php
include_once "../connections/connection.php";
session_start();

// Recebe os dados dos formulários
$escola = $_SESSION['escola'];
$estatuto = $_SESSION['estatuto'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$letra = $_POST['turma'];
$ano = $_POST['ano'];
$password = $_POST['password']; // só para professores

if (isset($estatuto) && $estatuto == "2") {
    if (!empty($escola) && !empty($estatuto) && !empty($nome) && !empty($email) && !empty($letra) && !empty($ano)) {

        $link = new_db_connection();

        $protocolo = '@ageilhavo.pt';

        //verifica se a string do email contem o $protocolo
        $verifica = strpos($email, $protocolo);
        var_dump($verifica);

        if ($verifica === false) {
            echo "The string '$protocolo' is NOT in '$email'";
            header("Location: ../registo.php?introduzemailinstituicional");

        } else {
            echo "The string '$protocolo' is in '$email'";

            // Seleciona a turma
            $query1 = "SELECT id_turma FROM turmas
                               INNER JOIN escolas ON escolas.id_escola = turmas.ref_escolas 
                               WHERE letra = ? AND ano = ? AND escolas.id_escola = ?";

            $stmt1 = mysqli_stmt_init($link);

            if (mysqli_stmt_prepare($stmt1, $query1)) {
                mysqli_stmt_bind_param($stmt1, 'sis', $letra, $ano, $escola);

                if (mysqli_stmt_execute($stmt1)) {
                    mysqli_stmt_bind_result($stmt1, $turma_id);
                    mysqli_stmt_fetch($stmt1);

                    mysqli_stmt_close($stmt1);

                    if ($turma_id) {
                        // Insere os dados no utilizadores consoante a turma
                        $query2 = "INSERT INTO utilizadores (nome, email, ref_perfis, ref_turmas) VALUES (?, ?, ?, ?)";
                        $stmt2 = mysqli_stmt_init($link);

                        if (mysqli_stmt_prepare($stmt2, $query2)) {
                            mysqli_stmt_bind_param($stmt2, 'ssii', $nome, $email, $estatuto, $turma_id);

                            // Função para redirecionar para o avatar, está no final do script
                            executaRedireciona($stmt2, $nome, $email, $turma_id , $link);

                            mysqli_stmt_close($stmt2);
                        } else {
                            echo "Erro a preparar query2: " . mysqli_error($link);
                        }
                    } else {
                        echo "Turma não encontrada.";
                    }
                } else {
                    echo "Erro query1: " . mysqli_error($link);
                }
            } else {
                echo "Erro a preparar query1: " . mysqli_error($link);
            }

            mysqli_close($link);
        }

    } else {
        header("Location: ../registo_2.php");
        echo "Por favor preenche todos os campos.";
    }
} else {
    if (!empty($escola) && !empty($estatuto) && !empty($nome) && !empty($email) && !empty($letra) && !empty($ano) && !empty($password)) {
        $link = new_db_connection();

        if ($estatuto = 2){
            $protocolo = '@ageilhavo.pt';

            //verifica se a string do email contem o $protocolo
            $verifica = strpos($email, $protocolo);
            var_dump($verifica);

            if ($verifica === false) {
                echo "The string '$protocolo' is NOT in '$email'";
                header("Location: ../registo.php?introduzemailinstituicional");

            } else {
                echo "The string '$protocolo' is in '$email'";

                // Seleciona a turma
                $query1 = "SELECT id_turma FROM turmas
                               INNER JOIN escolas ON escolas.id_escola = turmas.ref_escolas 
                               WHERE letra = ? AND ano = ? AND escolas.id_escola = ?";

                $stmt1 = mysqli_stmt_init($link);

                if (mysqli_stmt_prepare($stmt1, $query1)) {
                    mysqli_stmt_bind_param($stmt1, 'sis', $letra, $ano, $escola);

                    if (mysqli_stmt_execute($stmt1)) {
                        mysqli_stmt_bind_result($stmt1, $turma_id);
                        mysqli_stmt_fetch($stmt1);

                        mysqli_stmt_close($stmt1);

                        if ($turma_id) {
                            // Insere os dados no utilizadores consoante a turma
                            $query2 = "INSERT INTO utilizadores (nome, email, ref_perfis, ref_turmas, password) VALUES (?, ?, ?, ?, ?)";
                            $stmt2 = mysqli_stmt_init($link);

                            if (mysqli_stmt_prepare($stmt2, $query2)) {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt2, 'ssiis', $nome, $email, $_SESSION['estatuto'], $turma_id, $password);

                                // Função para redirecionar para o avatar
                                executaRedireciona($stmt2, $nome, $email, $turma_id, $link);

                                mysqli_stmt_close($stmt2);
                            } else {
                                echo "Erro a preparar query2: " . mysqli_error($link);
                            }
                        } else {
                            echo "Turma não encontrada.";
                        }
                    } else {
                        echo "Erro query1: " . mysqli_error($link);
                    }
                } else {
                    echo "Erro a preparar query1: " . mysqli_error($link);
                }

                mysqli_close($link);
            }

        } else {
            // Seleciona a turma
            $query1 = "SELECT id_turma FROM turmas
                               INNER JOIN escolas ON escolas.id_escola = turmas.ref_escolas 
                               WHERE letra = ? AND ano = ? AND escolas.id_escola = ?";

            $stmt1 = mysqli_stmt_init($link);

            if (mysqli_stmt_prepare($stmt1, $query1)) {
                mysqli_stmt_bind_param($stmt1, 'sis', $letra, $ano, $escola);

                if (mysqli_stmt_execute($stmt1)) {
                    mysqli_stmt_bind_result($stmt1, $turma_id);
                    mysqli_stmt_fetch($stmt1);

                    mysqli_stmt_close($stmt1);

                    if ($turma_id) {
                        // Insere os dados no utilizadores consoante a turma
                        $query2 = "INSERT INTO utilizadores (nome, email, ref_perfis, ref_turmas, password) VALUES (?, ?, ?, ?, ?)";
                        $stmt2 = mysqli_stmt_init($link);

                        if (mysqli_stmt_prepare($stmt2, $query2)) {
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt2, 'ssiis', $nome, $email, $estatuto, $turma_id, $password);


                        } else {
                            echo "Erro a preparar query2: " . mysqli_error($link);
                        }
                    } else {
                        echo "Turma não encontrada.";
                    }
                } else {
                    echo "Erro query1: " . mysqli_error($link);
                }
            } else {
                echo "Erro a preparar query1: " . mysqli_error($link);
            }

            mysqli_close($link);
        }
    }
}


function executaRedireciona($stmt, $nome, $email, $turma_id , $link) {

    if (mysqli_stmt_execute($stmt)) {
        echo '
                <form id="redirectForm" method="POST" action="../avatar.php">
                    <input type="hidden" name="nome" value="' . $nome . '">
                    <input type="hidden" name="email" value="' . $email . '">
                    <input type="hidden" name="turma" value="' . $turma_id . '">
                </form>
                <script type="text/javascript">
                    document.getElementById("redirectForm").submit();
                </script>
            ';
        exit();
    } else {
        echo "Erro ao executar query de inserção: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}
?>