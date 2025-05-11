<?php
    include_once "./connections/connection.php";

    session_start();
?>

    <?php
        //
        if (isset($_POST['nome'], $_POST['email'], $_POST['turma'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $turma = $_POST['turma'];
        } else {
            echo "Dados do utilizador não fornecidos.";
            exit();
    }
        //função para obter o avatar do perfil
    function getAvatarsByProfile($profile) {
        $link = new_db_connection();

        $sql = "SELECT id_avatar, imagem FROM avatares WHERE ref_perfis = ?";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $profile);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $avatars = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // guarda o avatar num array avatars
            $avatars[] = $row;
        }

        mysqli_stmt_close($stmt);
        $link->close();

        return $avatars;
    }

    if (isset($_SESSION['estatuto'])) {

        $perfil = $_SESSION['estatuto'];
        // Obter o avatar do perfil chamando a funcão getAvatarsByProfile levando como parâmetro o id do perfil
        $avatars = getAvatarsByProfile($perfil);
        ?>
        <section class="container-fluid vh-100 fundoAzul">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-8 text-center">
                    <h1 class="text-white mb-5 fw-bold">ESCOLHE O TEU AVATAR E VEM APRENDER!</h1>
                    <div class="row justify-content-center">
                        <?php

                            foreach ($avatars as $avatar) {
                                ?>
                                <div class="col-md-3 mt-5 mb-5">
                                    <!--campos do formulário escondidos, levam os dados para sc_update_avatar -->
                                    <!-- o botão de submissão é a foto do avatar selecionado -->
                                    <form method="POST" action="./scripts/sc_update_avatar.php">
                                        <input type="hidden" name="nome" value="<?= $nome ?>">
                                        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                                        <input type="hidden" name="turma" value="<?= $turma ?>">
                                        <input type="hidden" name="avatar" value="<?= $avatar['id_avatar'] ?>">
                                        <button type="submit" class="btn p-0 border-0">
                                            <img src="./imgs/<?= $avatar['imagem'] ?>" class=" rounded-circle" style="width: 175px; height: 180px" alt="Avatar">
                                        </button>
                                    </form>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <button class="btn btn-primary mt-5 fundoAzulEscuro borda_branco">
                        <a href="./login.php" class="text-white fw-bold fs-6">ENTRAR</a>
                    </button>
                </div>
            </div>
        </section>
        <?php
    } else {
        echo "Perfil não definido.";
    }
?>

