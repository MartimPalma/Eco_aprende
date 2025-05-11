<?php
include_once "../../connections/connection.php";
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
$turma = $_POST['turma'];
$modulo = $_POST['modulo'];
mysqli_stmt_prepare($stmt, "INSERT INTO modulos_desbloqueados (ref_turmas, ref_modulos) VALUES (?,?)") ;
mysqli_stmt_bind_param($stmt, 'ii', $turma,$modulo);
mysqli_stmt_execute($stmt);
header("Location: ../desbloquear_modulo.php");
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

