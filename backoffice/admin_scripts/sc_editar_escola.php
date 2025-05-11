<?php
include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];
$nome = $_POST['titulo'];

$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "UPDATE escolas SET nome = ? WHERE id_escola = ?");
mysqli_stmt_bind_param($stmt, "si", $nome, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($link);
header("Location: ../editar_escola_escolher.php");

?>
