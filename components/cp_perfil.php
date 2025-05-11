<?php

    session_start();
    include_once "./connections/connection.php";


    $link = new_db_connection();

    // buscar todos os dados associados ao utilizador
    $query = "SELECT utilizadores.nome, escolas.nome AS escola, perfis.tipo AS estatuto, turmas.ano, turmas.letra, avatares.imagem 
              FROM utilizadores
              INNER JOIN turmas ON utilizadores.ref_turmas = turmas.id_turma
              INNER JOIN escolas ON turmas.ref_escolas = escolas.id_escola
              INNER JOIN perfis ON utilizadores.ref_perfis = perfis.id_perfil
              LEFT JOIN avatares ON utilizadores.ref_avatares = avatares.id_avatar
              WHERE utilizadores.id_utilizador = ?";

    $stmt = mysqli_stmt_init($link);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id_utilizador']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $nome, $escola, $estatuto, $ano, $letra, $imagem);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    } else {
        echo "Erro a preparar statement: " . mysqli_error($link);
    }
?>


<section class="container mt-5 ps-5">
    <div class="row">
        <div class="card col-md-4 fundoCinzento h-50">
            <div class="profile-card text-center">
                <img src="./imgs/<?= $imagem ?>" alt="Avatar Image" class="rounded-circle mb-3 mt-2" style="height: 180px; width: 170px">
                <h2 class="mb-4 letrasEscuro">Olá, <span style="color: #87CEEB;"><?= $nome  ?>!</span></h2>
                <p>
                    <strong style="color: #145167;">Escola:</strong>
                    <br> <?= $escola ?>
                </p>
                <p>
                    <strong style="color: #145167;">Estatuto:</strong>
                    <br> <?= $estatuto ?>
                </p>
                <p>
                    <strong style="color: #145167;">Turma:</strong>
                    <br> <?= $ano . 'º' . $letra ?>
                </p>
            </div>

            <div class="text-center mt-3 mb-3">
                <a href="./scripts/sc_logout.php" class="btn btn-danger fw-bold">LOGOUT</a>
            </div>

        </div>

        <div class="col-md-8 ">
                <div class="calendar">
                    <header>
                        <pre class="left">◀</pre>

                        <div class="header-display">
                            <p class="display">""</p>
                        </div>

                        <pre class="right">▶</pre>

                    </header>

                    <div class="week">
                        <div>Su</div>
                        <div>Mo</div>
                        <div>Tu</div>
                        <div>We</div>
                        <div>Th</div>
                        <div>Fr</div>
                        <div>Sa</div>
                    </div>
                    <div class="days"></div>
                </div>
                <div class="display-selected">
                    <p class="selected"></p>
                </div>
            <div>
                <?php

                // passa a data clicada pelo aluno no calendário pela query string
                // nao dá para inserir php num script, a solução foi no script enviar para a mesma pagina com a query string
                if (isset($_GET['eventodata'])) {

                    $eventodata = $_GET['eventodata'];
                    $link = new_db_connection();
                    $stmt = mysqli_stmt_init($link);

                    //echo $eventodata;

                    // seleciona todos os eventos marcados no dia escolhido pelo aluno
                    $query = "SELECT eventos_marcados.data, eventos.local, eventos.nome, eventos.descricao
                                          FROM eventos_marcados 
                                          INNER JOIN eventos ON eventos_marcados.ref_eventos = eventos.id_evento
                                          WHERE eventos_marcados.data LIKE '$eventodata%'
                                          ORDER BY eventos_marcados.data DESC";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_bind_result($stmt,  $data, $local, $nome, $descricao);

                        if (mysqli_stmt_fetch($stmt)) {
                            ?>
                            <div class="mb-5 ms-5">
                                <h4 class="mt-3 text-center letrasEscuro fw-bold fs-4">Atividade neste dia</h4>
                                <div class="d-flex justify-content-center ">
                                    <div class="rounded bg-light p-3 text-center">
                                        <p class="m-1"><strong><?= $local ?></strong></p>
                                        <p class="m-1"><?= $nome ?></p>
                                        <p class="m-1 letrasAzul fs-5"><?= $data ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php
                        } else {
                            // se o aluno não tiver nenhum evento marcado no dia escolhido
                            ?>
                            <p class="mt-5 text-center">Não há eventos marcados para a tua turma. 😔</p>
                            <?php
                        }

                    } else {
                        header("Location: ../index.php?error=sqlerror");
                    }

                    mysqli_stmt_close($stmt);

                } else{

                    // caso não tenha sido selecionado nenhum dia no calendário mostra a proxima atividade marcada
                    if (isset($_SESSION['ref_turmas'])) {
                        $link = new_db_connection();
                        $stmt = mysqli_stmt_init($link);

                        $query = "SELECT eventos_marcados.data, eventos.local, eventos.nome, eventos.descricao
                                          FROM eventos_marcados 
                                          INNER JOIN eventos ON eventos_marcados.ref_eventos = eventos.id_evento
                                          WHERE ref_turmas = ?
                                          ORDER BY eventos_marcados.data DESC
                                          LIMIT 1";

                        if (mysqli_stmt_prepare($stmt, $query)) {

                            mysqli_stmt_bind_param($stmt, 'i', $_SESSION['ref_turmas']);
                            mysqli_stmt_execute($stmt);

                            mysqli_stmt_bind_result($stmt, $data, $local, $nome, $descricao);

                            if (mysqli_stmt_fetch($stmt)) {
                                ?>
                                <h4 class="mt-3 text-center letrasEscuro fw-bold fs-4 ">A tua próxima atividade</h4>
                                <div class="d-flex justify-content-center mb-5">
                                    <div class="rounded bg-light p-3 text-center">
                                        <p class="m-1"><strong><?= $local ?></strong></p>
                                        <p class="m-1"><?= $nome ?></p>
                                        <p class="m-1 letrasAzul fs-5"><?= $data ?></p>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <p class="mt-5 text-center">Não há eventos marcados para a tua turma. 😔</p>
                                <?php
                            }


                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Erro ao preparar a query.";
                        }

                        mysqli_close($link);

                    }
                }
                ?>


            </div>

        </div>

        <!--estilos do calendário-->
        <style>
            :root {
                --azul_intermedio:#66C0E1;
                --branco_intermedio:#F0F0F0;
                --azul_escuro1:#2596BE;
                --azul_escuro2:#145167;
                --azul_claro1:#88CEE7;
                --azul_claro2:#AADCEE;
                --cinzento_claro: #D9D9D9;
            }


            header {
                margin: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
            }
            .header-display {
                display: flex;
                align-items: center;
            }

            .header-display p {
                color: var(--azul_intermedio);
                margin: 5px;
                font-size: 1.2rem;
                word-spacing: 0.5rem;
            }

            pre {
                padding: 10px;
                margin: 0;
                cursor: pointer;
                font-size: 1.2rem;
                color: var(--azul_intermedio);
            }

            .days,
            .week {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                margin: auto;
                padding: 0 20px;
                justify-content: space-between;
            }
            .week div,
            .days div {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 3rem;
                width: 3em;
                border-radius: 100%;
            }
            .days div:hover {
                background: var(--azul_escuro2);
                color: var(--white);
                cursor: pointer;
            }
            .week div {
                opacity: 0.5;
            }
            .current-date {
                background-color: var(--azul_intermedio);
                color: var(--white);
            }
            .display-selected {
                margin-bottom: 10px;
                padding: 20px 20px;
                text-align: center;
            }
        </style>

        </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    let display = document.querySelector(".display");
    let days = document.querySelector(".days");
    let previous = document.querySelector(".left");
    let next = document.querySelector(".right");
    let selected = document.querySelector(".selected");

    let date = new Date();

    let year = date.getFullYear();
    let month = date.getMonth();

    function displayCalendar() {
        const firstDay = new Date(year, month, 1);

        const lastDay = new Date(year, month + 1, 0);

        const firstDayIndex = firstDay.getDay(); //4

        const numberOfDays = lastDay.getDate(); //31

        let formattedDate = date.toLocaleString("en-US", {
            month: "long",
            year: "numeric"
        });

        display.innerHTML = `${formattedDate}`;

        for (let x = 1; x <= firstDayIndex; x++) {
            const div = document.createElement("div");
            div.innerHTML += "";

            days.appendChild(div);
        }

        for (let i = 1; i <= numberOfDays; i++) {
            let div = document.createElement("div");
            let currentDate = new Date(year, month, i);

            div.dataset.date = currentDate.toDateString();

            div.innerHTML += i;
            days.appendChild(div);
            if (
                currentDate.getFullYear() === new Date().getFullYear() &&
                currentDate.getMonth() === new Date().getMonth() &&
                currentDate.getDate() === new Date().getDate()
            ) {
                div.classList.add("current-date");
            }
        }
    }

    // Call the function to display the calendar
    displayCalendar();

    previous.addEventListener("click", () => {
        days.innerHTML = "";
        selected.innerHTML = "";

        if (month < 0) {
            month = 11;
            year = year - 1;
        }

        month = month - 1;

        date.setMonth(month);

        displayCalendar();
        displaySelected();
    });

    next.addEventListener("click", () => {
        days.innerHTML = "";
        selected.innerHTML = "";

        if (month > 11) {
            month = 0;
            year = year + 1;
        }

        month = month + 1;
        date.setMonth(month);

        displayCalendar();
        displaySelected();
    });

    function displaySelected() {
        const dayElements = document.querySelectorAll(".days div");
        dayElements.forEach((day) => {
            day.addEventListener("click", (e) => {
                const selectedDate = e.target.dataset.date;
                let data = new Date(selectedDate);
                let ano = data.getFullYear();
                let mes = String(data.getMonth() + 1).padStart(2, '0'); // Adiciona 1 ao mês porque os meses são indexados a partir de 0
                let dia = String(data.getDate()).padStart(2, '0'); // Adiciona zero à esquerda se necessário

                let dataFormatada = `${ano}-${mes}-${dia}`;
                console.log(dataFormatada); // Saída: "2024-06-06"

                // Redirecionar para a página de perfil mas passa na query string a data clicada pelo aluno
                // não dá para inserir php num script, o contrário já dá
                window.location="perfil.php?eventodata="+dataFormatada;

            });
        });
    }
    displaySelected();
</script>