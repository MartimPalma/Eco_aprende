<body id="page-top">

<?php
include_once "cp_head.php";
include_once "cp_navbar.php";

include_once "../connections/connection.php";
$link = new_db_connection();
$id = $_GET['id'];
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT nome, local, descricao, ref_turmas FROM eventos INNER JOIN eventos_marcados ON id_evento = ref_eventos WHERE id_evento = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome, $local, $descricao, $turma_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$professor = mysqli_stmt_init($link);
$query = "SELECT ref_perfis, ref_turmas FROM utilizadores WHERE id_utilizador = ?";
if (mysqli_stmt_prepare($professor, $query)) {
    mysqli_stmt_bind_param($professor, "i", $_SESSION['id_utilizador']);
    mysqli_stmt_execute($professor);
    mysqli_stmt_bind_result($professor, $tipoperfil, $turma);
    mysqli_stmt_fetch($professor);
    mysqli_stmt_close($professor);
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Form -->
        <div class="mt-5">
            <div class="mb-3"><a class="btn btn-info" onclick="history.back()">Voltar</a></div>
            <h3 class="ps-2">Edita as informações de um evento</h3>
            <div class="d-flex justify-content-center">
                <form class="col-12" action="../backoffice/admin_scripts/sc_editar_evento.php?id=<?php echo $id; ?>" method="post" class="was-validated" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="nome" class="form-label">Nome:*</label>
                        <input type="text" class="form-control" id="titulo" value="<?php echo $nome; ?>" name="nome" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="local" class="form-label">Local:*</label>
                        <input type="text" class="form-control" id="local" value="<?php echo $local; ?>" name="local" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="descricao" class="form-label">Descrição:*</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="5" required><?php echo $descricao; ?></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="turma" class="form-label">Turma:*</label>
                        <select class="form-select" id="turma" name="turma" required>
                            <?php
                            if ($tipoperfil == 1) {
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, "SELECT id_turma, letra, ano FROM turmas WHERE id_turma = ?");
                                mysqli_stmt_bind_param($stmt, "i", $turma);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $id, $letra, $ano);
                                while (mysqli_stmt_fetch($stmt)) {
                                    echo '<option value="' . $id . '">' . $ano . '' . $letra . '</option>';
                                }
                                mysqli_stmt_close($stmt);
                            } else if ($tipoperfil == 3) {
                                $stmt = mysqli_stmt_init($link);
                                mysqli_stmt_prepare($stmt, "SELECT id_turma, letra, ano FROM turmas");
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $id, $letra, $ano);
                                while (mysqli_stmt_fetch($stmt)) {
                                    echo '<option value="' . $id . '">' . $ano . '' . $letra . '</option>';
                                }
                                mysqli_stmt_close($stmt);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-5 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-25">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($link);
?>

</body>


