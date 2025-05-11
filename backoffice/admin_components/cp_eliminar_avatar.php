<div class="mt-5 container">
    <div class='mb-3'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
    <h3 class="ps-2">Escolhe que avatar apagar</h3>
</div>
<?php
include_once "cp_head.php";
include_once "cp_navbar.php";

include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT imagem, id_avatar from avatares");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $imagem, $id);


echo '<div class="container ">
    <div class="row justify-content-center">';
while (mysqli_stmt_fetch($stmt)) {
    echo '
        <div class="col-md-4 mb-md-0 mt-5">
            <div class="card pb-2 h-100 shadow rounded">
                <div class="card-body text-center">
                    <img src="../imgs/' . $imagem . '" class="img-fluid " style="max-width:200px; max-height: 200px" alt="Image">
                </div>
                <div class=" text-center">
                    <a href="admin_scripts/sc_apagar_avatar.php?id=' . $id . '" class=" btn btn-outline-secondary tipo-filme mb-0 small text-black-50">
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
