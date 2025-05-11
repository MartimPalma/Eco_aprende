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
        <h3 class="ps-2">Desbloqueie um módulo para uma turma</h3>
        <div class="d-flex justify-content-center">
            <form class="col-12" action="admin_scripts/sc_desbloquear_modulo.php" method="post" class="was-validated">
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
                <div class="mb-3 mt-3">
                    <label for="modulo" class="form-label">Módulo:*</label>
                    <select class="form-select" id="modulo" name="modulo" required>
                        <?php
                        mysqli_stmt_prepare($stmt, "SELECT id_modulo, titulo FROM modulos ");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $titulo);
                        while (mysqli_stmt_fetch($stmt)) {
                            echo '<option value="' . $id . '">' . $titulo . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3 mt-5 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg w-25">Desbloquear</button>
                </div>
            </form>
        </div>
    </div>
<?php
