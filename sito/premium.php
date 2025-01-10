<?php 
// connessione al db 
include('db_connect.php');
include('header.php');
?>

<?php 


if(isset($_SESSION['usernameutente'])){

    $errors = array(); // inizializzo un array inizialmente vuoto che conterrà eventuali errori

    if(isset($_POST['submit_premium'])){
        // recupero i dati inseriti dall'utente salvandoli in una variabile
        $numcarta = $_POST['numerocarta'];
        $scadenzacarta = $_POST['datacarta'];
        $nomecarta = $_POST['nomecarta'];
        $cognomecarta = $_POST['cognomecarta'];
        $codcarta = $_POST['codcarta']; 

        // controllo che ci sono tutti i campi compilati 
        if(empty($numcarta)){
            array_push($errors, "Manca il numero carta");
        }

        if(empty($scadenzacarta)){
            array_push($errors, "Manca la data di scadenza");
        }

        if(empty($nomecarta)){
            array_push($errors, "Manca il nome della carta");
        }

        if(empty($cognomecarta)){
            array_push($errors, "Manca il cognome della carta");
        }

        if(empty($codcarta)){
            array_push($errors, "Manca il codice di sicurezza");
        }

        if(count($errors) == 0){ // se l'array ha 0 elementi, quindi non ci sono errori

            $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);

            // recupero ID dell'utente 
           
            $sql = "SELECT ID_utente FROM utente WHERE username_utente = '$nomeUtente';";
            $res = mysqli_query($conn, $sql);
            $dati = mysqli_fetch_assoc($res);
            $id = $dati['ID_utente'];
            
            // inserisco i dati sulla tabella PREMIUM 
            $iniziopremium = date('Y-m-d H:i:s'); // data attuale
            $finepremium = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($iniziopremium))); // data attuale + 1 mese (scadenza un mese dopo)

            $sqlpremium = "INSERT INTO premium(utente_premium, data_inizio_premium, data_fine_premium) VALUES ('$id', '$iniziopremium', '$finepremium')";
            $rispremium = mysqli_query($conn, $sqlpremium);
            
            // aggiorno il tipo utente della tabella UTENTE in "Premium"
            $sqlupdateuser = "UPDATE utente SET tipo_utente = 'Premium' WHERE username_utente = '$nomeUtente'";
            $risupdateuser = mysqli_query($conn, $sqlupdateuser);

            ?>
                <script>
                // se effettuato con successo, l'utente diventa premium e vedrà modificato qualcosa nel profilo
                if (window.confirm('Complimenti, sei diventato un utente premium!')) 
                    {
                        window.location.href='profilo.php';
                };
                </script>
            <?php

        } else {
            echo 'Errore';
        }
    }

}

?>

<!DOCTYPE html>
    <html lang="it"> 
        <?php include('head.php'); 
        // file head
        ?> 
    
    <body> 

        <?php if(isset($_SESSION['usernameutente'])){?>
        <div> 
            <a href="profilo.php">Torna sul tuo profilo</a> 
        </div>

        <div>
            <h4 style="text-align: center; margin:1%; padding:0.5%;">Vuoi diventare premium per creare infiniti blog?</h4>

            <div> 
                <h4  style="text-align: center; margin:1%; padding:0.5%;">Inserisci i tuoi dati</h4> 

                <form id="premium" method="post" action="premium.php">
                    <label for="numero">Numero carta</label>
                    <input type="text" id="numerocarta" name="numerocarta" placeholder="Inserire un numero di carta valido">

                    <label for="nome">Nome:</label> 
                    <input type="text" id="nomecarta" name="nomecarta" placeholder="Inserisci il tuo nome">

                    <label for="nome">Cognome:</label> 
                    <input type="text" id="cognomecarta" name="cognomecarta" placeholder="Inserisci il tuo cognome">
                    
                    <label for="nome">Data scadenza:</label> 
                    <input type="month" id="datacarta" name="datacarta" placeholder="Inserisci la data di scadenza">

                    
                    <label for="nome">Codice di sicurezza:</label> 
                    <input type="text" id="codcarta" name="codcarta" placeholder="Inserisci il codice di sicurezza">

                    <button type="submit" id="submit_premium" name="submit_premium">Paga</button>
                </form>
        <?php } else {
            include 'error.php'; // se un utente anonimo prova ad accedere a questa pagina, troverà error
        } ?>
        
                <script type="text/javascript">
                
                    // ho usato addMethod per avere una lunghezza esatta per alcuni campi specifici
                    jQuery.validator.addMethod("exactlength", function(value, element, param) {
                    return this.optional(element) || value.length == param;
                    }, $.validator.format("Please enter exactly {0} characters."));
                </script>
                <script>
                    $(document).ready(function(){
                        $("#premium").validate({
                            rules: {
                                numerocarta: {
                                    required: true,
                                    exactlength: 16,
                                    number: true
                                }, 
                                nomecarta: 'required',
                                cognomecarta: 'required',
                                datacarta: {
                                    required: true
                                }, 
                                codcarta: {
                                    required: true,
                                    exactlength: 3,
                                    number: true
                                }
                            }, 
                            messages: {
                                numerocarta: {
                                    required: 'Devi inserire il numero della carta',
                                    exactlength: 'Il numero di carta deve avere 16 caratteri numerici!',
                                    number: 'Il numero di carta deve contenere soltanto numeri'
                                }, 
                                nomecarta: 'Inserisci il tuo nome',
                                cognomecarta: 'Inserisci il tuo cognome',
                                datacarta: {
                                    required: 'Devi inserire la data di scadenza della carta'
                                },
                                codcarta: {
                                    required: 'Devi inserire il codice di sicurezza',
                                    exactlength: 'Il codice di sicurezza deve contenere 3 numeri',
                                    number: 'Devono esserci soltanto numeri'
                                }
                            }
                        })
                    })
                </script>
    </body>
    <footer>
        <?php include 'footer.php';?>
    </footer>
</html>
