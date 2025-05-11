
<body id="page-top">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";


include_once "../connections/connection.php";
$link = new_db_connection();
$id = $_GET['id'];
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT nome  FROM escolas WHERE id_escola = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $titulo);



while (mysqli_stmt_fetch($stmt)) {
    echo '
<div class="container-fluid">
    <div class="row">

        <!-- Form -->
        <div class="mt-5">
            <div class="mb-5"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
            <h3 class="ps-2">Edita as informações de um módulo</h3>
            <div class="d-flex justify-content-center">
                <form class="col-12" action="../backoffice/admin_scripts/sc_editar_escola.php?id=' . $id . '" method="post" class="was-validated" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="titulo" class="form-label">Título:*</label>
                        <input type="text" class="form-control" id="titulo" value="' . $titulo . '" name="titulo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-5 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-25">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';}



?>