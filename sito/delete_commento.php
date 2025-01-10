<?php

    // includo file connessione al db
    include('db_connect.php');

    //includo file header
    include('header.php');
    include('head.php');

    if(isset($_SESSION['usernameutente'], $_GET['ID_commento'])){
        $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);
        $idCommento = $_GET['ID_commento'];
        $idBlog = $_GET['ID_blog'];
        $cancComment = "DELETE FROM commento WHERE ID_commento = $idCommento";
        if (mysqli_query($conn, $cancComment) == TRUE){
                if(isset($_SERVER['HTTP_REFERER']))
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                else
                    header("location:javascript://history.back()");
                } else {
                    echo 'error';
                }
    }
    ?>