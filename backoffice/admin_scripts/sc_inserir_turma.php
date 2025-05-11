<?php
include_once "../../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$ano = $_POST['ano'];
$letra = $_POST['letra'];
$codigo = $_POST['codigo'];
$escola = $_POST['escola'];
mysqli_stmt_prepare($stmt, "INSERT INTO turmas (ano, letra, codigo_acesso, ref_escolas) VALUES (?,?,?,?)") ;
mysqli_stmt_bind_param($stmt, 'issi', $ano,$letra,$codigo,$escola);
mysqli_stmt_execute($stmt);
header("Location: ../inserir_turma.php");
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
