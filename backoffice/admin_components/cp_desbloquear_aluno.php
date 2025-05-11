<?php
include_once "cp_head.php";
include_once "cp_navbar.php";?>

<?php
include_once "../connections/connection.php";

$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT id_utilizador, nome, email FROM utilizadores WHERE num_tentativas_login = 5");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $nome, $mail);

if (mysqli_stmt_fetch($stmt)) {
    echo '<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-md-0 mt-5">
                <div class="card pb-2 h-100 shadow rounded">
                    <div class="card-body text-center">
                        <div class="tipo-filme mb-0 fw-bolder text-black-50">' . $nome . '</div>
                        <a href="../admin_scripts/sc_desbloquear.php?id=' . $id . '" class="mt-2 btn btn-outline-secondary tipo-filme mb-0 small text-black-50">
                            <b><i class="text-primary">Desbloquear</i></b>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>';
} else{
    echo '  
    <div class="text-center mt-5 pt-5">
      <!-- Your content goes here -->
      <h2>Não há alunos bloqueados</h2>
    </div>
  ';
}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>

