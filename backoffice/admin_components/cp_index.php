<?php
$link = new_db_connection();

$professor = mysqli_stmt_init($link);
$query = "SELECT ref_perfis, ref_turmas FROM utilizadores WHERE id_utilizador = ?";
if (mysqli_stmt_prepare($professor, $query)) {
    mysqli_stmt_bind_param($professor,"i", $_SESSION['id_utilizador']);
    mysqli_stmt_execute($professor);
    mysqli_stmt_bind_result($professor, $tipoperfil, $turma);
    mysqli_stmt_fetch($professor);
    mysqli_stmt_close($professor);
}
$stmt = mysqli_stmt_init($link);

$query = "SELECT turmas.codigo_acesso 
              FROM utilizadores 
              LEFT JOIN turmas ON utilizadores.ref_turmas = turmas.id_turma
              WHERE utilizadores.id_utilizador = ?";
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id_utilizador']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $codigo_acesso);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
function get_total($link, $query) {
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $total);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $total;
    } else {
        mysqli_stmt_close($stmt);
        return 0;
    }
}
// Consultas SQL
$query_escolas = "SELECT COUNT(id_escola) as total_escolas FROM escolas ";
$query_turmas = "SELECT COUNT(id_turma) as total_turmas FROM turmas ";
$query_alunos = "SELECT COUNT(id_utilizador) as total_alunos FROM utilizadores WHERE ref_perfis = 2";
$query_professores = "SELECT COUNT(id_utilizador) as total_professores FROM utilizadores WHERE ref_perfis = 1";
$query_modulo1 = "SELECT COUNT(*) AS modulo1 FROM modulos_concluidos WHERE ref_modulos = 1";
$query_modulo2 = "SELECT COUNT(*) AS modulo2 FROM modulos_concluidos WHERE ref_modulos = 2";
$query_modulo3 = "SELECT COUNT(*) AS modulo3 FROM modulos_concluidos WHERE ref_modulos = 3";
$query_modulo4 = "SELECT COUNT(*) AS modulo4 FROM modulos_concluidos WHERE ref_modulos = 4";


// Obter os totais
$total_escolas = get_total($link, $query_escolas);
$total_turmas = get_total($link, $query_turmas);
$total_alunos = get_total($link, $query_alunos);
$total_professores = get_total($link, $query_professores);
$total_modulo1 = get_total($link, $query_modulo1);
$total_modulo2 = get_total($link, $query_modulo2);
$total_modulo3 = get_total($link, $query_modulo3);
$total_modulo4 = get_total($link, $query_modulo4);


$percentagem_modulo1 = ($total_modulo1 / $total_alunos) * 100;
$percentagem_modulo2 = ($total_modulo2 / $total_alunos) * 100;
$percentagem_modulo3 = ($total_modulo3 / $total_alunos) * 100;
$percentagem_modulo4 = ($total_modulo4 / $total_alunos) * 100;


$nome = $_SESSION['nome'];
$avatar = $_SESSION['ref_avatares'];
mysqli_close($link);

?>
<html>
<head>

    <!-- Custom styles for this template-->
    <link href="../backoffice/css_admin/sb-admin-2.min.css" rel="stylesheet">

    <!-- Js para o Gráfico dos eventos-->
    <script src="../js_admin/demo/chart-bar-demo.js"></script>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body id="page-top">
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand topbar mb-4 static-top shadow">
            <h4 class="mb-0 text-gray-800">Bem vindo à página de administrador!</h4>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 h4 d-none d-lg-inline text-gray-600"><?php echo $nome;?></span>
                        <i class="bi bi-person-fill fs-5 mb-3 mt-1"></i>
                    </a>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Content Row -->
            <div class="row">
                <?php if ($tipoperfil == 1) { ?>

                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                            Código da turma
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php if ($codigo_acesso !== null): ?>
                                                <p>Código da turma: <?php echo $codigo_acesso; ?></p>
                                            <?php else: ?>
                                                <?php var_dump($codigo_acesso); ?>
                                                <p>Nenhuma turma associada encontrada.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-code fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>



                <!-- Earnings (Monthly) Card Example -->
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Número de escolas:</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_escolas;?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-school fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Número de turmas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_turmas;?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Número de professores
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_professores;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Número de alunos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_alunos;?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-child fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Content Column -->
                <div class="row justify-content-center">
                    <div class="col-lg-7 mb-4 mt-4 m-0">

                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Módulos completados com sucesso</h6>
                        </div>
                        <div class="card-body">
                            <h4 class="small font-weight-bold">Módulo 1 <span
                                        class="float-right"><?php echo $percentagem_modulo1  ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentagem_modulo1  ?>%"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Módulo 2<span
                                        class="float-right"><?php echo $percentagem_modulo2  ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentagem_modulo2  ?>%"
                                     aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Módulo 3<span
                                        class="float-right"><?php echo $percentagem_modulo3  ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentagem_modulo3  ?>%"
                                     aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Módulo 1 <span
                                        class="float-right"><?php echo $percentagem_modulo4  ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentagem_modulo4  ?>%"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            </div>
                        </div>
                    </div>
        </div>
        <!-- /.container-fluid -->
    </div>
        </div>
    </div>
</div>

    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>EcoAprende ADMIN</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

<!-- End of Page Wrapper -->





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Bootstrap core JavaScript-->
<script src="../pasta_bootstrap_admin/jquery/jquery.min.js"></script>
<script src="../pasta_bootstrap_admin/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../pasta_bootstrap_admin/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js_admin/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../pasta_bootstrap_admin/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js_admin/demo/chart-area-demo.js"></script>
<script src="../js_admin/demo/chart-pie-demo.js"></script>


</body>
</html>
