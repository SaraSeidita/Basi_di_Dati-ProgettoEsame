<?php

    //includo file connessione al db
    include('db_connect.php');

    //includo file header
    include('header.php');
    include('head.php');

    if(isset($_SESSION['usernameutente'], $_GET['ID_blog'])){
        $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);
        $idBlog = $_GET['ID_blog'];

        $cancBlog = "DELETE FROM blog WHERE ID_Blog = $idBlog";
        if (mysqli_query($conn, $cancBlog) == TRUE){
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
