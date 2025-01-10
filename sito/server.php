<?php 

session_start();

include('db_connect.php');

// codice registrazione utente
if(isset($_POST['usernameUtente'])) {
    // recupero i valori inseriti nella form register.php
	$username = $_POST['usernameUtente'];
	$useremail = $_POST['emailUtente'];
	$pw1 = $_POST['pw'];	
    $pw1 = md5($pw1); // cripto la password con la funzione md5(), che calcola il valore "md5" di una stringa

    // controllo se il nome utente o la email inserita è già esistente
    $sql = "SELECT username_utente, email_utente FROM utente WHERE username_utente = '$username' or email_utente='$useremail';";
    $regRis = mysqli_query($conn, $sql);
    
    // se mi restituisce 0 righe, allora significa che sono disponibili
    // perciò vengono inseriti nel database e la registrazione viene completata
	if(mysqli_num_rows($regRis) == 0){
        $sql = "INSERT INTO utente(ID_utente, username_utente, email_utente, pw_utente, tipo_utente) VALUES (NULL, '".$username."', '".$useremail."', '".$pw1."', 'Semplice');";
        $conn->query($sql);		
        $_SESSION['usernameutente'] = $username;	
        header('Location: login.php');
    // se mi restituisce una riga, significa che sono già presenti nel database
	}elseif(mysqli_num_rows($regRis) > 0){
        ?><script>
        // perciò l'utente verrà riportato alla registrazione per reinserire nuovi dati
        if (window.confirm('Nome utente o email già esistente')) 
            {
                window.location.href='register.php';
        };
        </script><?php
    } else {
        include('error.php');
    }
}

// codice login utente

if(isset($_POST['loginUsername'])) { 
    $errors = array(); // array contenente eventuali errori
	$nomeUtente = mysqli_real_escape_string($conn, $_POST['loginUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['loginPassword']);

    if (!($nomeUtente)){
        array_push($errors, "Nome utente richiesto"); // array_push() accoda uno o più elementi ad un array
    }
    if(!($password)){
        array_push($errors, "Password richiesta");
    }

    if(count($errors)==0){ // se alla fine l'array ha 0 elementi, allora ha 0 errori
        $password = md5($password); // come per la registrazione, si cripta la pw
        // controllo se nome utente E password sono corretti
        $query = "SELECT username_utente, pw_utente FROM utente WHERE username_utente = '$nomeUtente' and pw_utente='$password'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1) { // se il login viene effettuato con successo, l'utente viene reindirizzato alla home
            $_SESSION['usernameutente'] = $nomeUtente; 
            header('Location: index.php');
        } else { // altrimenti, deve ritentare il login
            ?>  <script>
                if (window.confirm('Nome utente o password errata')) 
                    {
                        window.location.href='login.php';
                };
                </script>
                <?php
        }
        }
    } 