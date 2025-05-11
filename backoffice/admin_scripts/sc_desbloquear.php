<?php

include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];



$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "UPDATE utilizadores SET num_tentativas_login = 0 WHERE id_utilizador = ?");
mysqli_stmt_bind_param($stmt, "i",$id);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($link);

header("Location: ../desbloquear_aluno.php");

