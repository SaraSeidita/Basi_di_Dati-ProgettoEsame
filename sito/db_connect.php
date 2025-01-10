<?php
    //connetto al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "seidita_sara";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //controllo la connessione
    if (!$conn) {
        echo "Connection error: " . mysqli_connect_error();
    } 
    // imposto codifica
    mysqli_set_charset($conn, "utf8");
?>
