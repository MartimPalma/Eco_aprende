<?php
include_once "./connections/connection.php";

    // recebe o id do módulo e da 1 pergunta
    if (isset($_GET['id_modulo']) && isset($_GET['pergunta_id'])) {

        $id_modulo = $_GET['id_modulo'];
        $pergunta_id_get = $_GET['pergunta_id'];

        // Debug: Exibir os parâmetros recebidos
        //echo "ID Módulo: $id_modulo<br>";
        //echo "ID Pergunta: $pergunta_id_get<br>";

        $link = new_db_connection();

        $query = "
                SELECT perguntas.id_pergunta, perguntas.pergunta, perguntas.imagem, opcoes.id_opcoes, opcoes.opcao, opcoes.correta
                FROM perguntas 
                JOIN opcoes ON perguntas.id_pergunta = opcoes.ref_perguntas
                WHERE perguntas.ref_modulos = ? AND perguntas.id_pergunta = ?
            ";

        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, 'ii', $id_modulo, $pergunta_id_get);
            mysqli_stmt_execute($stmt);
            //mysqli_stmt_store_result($stmt); // Adicionado para verificar o número de resultados
            //$num_rows = mysqli_stmt_num_rows($stmt); // Adicionado para verificar o número de resultados
            mysqli_stmt_bind_result($stmt, $pergunta_id, $pergunta, $imagem, $opcao_id, $opcao, $correta);

            // Debug: Exibir o número de resultados retornados
            //echo "Número de resultados: $num_rows<br>";

            $perguntas = [];

            while (mysqli_stmt_fetch($stmt)) {
                /* Debug: Exibir os dados recebidos da consulta
                echo "Pergunta ID: $pergunta_id<br>";
                echo "Pergunta: $pergunta<br>";
                echo "Imagem: $imagem<br>";
                echo "Opção ID: $opcao_id<br>";
                echo "Opção: $opcao<br>";
                echo "Correta: $correta<br><br>";*/

                //  verifica se a pergunta com o ID $pergunta_id já existe no array $perguntas
                if (!isset($perguntas[$pergunta_id])) {
                    $perguntas[$pergunta_id] = [
                        'pergunta' => $pergunta,
                        'imagem' => $imagem,
                        // array para armazenar as opções da pergunta
                        'opcoes' => []
                    ];
                }
                // adiciona uma nova opção ao array de opções da pergunta específica
                $perguntas[$pergunta_id]['opcoes'][] = [
                    'id' => $opcao_id,
                    'opcao' => $opcao,
                    'correta' => $correta
                ];
                /* Exemplo de como ficam os dados de $perguntas
                    $perguntas = [
                            1 => [
                                'pergunta' => 'Qual é a capital da França?',
                                'imagem' => 'imagem.jpg',
                                'opcoes' => [
                                    [
                                        'id' => 1,
                                        'opcao' => 'Paris',
                                        'correta' => true
                                    ],
                                    [
                                        'id' => 2,
                                        'opcao' => 'Londres',
                                        'correta' => false
                                    ],
                                    [
                                        'id' => 3,
                                        'opcao' => 'Roma',
                                        'correta' => false
                                    ],
                                    [
                                        'id' => 4,
                                        'opcao' => 'Berlim',
                                        'correta' => false
                                    ]
                                ]
                            ]
                        ];
                */
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da consulta.";
            exit;
        }
        mysqli_close($link);
    } else {
        echo "ID inválido.";
        //var_dump($_GET['id_modulo'], $_GET['pergunta_id']);
        exit;
    }
?>

<body class="fundoBranco">

