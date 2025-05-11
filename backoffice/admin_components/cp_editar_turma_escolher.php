<div class="mt-5 container">
    <div class='mb-3'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
    <h3 class="ps-2">Escolhe que turma editar</h3>
</div>
<?php
include_once "cp_head.php";
include_once "cp_navbar.php";

include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT id_turma, ano, letra FROM turmas");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $ano, $letra);
echo '<div class="container ">
    <div class="row justify-content-center">';
while (mysqli_stmt_fetch($stmt)) {
    echo '
        <div class="col-md-4 mb-md-0 mt-5">
            <div class="card pb-2 h-100 shadow rounded">
                <div class="card-body text-center">
                    <div class="tipo-filme mb-0 fw-bolder text-black-50">' . $ano . '' . $letra . '</div>
                    <a href="editar_turma.php?id=' . $id . '" class="mt-2 btn btn-outline-secondary tipo-filme mb-0 small text-black-50">
                        <b><i class="text-primary">Editar</i></b>
                    </a>
                </div>
            </div>
        </div>
        ';
}
echo '</div>
      </div>';

mysqli_stmt_close($stmt);
mysqli_close($link);
?>
