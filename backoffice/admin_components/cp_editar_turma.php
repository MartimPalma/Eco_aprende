<body id="page-top">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";

include_once "../connections/connection.php";
$link = new_db_connection();
$id = $_GET['id'];
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT ano, letra, codigo_acesso, ref_escolas FROM turmas WHERE id_turma = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ano, $letra, $codigo, $escola_id);
mysqli_stmt_fetch($stmt);

echo '
<div class="container-fluid">
    <div class="row">

        <!-- Form -->
        <div class="mt-5">
            <div class="mb-5"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
            <h3 class="ps-2">Edita as informações de uma turma</h3>
            <div class="d-flex justify-content-center">
                <form class="col-12" action="../backoffice/admin_scripts/sc_editar_turma.php?id=' . $id . '" method="post" class="was-validated" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="ano" class="form-label">Ano:*</label>
                        <input type="text" class="form-control" id="ano" value="' . $ano . '" name="ano" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="letra" class="form-label">Letra:*</label>
                        <input type="text" class="form-control" id="letra" value="' . $letra . '" name="letra" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="codigo" class="form-label">Código:*</label>
                        <input type="text" class="form-control" id="codigo" value="' . $codigo . '" name="codigo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="escola" class="form-label">Escola:*</label>
                        <select class="form-select" id="escola" name="escola" required>';
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT id_escola, nome FROM escolas ");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $escola_id_db, $nome);
while (mysqli_stmt_fetch($stmt)) {
    if ($escola_id == $escola_id_db) {
        $selected = 'selected';
    } else {
        $selected = '';
    }    echo '<option value="' . $escola_id_db . '" ' . $selected . '>' . $nome . '</option>';
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
