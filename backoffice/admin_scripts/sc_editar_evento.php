<?php
include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];
$nome = $_POST['nome'];
$local = $_POST['local'];
$descricao = $_POST['descricao'];
$turma = $_POST['turma'];


$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "UPDATE eventos SET nome = ?, local = ?, descricao = ? WHERE id_evento = ?");
mysqli_stmt_bind_param($stmt, "sssi", $nome, $local, $descricao , $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$stmt2 = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt2, "UPDATE eventos_marcados SET ref_turmas = ? WHERE ref_eventos = ?");
mysqli_stmt_bind_param($stmt2, "ii", $turma , $id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);
mysqli_close($link);
header("Location: ../editar_evento_escolher.php");

?>
