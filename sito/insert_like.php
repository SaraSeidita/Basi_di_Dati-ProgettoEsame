<?php 

include('db_connect.php');

if(!isset($_SESSION)){
    session_start();
}

$utente = $idPost = $idBlog = '';

if(isset($_SESSION['usernameutente'])){
    $utente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);

    // recupero ID utente 
    $sqlID = "SELECT ID_utente FROM utente, blog WHERE autore_blog = ID_utente and username_utente = '$utente';";
    $resultID = mysqli_query($conn, $sqlID);
    $datiUtente = mysqli_fetch_assoc($resultID);
    $idutente = $datiUtente['ID_utente'];

    echo "Utente: " . $utente;
}

if(isset($_GET['ID_blog'])){
    $idBlog = $_GET['ID_blog'];
}

if(isset($_GET['ID_post'])){
     
    
    if($utente){

        // id post 
        $idPost = mysqli_real_escape_string($conn, $_GET['ID_post']);
        echo "Post: " . $idPost;

        // id utente 
        $sqlID = "SELECT ID_utente FROM utente WHERE username_utente = '$utente';";
        $resultID = mysqli_query($conn, $sqlID);
        $datiUtente = mysqli_fetch_assoc($resultID);
        $idutente = $datiUtente['ID_utente'];

        // recupero like
        $sqlLike = "SELECT * FROM feedback WHERE utente_feedback = '$idutente' and post_feedback = '$idPost'";
        $result=$conn->query($sqlLike);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $like=$row['ID_feedback'];
        if($result->num_rows == 0 ){
            $sqlInsertLike = "INSERT INTO feedback (ID_feedback, utente_feedback, post_feedback) VALUES (NULL, '$idutente', '$idPost')";
            if(mysqli_query($conn, $sqlInsertLike)){
                header("Location: visual_blog.php?ID_blog=$idBlog");
            } else {
                echo 'Errror.' . mysqli_error($conn);
            }
        } elseif($result->num_rows > 0) {
            $sqlDeleteLike = "DELETE FROM feedback WHERE ID_feedback = '$like';";
            mysqli_query($conn, $sqlDeleteLike);
            header("Location: visual_blog.php?ID_blog=$idBlog");
        }
        $conn->close();

    }}?>