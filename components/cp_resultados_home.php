<?php
    include_once "./connections/connection.php";
    session_start();

    if (isset($_SESSION['id_utilizador']) && isset($_GET['id_modulo'])) {
        $id_utilizador = $_SESSION['id_utilizador'];
        $id_modulo = $_GET['id_modulo'];

        $link = new_db_connection();

        // Verificar se o módulo já foi concluído pelo utilizador
        $check_query = "SELECT concluido FROM modulos_concluidos WHERE ref_modulos = ? AND ref_utilizadores = ?";
        $stmt_check = mysqli_stmt_init($link);

        if (mysqli_stmt_prepare($stmt_check, $check_query)) {
            mysqli_stmt_bind_param($stmt_check, 'ii', $id_modulo, $id_utilizador);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_bind_result($stmt_check, $concluido);
            mysqli_stmt_fetch($stmt_check);
            mysqli_stmt_close($stmt_check);

            if ($concluido == 1) {
                // Módulo concluído, continuar com a consulta principal
                $query = "SELECT modulos.titulo,resultados.pontuacao,perguntas.pergunta 
                          FROM resultados 
                          INNER JOIN perguntas ON resultados.ref_perguntas = perguntas.id_pergunta
                          INNER JOIN modulos ON perguntas.ref_modulos = modulos.id_modulo
                          WHERE modulos.id_modulo = ? AND resultados.ref_utilizadores = ?";

                $stmt = mysqli_stmt_init($link);

                // Verificar se a preparação da consulta foi bem-sucedida
                if (mysqli_stmt_prepare($stmt, $query)) {
                    // Bind dos parâmetros
                    mysqli_stmt_bind_param($stmt, 'ii', $id_modulo, $id_utilizador);

                    // Executar a ligação
                    mysqli_stmt_execute($stmt);

                    // Bind dos resultados
                    mysqli_stmt_bind_result($stmt, $titulo, $pontuacao, $pergunta);

                    // Preencher um array com os dados
                    $resultados = [];
                    $total_pontos = 0;
                    $total_perguntas = 0;

                    while (mysqli_stmt_fetch($stmt)) {
                        $resultados[] = [
                            'pontuacao' => $pontuacao,
                            'pergunta' => $pergunta
                        ];
                        //adiciona o valor atual de $pontuacao à variável $total_pontos
                        $total_pontos += $pontuacao;
                        $total_perguntas++;
                    }

                    // Calcular a pontuação total em percentagem
                    $resultado_percentual = ($total_perguntas > 0) ? ($total_pontos / ($total_perguntas * 10)) * 100 : 0;

                    // Fechar a ligação
                    mysqli_stmt_close($stmt);

                    // Buscar todos os módulos concluídos pelo utilizador
                    $modulos_query = "SELECT ref_modulos FROM modulos_concluidos WHERE ref_utilizadores = ? AND concluido = 1 ORDER BY ref_modulos";
                    $stmt_modulos = mysqli_stmt_init($link);

                    if (mysqli_stmt_prepare($stmt_modulos, $modulos_query)) {
                        mysqli_stmt_bind_param($stmt_modulos, 'i', $id_utilizador);
                        mysqli_stmt_execute($stmt_modulos);
                        mysqli_stmt_bind_result($stmt_modulos, $modulo_concluido);

                        // array para armazenar os módulos concluídos
                        $modulos_concluidos = [];
                        while (mysqli_stmt_fetch($stmt_modulos)) {
                            $modulos_concluidos[] = $modulo_concluido;
                        }

                        mysqli_stmt_close($stmt_modulos);

                        //procurar pelo valor $id_modulo dentro do array $modulos_concluidos e retornará o índice do elemento se ele for encontrado.
                        $index = array_search($id_modulo, $modulos_concluidos);

                        $proximo_modulo = isset($modulos_concluidos[$index + 1]) ? $modulos_concluidos[$index + 1] : null;
                        $antes_modulo = isset($modulos_concluidos[$index - 1]) ? $modulos_concluidos[$index - 1] : null;

                        /* if (isset($modulos_concluidos[$index + 1])) {
                                $proximo_modulo = $modulos_concluidos[$index + 1];
                            } else {
                                $proximo_modulo = null;
                            }

                            if (isset($modulos_concluidos[$index - 1])) {
                                $antes_modulo = $modulos_concluidos[$index - 1];
                            } else {
                                $antes_modulo = null;
                            }
                        */
                    }
                } else {
                    echo "Erro na preparação da consulta.";
                }
            } else {
                // Módulo não concluído, redirecionar para a página inicial com mensagem de erro
                // aparece um alerta e redireciona para a página inicial
                echo "<script>alert('Este módulo ainda não foi concluído.'); window.location.href = './index.php';</script>";
                exit;
            }
        } else {
            echo "Erro na preparação da consulta de verificação.";
        }

        mysqli_close($link);
    } else {
        echo "ID inválido ou sessão expirada.";
        exit;
    }
?>

<style>
    .container {
        margin-top: 5%;
    }
    .module-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }
    .results-table {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
    }
    .results-table th, .results-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    .results-table th {
        background-color: #f2f2f2;
    }
    .result-icon {
        font-size: 24px;
    }
    .result-icon.correct {
        color: green;
    }
    .result-icon.incorrect {
        color: red;
    }
    .final-result {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
    }
    .btn {
        margin-top: 20px;
    }
</style>

<div class="fundoBranco">
<section class="container d-flex flex-column justify-content-center align-items-center">
    <div class="row justify-content-center w-100">
        <div class="module-title">
            <?= $titulo ?>
        </div>
    </div>

    <div class="table-responsive w-100">
        <table class="table results-table">
            <thead>
            <tr>
                <?php foreach ($resultados as $index => $resultado): ?>
                    <th><?= $index + 1 ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php foreach ($resultados as $resultado): ?>
                    <td>
                        <?php if ($resultado['pontuacao'] == 10): ?>
                            <span class="result-icon correct">&#10003;</span>
                        <?php else: ?>
                            <span class="result-icon incorrect">&#10005;</span>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($resultados as $resultado): ?>
                    <td><?= $resultado['pontuacao'] ?></td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="final-result">
        Resultado: <?= number_format($resultado_percentual, 2) ?>%
    </div>

    <!-- Navegação entre módulos -->
    <div class="row justify-content-between w-100">
        <?php if ($antes_modulo): ?>
            <a class="btn btn-secondary btn-lg col-3 fundoAzulEscuro borda_azul_clara fw-bold" href="?id_modulo=<?= $antes_modulo ?>">MÓDULO ANTERIOR</a>
        <?php else: ?>
            <div class="col-3"></div>
        <?php endif; ?>


        <?php if ($proximo_modulo): ?>
            <a class="btn btn-secondary btn-lg col-3 borda_azul_escura fundoAzulClaro letrasEscuro fw-bold" href="?id_modulo=<?= $proximo_modulo ?>">PRÓXIMO MÓDULO</a>
        <?php else: ?>
            <div class="col-3"></div> <!-- Espaço vazio -->
        <?php endif; ?>
    </div>
</section>
</div>
