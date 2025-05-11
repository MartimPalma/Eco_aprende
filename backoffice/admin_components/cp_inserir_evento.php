<?php
include_once "cp_head.php";
include_once "cp_navbar.php";
include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

$professor = mysqli_stmt_init($link);
$query = "SELECT ref_perfis, ref_turmas FROM utilizadores WHERE id_utilizador = ?";
if (mysqli_stmt_prepare($professor, $query)) {
    mysqli_stmt_bind_param($professor,"i", $_SESSION['id_utilizador']);
    mysqli_stmt_execute($professor);
    mysqli_stmt_bind_result($professor, $tipoperfil, $turma);
    mysqli_stmt_fetch($professor);
    mysqli_stmt_close($professor);
}
?>

<!-- Form -->
<div class="mt-5 container">
    <div class="mb-3"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
    <h3 class="ps-2">Insere as informações do novo evento</h3>
    <div class="d-flex justify-content-center">
        <form class="col-12" action="admin_scripts/sc_inserir_evento.php" method="post" class="was-validated">
            <div class="mb-3 mt-3">
                <label for="nome" class="form-label">Nome:*</label>
                <input type="text" class="form-control" id="nome" value="" name="nome" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-4">
                <label for="local" class="form-label">Local:*</label>
                <input class="form-control" id="local" value="" name="local" rows="5" required></input>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="descricao" class="form-label">Descrição:*</label>
                <textarea type="text" class="form-control" id="descricao" value="" name="descricao" required></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="turma" class="form-label">Turma:*</label>
                <select class="form-select" id="turma" name="turma" required>
                    <?php
                    if ($tipoperfil == 1) {
                        mysqli_stmt_prepare($stmt, "SELECT id_turma, letra, ano FROM turmas WHERE id_turma = $turma");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $letra, $ano);
                        while (mysqli_stmt_fetch($stmt)) {
                            echo '<option value="' . $id . '">' . $ano . '' . $letra . '</option>';
                        }
                    } else if ($tipoperfil == 3){
                        mysqli_stmt_prepare($stmt, "SELECT id_turma, letra, ano FROM turmas ");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $letra, $ano);
                        while (mysqli_stmt_fetch($stmt)) {
                            echo '<option value="' . $id . '">' . $ano . '' . $letra . '</option>';
                        }
                    }
                    ?>
                    }

                </select>
            </div>
            <div class="mb-3 mt-4">
                <label for="data" class="form-label">Data:*</label>
                <input class="form-control" id="data" value="" name="data" type="datetime-local" required></input>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-5 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg w-25">Inserir</button>
            </div>
        </form>
    </div>
</div>
