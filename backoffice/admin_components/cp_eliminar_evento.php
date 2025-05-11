<div class="mt-5 container">
    <div class='mb-3'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
    <h3 class="ps-2">Escolhe que evento apagar</h3>
</div>
<?php
include_once "cp_head.php";
include_once "cp_navbar.php";



include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT nome, id_evento, local from eventos");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome, $id, $local);


echo '<div class="container ">
    <div class="row justify-content-center">';
while (mysqli_stmt_fetch($stmt)) {
    echo '
        <div class="col-md-4 mb-md-0 mt-5">
            <div class="card pb-2 h-100 shadow rounded">
                <div class="card-body text-center">
                    <div class="tipo-filme mb-0 fw-bolder text-black-50">
                        <span class="nome" style="display: block; margin-bottom: 10px;">' . $nome . '</span>
                        <span class="local" style="display: block;">' . $local . '</span>
                    </div>
                    <a href="admin_scripts/sc_apagar_evento.php?id=' . $id . '" class="mt-2 btn btn-outline-secondary tipo-filme mb-0 small text-black-50">
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
<?php
