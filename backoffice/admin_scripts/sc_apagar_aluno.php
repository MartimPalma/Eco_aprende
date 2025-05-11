<?php

// conexão à base de dados
include_once "../../connections/connection.php";

$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

mysqli_query($link, "SET FOREIGN_KEY_CHECKS=0;");



$id = $_GET['id'];
mysqli_stmt_prepare($stmt, "DELETE FROM utilizadores WHERE id_utilizador = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_query($link, "SET FOREIGN_KEY_CHECKS=1;");


mysqli_close($link);
header("Location: ../apagar_aluno.php");

?>