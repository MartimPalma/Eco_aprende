<?php
include_once "../../connections/connection.php";

$link = new_db_connection();
$id = $_GET['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$turma = $_POST['turma'];

$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "UPDATE utilizadores SET nome = ?, email = ?, ref_turmas = ? WHERE id_utilizador = ?");
mysqli_stmt_bind_param($stmt, "ssii", $nome, $email, $turma, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($link);
header("Location: ../editar_aluno_escolher.php");

?>
<?php
