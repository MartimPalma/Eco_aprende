<?php

include_once "./connections/connection.php";

session_start();

// iguala a variável $user_id ao valor da variável $_SESSION['id_utilizador']
$user_id = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : null;

// se $user_id estiver vazio vai para login.php
if (!$user_id) {
    header("Location: login.php?fazlogin");
    exit();
}

$link = new_db_connection();

// seleciona a turma
$query = "SELECT ref_turmas FROM utilizadores WHERE id_utilizador = ?";
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $turma_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Error: erro a preparar a consulta.";
    exit();
}

// seleciona os modulos desbloqueados da turma e cria um array
$desbloqueado = [];
$query = "SELECT ref_modulos FROM modulos_desbloqueados WHERE ref_turmas = ?";
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $turma_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $modulo_id);
    // guardar os modulos desbloqueados num array
    while (mysqli_stmt_fetch($stmt)) {
        $desbloqueado[] = $modulo_id;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Erro a preparar a consulta.";
    exit();
}

// seleciona informações dos módulos, excluindo o módulo do quiz geral e "Meus Resultados"
$query1 = "SELECT id_modulo, titulo, capa, ref_infos FROM modulos ";
$stmt = mysqli_stmt_init($link);
$modulos = [];
if (mysqli_stmt_prepare($stmt, $query1)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_modulo, $titulo, $capa, $ref_infos);
    while (mysqli_stmt_fetch($stmt)) {
        if ($id_modulo != 4 && $id_modulo != 5) { // Exclui o módulo do quiz geral e "Meus Resultados"
            $modulos[] = [
                'id_modulo' => $id_modulo,
                'titulo' => $titulo,
                'capa' => $capa,
                'ref_infos' => $ref_infos
            ];
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Erro a preparar a consulta.";
    exit();
}

?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">

            <?php include_once "./components/cp_intro_index.php"; ?>

            <?php foreach ($modulos as $modulo) { ?>
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card w-100">
                        <?php if (in_array($modulo['id_modulo'], $desbloqueado)) { ?>
                        <a href="./video.php?id_modulo=<?= $modulo['id_modulo']; ?>">
                            <?php } else { ?>
                            <a href="./index.php?modulobloqueado">
                                <?php } ?>
                                <img src="imgs/<?= $modulo['capa']; ?>" class="card-img-top img-fluid" alt="...">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <p class="letrasAzul p-0">
                                            <?php if (!in_array($modulo['id_modulo'], $desbloqueado)) { ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                                                </svg>
                                            <?php } else { ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#66C0E1" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2"/>
                                                </svg>
                                            <?php } ?>
                                            <span class="letrasEscuro">Módulo <?= $modulo['id_modulo']; ?>:</span> <span class="fw-bold fs-5"><?= $modulo['titulo']; ?></span>
                                        </p>
                                    </h4>
                                </div>
                            </a>
                    </div>
                </div>
            <?php } ?>

            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <?php
                    if (in_array(4, $desbloqueado)) {
                    $check_query = "SELECT concluido FROM modulos_concluidos WHERE ref_modulos = ? AND ref_utilizadores = ?";
                    $stmt_check = mysqli_stmt_init($link);
                    if (mysqli_stmt_prepare($stmt_check, $check_query)) {
                        $modulo_id = 4;
                        mysqli_stmt_bind_param($stmt_check, 'ii', $modulo_id, $user_id);
                        mysqli_stmt_execute($stmt_check);
                        mysqli_stmt_bind_result($stmt_check, $concluido);
                        mysqli_stmt_fetch($stmt_check);
                        mysqli_stmt_close($stmt_check);
                    }

                    if (!$concluido) { ?>
                    <a href="./quiz.php?id_modulo=4&pergunta_id=67">
                        <?php } else { ?>
                        <a href="./index.php?moduloconcluido">
                            <?php }
                            } else { ?>
                            <a href="./index.php?modulobloqueado">
                                <?php } ?>
                                <img src="./imgs/quiz_geral.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <p class="letrasAzul">
                                            <?php if (!in_array(4, $desbloqueado)) { ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                                                </svg>
                                            <?php } ?>
                                            <span class="letrasEscuro">Módulo 4:</span> <span class="fw-bold fs-5">Quiz Geral</span>
                                        </p>
                                    </h4>
                                </div>
                            </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <a href="./scripts/sc_resultados_home.php">
                        <img src="./imgs/meus_resultados.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">
                                <span class="letrasEscuro">Os meus resultados</span>
                            </h4>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>