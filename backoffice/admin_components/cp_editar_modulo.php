
<body id="page-top">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";


include_once "../connections/connection.php";
$link = new_db_connection();
$id = $_GET['id'];
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT titulo, capa, codigo, sabias_que, video, intro FROM modulos INNER JOIN infos on ref_infos = id_info WHERE id_modulo = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $titulo, $capa, $codigo, $sabias_que, $video, $intro);



while (mysqli_stmt_fetch($stmt)) {
    echo '

<div class="container-fluid">
    <div class="row">

        <!-- Form -->
        <div class="mt-5">
            <div class="mb-3"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
            <h3 class="ps-2">Edita as informações de um módulo</h3>
            <div class="d-flex justify-content-center">
                <form class="col-12" action="../backoffice/admin_scripts/sc_editar_modulo.php?id=' . $id . '" method="post" class="was-validated" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="titulo" class="form-label">Título:*</label>
                        <input type="text" class="form-control" id="titulo" value="' . $titulo . '" name="titulo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="capa" class="form-label">Capa:*</label>
                        <input type="file" class="form-control" id="capa" name="capa"  >
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="video" class="form-label">Vídeo:*</label>
                        <input type="file" class="form-control" id="video" name="video" >
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="codigo" class="form-label">Código de acesso:*</label>
                        <input type="text" class="form-control" id="codigo" value="' . $codigo . '" name="codigo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="intro" class="form-label">Intro:*</label>
                        <textarea class="form-control" id="intro" name="intro" rows="5" required>' . $intro . '</textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="sabias_que" class="form-label">Sabias que:*</label>
                        <textarea class="form-control" id="sabias_que" name="sabias_que" rows="5" required>' . $sabias_que . '</textarea>
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