<section class="container mt-5 p-3 rounded-3 ">
    <?php if (!empty($perguntas)): ?>
        <?php foreach ($perguntas as $pergunta_id => $pergunta_data): ?>
            <div>
                <h1 class="fw-bold"><?= $pergunta_data['pergunta'] ?></h1>

                <?php if (!empty($pergunta_data['imagem'])): ?>
                    <div class="text-center w-100">
                        <img src="./imgs/<?= $pergunta_data['imagem'] ?>" alt="Imagem da pergunta" class="my-4 rounded-3 full-width-image">
                    </div>
                <?php endif; ?>

                <!-- chama a função quando o botão for clicado -->
                <form onsubmit="updateFormAction(this);" method="get" action="./scripts/sc_processar_resposta.php">
                    <div class="row">
                        <?php foreach ($pergunta_data['opcoes'] as $opcao): ?>
                            <div class="col-md-6">
                                <!--ao clicar no botão, chama a função selectOption , passando o botão e a opção correta-->
                                <!-- atributo data-correta = 1 ou 0, para verificar se a opção clicada é a correta-->
                                <button type="button" class="option-button btn btn-outline-primary text-dark fundoAzul" onclick="selectOption(this, <?= $opcao['correta'] ?>)" data-value="<?= $opcao['id'] ?>" data-correta="<?= $opcao['correta'] ?>">
                                    <?= $opcao['opcao'] ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!--dados enviados quando o formulário é submetido , para o script sc_processar_resposta-->
                    <!--campos estao ocultos-->
                    <input type="hidden" name="resposta" value="">
                    <input type="hidden" name="pergunta_id" value="<?= $pergunta_id ?>">
                    <input type="hidden" name="id_modulo" value="<?= $id_modulo ?>">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary btn-lg mt-5 letrasEscuro fw-bold fundoAzulClaro borda_azul_escura" value="Próxima Pergunta">
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma pergunta encontrada.</p>
    <?php endif; ?>
</section>


<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-5" id="feedbackMessage">
                <!-- Feedback -->
            </div>
        </div>
    </div>
</div>


<style>
    .full-width-image {
        width: 100%;
        height: auto;
    }
    .modal-content.correct {
        background-color: green;
        color: white;
    }
    .modal-content.incorrect {
        background-color: red;
        color: white;
    }
    .modal-body {
        font-size: 1.5rem;
    }
    .margem {
        margin-top: 50px;
    }
    .w-100 {
        width: 100% !important;
    }
</style>



</body>

<script>
    function selectOption(button, correta) {
        var buttons = button.closest('form').querySelectorAll('.option-button');

        buttons.forEach(btn => {
            btn.disabled = true;  // desabilita todos os botões
            btn.classList.remove('btn-primary', 'selected', 'bg-dark', 'btn-outline-primary');

            if (btn.getAttribute('data-correta') == '1') {
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-primary');
            } else {
                btn.classList.add('btn-danger');
                btn.classList.remove('btn-outline-primary');
            }
        });

        button.classList.add('selected');
        button.classList.remove('btn-outline-primary');
        button.closest('form').querySelector('input[name="resposta"]').value = button.getAttribute('data-value');

        // mensagem feedback
        var feedbackMessage = document.getElementById('feedbackMessage');
        var modalContent = document.querySelector('.modal-content');
        modalContent.classList.remove('correct', 'incorrect');

        if (correta) {
            feedbackMessage.innerHTML = 'Muito bem!<br>Ganhaste 10 pontos!';
            modalContent.classList.add('correct');
        } else {
            feedbackMessage.innerHTML = 'Oh!<br>A tua resposta está incorreta.';
            modalContent.classList.add('incorrect');
        }

        // Show the modal
        $('#feedbackModal').modal('show');
    }

    function updateFormAction(form) {
        const resposta = form.querySelector('input[name="resposta"]').value;
        const pergunta_id = form.querySelector('input[name="pergunta_id"]').value;
        const id_modulo = form.querySelector('input[name="id_modulo"]').value;

        form.action = `./scripts/sc_processar_resposta.php?resposta=${resposta}&pergunta_id=${pergunta_id}&id_modulo=${id_modulo}`;
    }
</script>

<!-- Include Bootstrap JS (ensure you have jQuery included before this) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
