<?php
include_once "cp_head.php";
include_once "cp_navbar.php";
include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
?>

<!-- Form -->
<div class="mt-5 container">
    <div class="mb-3"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
    <h3 class="ps-2">Insere as informações da nova turma</h3>
    <div class="d-flex justify-content-center">
        <form class="col-12" action="admin_scripts/sc_inserir_turma.php" method="post" class="was-validated">
            <div class="mb-3 mt-3">
                <label for="ano" class="form-label">Ano:*</label>
                <input type="text" class="form-control" id="ano" value="" name="ano" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-4">
                <label for="letra" class="form-label">Letra:*</label>
                <input class="form-control" id="letra" value="" name="letra" rows="5" required></input>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="codigo" class="form-label">Codigo de acesso:*</label>
                <input type="text" class="form-control" id="codigo" value="" name="codigo" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="escola" class="form-label">Escola:*</label>
                <select class="form-select" id="escola" name="escola" required>
                    <?php
                    mysqli_stmt_prepare($stmt, "SELECT id_escola, nome FROM escolas ");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id, $nome);
                    while (mysqli_stmt_fetch($stmt)) {
                            echo '<option value="' . $id . '">' . $nome . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-5 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg w-25">Inserir</button>
            </div>
        </form>
    </div>
</div>
