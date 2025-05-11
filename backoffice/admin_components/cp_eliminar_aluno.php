<div class="mt-5 container">
    <div class='mb-3'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
    <h3 class="ps-2">Escolhe um aluno para apagar</h3>
    <div class="d-flex  justify-content-center">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";



include_once "../connections/connection.php";
$link = new_db_connection();
$professor = mysqli_stmt_init($link);
$query = "SELECT ref_perfis, ref_turmas FROM utilizadores WHERE id_utilizador = ?";
if (mysqli_stmt_prepare($professor, $query)) {
    mysqli_stmt_bind_param($professor,"i", $_SESSION['id_utilizador']);
    mysqli_stmt_execute($professor);
    mysqli_stmt_bind_result($professor, $tipoperfil, $turma);
    mysqli_stmt_fetch($professor);
    mysqli_stmt_close($professor);
}

if ($tipoperfil == 3) {
    $stmt = mysqli_stmt_init($link);
    mysqli_stmt_prepare($stmt, "SELECT id_utilizador, nome FROM utilizadores WHERE ref_perfis = 2");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nome);
} else if ($tipoperfil == 1){
    $stmt = mysqli_stmt_init($link);
    mysqli_stmt_prepare($stmt, "SELECT id_utilizador, nome FROM utilizadores WHERE ref_perfis = 2 AND ref_turmas = $turma");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nome);
}



echo '<div class="container ">
    <div class="row justify-content-center">';
while (mysqli_stmt_fetch($stmt)) {
    echo '
        <div class="col-md-4 mb-md-0 mt-5">
            <div class="card pb-2 h-100 shadow rounded">
                <div class="card-body text-center">
                    <div class="tipo-filme mb-0 fw-bolder text-black-50">' . $nome . '</div>
                    <a href="admin_scripts/sc_apagar_aluno.php?id=' . $id . '" class="mt-2 btn btn-outline-secondary tipo-filme mb-0 small text-black-50">
                        <b><i class="text-primary">Apagar</i></b>
                    </a>
                </div>
            </div>
        </div>
        ';
}
echo '</div>
      </div>';


?>
