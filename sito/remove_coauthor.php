<?php

    // includo file connessione al db
    include('db_connect.php');

    //includo file header
    include('header.php');
    include('head.php');

    if(isset($_GET['ID_utente'], $_GET['ID_blog'])){
        $idBlog = $_GET['ID_blog'];
        $idUtente = $_GET['ID_utente'];

        $cancCoautore = "DELETE FROM co_autore WHERE blog_coautore = $idBlog and utente_coautore = $idUtente;";
        if (mysqli_query($conn, $cancCoautore) == TRUE){
            if(isset($_SERVER['HTTP_REFERER']))
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                else
                    header("location:javascript://history.back()");
                } else {
                    echo 'error';
                }
    } else {
        echo 'error';
    }
    
    ?>