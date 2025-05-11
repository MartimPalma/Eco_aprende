<?php
include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];
$ano = $_POST['ano'];
$letra = $_POST['letra'];
$codigo = $_POST['codigo'];
$escola = $_POST['escola'];

$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "UPDATE turmas SET ano = ?, letra = ?, codigo_acesso = ?, ref_escolas = ? WHERE id_turma = ?");
mysqli_stmt_bind_param($stmt, "issii", $ano, $letra, $codigo, $escola, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($link);
header("Location: ../editar_turma_escolher.php");

?>
