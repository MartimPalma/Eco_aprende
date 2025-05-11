<?php
    include_once "../connections/connection.php";

    // Verificar se os dados foram enviados
    if (isset($_POST['nome'], $_POST['email'], $_POST['turma'], $_POST['avatar'])) {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $turma = $_POST['turma'];
        $avatar = $_POST['avatar'];

        $link = new_db_connection();

        // Atualizar o avatar do utilizador
        $query = "UPDATE utilizadores SET ref_avatares = ? WHERE email = ? AND ref_turmas = ?";
        $stmt = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, 'ssi', $avatar, $email, $turma);

            if (mysqli_stmt_execute($stmt)) {
                echo "Avatar atualizado com sucesso.";
                header('Location: ../login.php');
            } else {
                echo "Erro ao atualizar o avatar: " . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro ao preparar a consulta: " . mysqli_error($link);
        }

        mysqli_close($link);
    } else {
        echo "Dados insuficientes fornecidos.";
    }
?>
