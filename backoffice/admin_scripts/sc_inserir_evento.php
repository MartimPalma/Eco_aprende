<?php
include_once "../../connections/connection.php";
$link = new_db_connection();

$nome = $_POST['nome'];
$local = $_POST['local'];
$descricao = $_POST['descricao'];
$turma = $_POST['turma'];
$data = $_POST['data'];


$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "INSERT INTO eventos (nome, local, descricao) VALUES (?,?,?)");
mysqli_stmt_bind_param($stmt, 'sss', $nome, $local, $descricao);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$id2 = mysqli_insert_id($link);

$stmt3 = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt3, "INSERT INTO eventos_marcados (ref_eventos, ref_turmas, data) VALUES (?,?, ?)");
mysqli_stmt_bind_param($stmt3, 'iis', $id2, $turma, $data);
mysqli_stmt_execute($stmt3);
mysqli_stmt_close($stmt3);

mysqli_close($link);
header("Location: ../inserir_evento.php");
?>
