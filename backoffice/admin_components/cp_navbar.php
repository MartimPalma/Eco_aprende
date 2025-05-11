<?php
session_start();

include_once "../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$query = "SELECT ref_perfis FROM utilizadores WHERE id_utilizador = ?";
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt,"i", $_SESSION['id_utilizador']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $tipoperfil);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Side Bar EcoAprende</title>

</head>

<body id="page-top">
<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary ">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/admin.php">
            <div class="navbar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="navbar-brand-text mx-3">EcoAPRENDE Admin</div>
        </a>
        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/admin.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <!-- Dropdown Menu for Módulos -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="modulosDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-book"></i>
                        Módulos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="modulosDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_modulo.php">Inserir Módulos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_modulo_escolher.php">Editar Módulos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_modulo.php">Apagar Módulos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/desbloquear_modulo.php">Desbloquear Módulos</a></li>
                    </ul>
                </li>
                <?php if ($tipoperfil == 3){
                    echo ' <!-- Dropdown Menu for Avatares -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="avataresDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person"></i>
                        Avatares
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="avataresDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_avatar.php">Inserir Avatares</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_avatar.php">Apagar Avatares</a></li>
                    </ul>
                </li>
                <!-- Dropdown Menu for Escolas -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="escolasDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-house"></i>
                        Escolas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="escolasDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_escola.php">Inserir Escolas</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_escola_escolher.php">Editar Escolas</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_escola.php">Apagar Escolas</a></li>
                    </ul>
                </li>
                <!-- Dropdown Menu for Turmas -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="turmasDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bookmark"></i>
                        Turmas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="turmasDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_turma.php">Inserir Turmas</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_turma_escolher.php">Editar Turmas</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_turma.php">Apagar Turmas</a></li>
                    </ul>
                </li>
                           <!-- Dropdown Menu for Escolas -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="escolasDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-journal-text"></i>
                        Docentes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="escolasDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_docente.php">Inserir Docentes</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_docente_escolher.php">Editar Docentes</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_docente.php">Apagar Docentes</a></li>
                    </ul>
                </li>';
                } ?>

                <!-- Dropdown Menu for Eventos -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="eventosDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-calendar2-event"></i>
                        Eventos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="eventosDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_evento.php">Inserir Eventos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_evento_escolher.php">Editar Eventos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_evento.php">Apagar Eventos</a></li>
                    </ul>
                </li>
                <!-- Dropdown Menu for Alunos -->
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="alunosDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-unlock"></i>
                        Alunos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="alunosDropdown">
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/inserir_aluno.php">Inserir Alunos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/editar_aluno_escolher.php">Editar Alunos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/apagar_aluno.php">Apagar Alunos</a></li>
                        <li><a class="dropdown-item" href="/deca_24_bdtss/deca_24_BDTSS_28/eco_aprende/backoffice/desbloquear_aluno.php">Desbloquear Alunos</a></li>
                    </ul>
                </li>

            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mt-2 ms-3 text-white"><a class="text-white text-decoration-none" href="../scripts/sc_logout.php">LOGOUT</a></li>
            </ul>

        </div>
    </div>
</nav>

<!-- End of Navbar -->
</body>

