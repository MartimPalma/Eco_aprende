<?php
include_once "../../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$nome = $_POST['nome'];
$email = $_POST['email'];
$turma = $_POST['turma'];
$query = "INSERT INTO utilizadores (nome, email, ref_turmas, ref_perfis) VALUES (?,?,?,1)";
mysqli_stmt_prepare($stmt, $query) ;
var_dump($query);
mysqli_stmt_bind_param($stmt, 'ssi', $nome,$email,$turma);
mysqli_stmt_execute($stmt);
header("Location: ../inserir_docente.php");
mysqli_stmt_close($stmt);
mysqli_close($link);
var_dump($query);

?>
