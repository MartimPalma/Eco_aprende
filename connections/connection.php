<?php
function new_db_connection()
{
    $hostname = "labmm.clients.ua.pt";
    $username = "deca_24_BDTSS_28_web";
    $password = "yfZ2Yt6C";
    $dbname = "deca_24_bdtss_28";

    $link = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($link, "utf8");

    return $link;
}
