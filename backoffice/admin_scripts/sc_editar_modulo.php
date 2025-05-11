<?php
include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];
$titulo = $_POST['titulo'];
$codigo = $_POST['codigo'];
$intro = $_POST['intro'];
$sabias_que = $_POST['sabias_que'];

$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT ref_infos FROM modulos WHERE id_modulo = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $info);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$stmt_modulos = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt_modulos, "UPDATE modulos SET titulo = ?, codigo = ? WHERE id_modulo = ?");
mysqli_stmt_bind_param($stmt_modulos, "ssi", $titulo, $codigo, $id);
mysqli_stmt_execute($stmt_modulos);
mysqli_stmt_close($stmt_modulos);

$stmt_infos = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt_infos, "UPDATE infos SET intro = ?, sabias_que = ? WHERE id_info = ?");
mysqli_stmt_bind_param($stmt_infos, "ssi", $intro, $sabias_que, $info);
mysqli_stmt_execute($stmt_infos);
mysqli_stmt_close($stmt_infos);

mysqli_close($link);
header("Location: ../editar_modulo_escolher.php");

?>
