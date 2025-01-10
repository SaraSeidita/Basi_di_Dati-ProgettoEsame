<?php

    // includo file connessione al db
    include('db_connect.php');

    //includo file header
    include('header.php');
    include('head.php');

    if(isset($_SESSION['usernameutente'], $_GET['ID_post'])){
        $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);
        $idPost = $_GET['ID_post'];

        $cancPost = "DELETE FROM post WHERE ID_post = $idPost";
        if (mysqli_query($conn, $cancPost) == TRUE){
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