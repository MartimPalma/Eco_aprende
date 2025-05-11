<body id="page-top">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";

include_once "../connections/connection.php";
$link = new_db_connection();
$id = $_GET['id'];
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT nome, email, ref_turmas FROM utilizadores WHERE id_utilizador = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome, $email, $turma_id);
mysqli_stmt_fetch($stmt);

echo '
<div class="container-fluid">
    <div class="row">

        <!-- Form -->
        <div class="mt-5">
            <div class="mb-5"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
            <h3 class="ps-2">Edita as informações de um aluno</h3>
            <div class="d-flex justify-content-center">
                <form class="col-12" action="../backoffice/admin_scripts/sc_editar_docente.php?id=' . $id . '" method="post" class="was-validated" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="nome" class="form-label">Nome:*</label>
                        <input type="text" class="form-control" id="nome" value="' . $nome . '" name="nome" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:*</label>
                        <input type="text" class="form-control" id="email" value="' . $email . '" name="email" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="turma" class="form-label">Turma:*</label>
                        <select class="form-select" id="turma" name="turma" required>';
// Fetch all schools
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT id_turma, ano, letra FROM turmas ");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $turma_id_db, $ano, $letra);
while (mysqli_stmt_fetch($stmt)) {
    if ($turma_id == $turma_id_db) {
        $selected = 'selected';
    } else {
        $selected = '';
    }    echo '<option value="' . $turma_id_db . '" ' . $selected . '>' . $letra . '</option>';
}
echo                '</select>
                    </div>
                    <div class="mb-3 mt-5 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-25">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
?>

