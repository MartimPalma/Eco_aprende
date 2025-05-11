<?php
session_start();

include_once "../connections/connection.php";

// Verificar se o formulário foi enviado
if (isset($_POST['email'], $_POST['password'])) {

    $link = new_db_connection();

    $stmt = mysqli_stmt_init($link);

    // Verificar se o utilizador existe
    $query = "SELECT utilizadores.id_utilizador, utilizadores.email, utilizadores.nome, utilizadores.ref_perfis, utilizadores.ref_avatares, utilizadores.ref_turmas, utilizadores.num_tentativas_login, turmas.codigo_acesso, utilizadores.password
                  FROM utilizadores 
                  LEFT JOIN turmas ON utilizadores.ref_turmas = turmas.id_turma
                  WHERE utilizadores.email LIKE ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        $mail = $_POST['email'];

        mysqli_stmt_bind_param($stmt, 's', $mail);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $id, $mail, $nome, $ref_perfis, $avatar, $ref_turmas, $num_tentativas_login, $codigo_acesso, $pass_professor);

        if (mysqli_stmt_fetch($stmt)) {
            //var_dump($id, $mail, $nome, $ref_perfis, $avatar, $ref_turmas, $num_tentativas_login, $codigo_acesso, $pass_professor);
            var_dump($pass_professor, password_hash($_POST['password'], PASSWORD_DEFAULT));
            mysqli_stmt_close($stmt);
            var_dump(password_verify($_POST['password'], $pass_professor), $ref_perfis);
            if ($ref_perfis == 1 || $ref_perfis == 3 && password_verify($_POST['password'], $pass_professor)) {
                var_dump("professor");
                // definir variáveis de sessão
                $_SESSION['id_utilizador'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['login'] = true;
                $_SESSION['ref_perfis'] = $ref_perfis;
                $_SESSION['ref_turmas'] = $ref_turmas;
                $_SESSION['ref_avatares'] = $avatar;

                // Reseta o número de tentativas de login
                $num_tentativas_login = 0;
                $update_attempts_query = "UPDATE utilizadores SET num_tentativas_login = ? WHERE id_utilizador = ?";
                $update_stmt = mysqli_stmt_init($link);

                if (mysqli_stmt_prepare($update_stmt, $update_attempts_query)) {
                    mysqli_stmt_bind_param($update_stmt, 'ii', $num_tentativas_login, $id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }

                // Registrar a tentativa de login bem-sucedida na tabela login_tentativas
                $log_login_query = "INSERT INTO login_tentativas (ref_utilizadores, sucesso, num_tentativas) VALUES (?, 1, ?)";
                $log_stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($log_stmt, $log_login_query)) {
                    mysqli_stmt_bind_param($log_stmt, 'ii', $id, $num_tentativas_login);
                    mysqli_stmt_execute($log_stmt);
                    mysqli_stmt_close($log_stmt);
                }

                mysqli_close($link);

                // Redirecionar com base no perfil do utilizador
                header("Location: ../backoffice/admin.php");
                exit();

            } elseif (($ref_perfis == 2) && $_POST['password'] == $codigo_acesso) {

                // definir variáveis de sessão
                $_SESSION['id_utilizador'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['login'] = true;
                $_SESSION['ref_perfis'] = $ref_perfis;
                $_SESSION['ref_turmas'] = $ref_turmas;
                $_SESSION['ref_avatares'] = $avatar;

                // Reseta o número de tentativas de login
                $num_tentativas_login = 0;
                $update_attempts_query = "UPDATE utilizadores SET num_tentativas_login = ? WHERE id_utilizador = ?";
                $update_stmt = mysqli_stmt_init($link);

                if (mysqli_stmt_prepare($update_stmt, $update_attempts_query)) {
                    mysqli_stmt_bind_param($update_stmt, 'ii', $num_tentativas_login, $id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }

                // Registrar a tentativa de login bem-sucedida na tabela login_tentativas
                $log_login_query = "INSERT INTO login_tentativas (ref_utilizadores, sucesso, num_tentativas) VALUES (?, 1, ?)";
                $log_stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($log_stmt, $log_login_query)) {
                    mysqli_stmt_bind_param($log_stmt, 'ii', $id, $num_tentativas_login);
                    mysqli_stmt_execute($log_stmt);
                    mysqli_stmt_close($log_stmt);
                }

                mysqli_close($link);

                // Redirecionar com base no perfil do utilizador
                header("Location: ../index.php");
                exit();

            } else {

                // Incrementar o número de tentativas de login
                $num_tentativas_login++;

                // Atualizar o número de tentativas de login na tabela utilizadores
                $update_attempts_query = "UPDATE utilizadores SET num_tentativas_login = ? WHERE id_utilizador = ?";
                $update_stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($update_stmt, $update_attempts_query)) {
                    mysqli_stmt_bind_param($update_stmt, 'ii', $num_tentativas_login, $id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }

                // Bloquear o utilizador caso o número de tentativas de login ultrapasse 5
                if ($num_tentativas_login >= 5) {

                    // Bloquear o utilizador , atualizando a coluna bloqueado na tabela utilizadores para 1
                    $block_query = "UPDATE utilizadores SET bloqueado = 1 WHERE id_utilizador = ?";
                    $block_stmt = mysqli_stmt_init($link);

                    if (mysqli_stmt_prepare($block_stmt, $block_query)) {
                        mysqli_stmt_bind_param($block_stmt, 'i', $id);
                        mysqli_stmt_execute($block_stmt);
                        mysqli_stmt_close($block_stmt);
                    }

                    // Registrar a tentativa de login falha na tabela login_tentativas
                    $log_query = "INSERT INTO login_tentativas (ref_utilizadores, sucesso, num_tentativas) VALUES (?, 0, ?)";
                    $log_stmt = mysqli_stmt_init($link);
                    if (mysqli_stmt_prepare($log_stmt, $log_query)) {
                        mysqli_stmt_bind_param($log_stmt, 'ii', $id, $num_tentativas_login);
                        mysqli_stmt_execute($log_stmt);
                        mysqli_stmt_close($log_stmt);
                    }

                    mysqli_close($link);
                    header("Location: ../login.php?error=userblocked");
                    exit();

                } else {



                    // Registrar a tentativa de login falhada na tabela login_tentativas
                    $log_query = "INSERT INTO login_tentativas (ref_utilizadores, sucesso, num_tentativas) VALUES (?, 0, ?)";
                    $log_stmt = mysqli_stmt_init($link);
                    if (mysqli_stmt_prepare($log_stmt, $log_query)) {
                        mysqli_stmt_bind_param($log_stmt, 'ii', $id, $num_tentativas_login);
                        mysqli_stmt_execute($log_stmt);
                        mysqli_stmt_close($log_stmt);
                    }

                }
            }

        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            header("Location: ../login.php?error=nouser");
            exit();
        }
    } else {
        mysqli_close($link);
        header("Location: ../login.php?error=sqlerror");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>