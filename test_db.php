<?php

require_once("./connections/connection.php"); // ou onde estiver a função new_db_connection()

$conn = new_db_connection();

if ($conn) {
    echo "Ligação à base de dados da UA bem-sucedida!";
}

