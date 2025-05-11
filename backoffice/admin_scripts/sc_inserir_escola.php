<?php
include_once "../../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$titulo = $_POST['titulo'];
mysqli_stmt_prepare($stmt, "INSERT INTO escolas (nome) VALUES (?)") ;
mysqli_stmt_bind_param($stmt, 's', $titulo);
mysqli_stmt_execute($stmt);
header("Location: ../inserir_escola.php");
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
