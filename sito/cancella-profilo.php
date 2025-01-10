<?php 
include('db_connect.php'); // connessione al database

include('header.php');
include('head.php'); // file header e head

// codice cancellazione del profilo 

if(isset($_SESSION['usernameutente'])){
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);
    // codice SQL per cancellare i dati 
    $sql = "DELETE FROM utente WHERE username_utente = '$nomeUtente';";

    if ($conn->query($sql) == TRUE){
        echo '<div><p>'."Utente cancellato".'</p></div>';
        unset($_SESSION['usernameutente']); // chiudo la sessione 
        session_destroy();
    } else {
        echo '<div><p>'."Errore nella cancellazione del profilo".'</p></div>';

    }

    $conn -> close();
}
?>

<div>
    <a href="index.php">Torna alla home</a>
</div>
