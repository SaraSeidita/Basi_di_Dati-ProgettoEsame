<?php 

include('db_connect.php');

if(!isset($_SESSION)){
    session_start();
}

$commento = $utente = $idPost = $idBlog = '';

if(isset($_SESSION['usernameutente'])){
    $utente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);

    // recupero ID utente 
    $sqlIDutentePost = "SELECT ID_utente FROM utente WHERE username_utente = '$utente';";
    $resultIDPost = mysqli_query($conn, $sqlIDutentePost);
    $datiUtentePost = mysqli_fetch_assoc($resultIDPost);
    $idutentePost = $datiUtentePost['ID_utente'];

    echo "Utente: " . $utente;
}

if(isset($_GET['ID_blog'])){
    $idBlog = $_GET['ID_blog'];
}

if(isset($_GET['ID_post'])){
    if($utente){

        $idPost = mysqli_real_escape_string($conn, $_GET['ID_post']);
        echo "Post: " . $idPost; 

        $timestamp = date("Y-m-d H:i:s");
        $dataCommento = $timestamp;
        echo "$dataCommento";

        $commento = mysqli_real_escape_string($conn, $_POST['testoCommento']);
        echo $commento;

        $sqlCommento = "INSERT INTO commento (ID_commento, data_commento, testo_commento, post_commento, utente_commento) VALUES (NULL,'$dataCommento', '$commento', '$idPost', '$idutentePost')";

        if(mysqli_query($conn, $sqlCommento)){
            header("Location: visual_blog.php?ID_blog=$idBlog");
        } else {
            echo 'Error .' . mysqli_error($conn);
        }

        $conn->close();

    }
}
?>