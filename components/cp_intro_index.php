
<?php
 // não é preciso session start porque já  foi inciada a sessão
   $nome = $_SESSION['nome'];
?>

<h1 class="pt-3">

    <?php
        if (isset($_SESSION['ref_avatares']) && $_SESSION['login'] == true) {

            // se o avatar for 1 ou 2, escreve 'Bem-vindo'
            if ($_SESSION['ref_avatares'] == 1 || $_SESSION['ref_avatares'] == 2) {
                echo "Bem-vindo";
            } else {
                echo "Bem-vinda";
            }
        }
    ?>

    ao <span class="letrasAzul">Eco</span><span class="letrasEscuro">Aprende,</span>
    <?php
        // Verifica se a sessão de login está definida e se o utilizador está logado , e escreve o seu nome
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            echo $nome;
        }
    ?>
</h1>

<p class="pt-5 pb-3 fs-5">Aprende mais sobre as zonas costeiras de Ílhavo...</p>
