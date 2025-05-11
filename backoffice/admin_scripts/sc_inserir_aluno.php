<?php
include_once "../../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$nome = $_POST['nome'];
$email = $_POST['email'];
$turma = $_POST['turma'];
mysqli_stmt_prepare($stmt, "INSERT INTO utilizadores (nome, email, ref_turmas, ref_perfis) VALUES (?,?,?,2)") ;
mysqli_stmt_bind_param($stmt, 'ssi', $nome,$email,$turma);
mysqli_stmt_execute($stmt);
header("Location: ../inserir_aluno.php");
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
