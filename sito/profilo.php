<?php include 'db_connect.php';?>
<?php include 'header.php';?>

<?php // codice 
    // inizializzo variabili 
    $datiutente = $resultUtente = $resultBlog = $numBlog = '';

    if(isset($_SESSION['usernameutente'])) {

        $nomeUtente = $_SESSION['usernameutente'];

        $sqlUtente = "SELECT ID_utente, username_utente, email_utente, tipo_utente FROM utente WHERE username_utente = '$nomeUtente';";
        
        // recupero l'id dell'utente
        $resultID = mysqli_query($conn, $sqlUtente);
        $datiUtente = mysqli_fetch_assoc($resultID);
        $idutente = $datiUtente['ID_utente'];

        // recupero gli altri dati dell'utente 
        $resultUtente = mysqli_query($conn, $sqlUtente);
        $datiutente = mysqli_fetch_assoc($resultUtente);

        // dati utente premium
        $sqlPremium = "SELECT * FROM premium WHERE utente_premium='$idutente';";
        $risPremium = mysqli_query($conn, $sqlPremium);
        $Premium = mysqli_fetch_assoc($risPremium);
        
        // recupero il numero di blog in cui è autore
        $sqlBlog = "SELECT COUNT(*) as blog_count FROM blog WHERE autore_blog = '$idutente'";
        $resultBlog = mysqli_query($conn, $sqlBlog);
        $numBlog = mysqli_fetch_assoc($resultBlog);

        // recupero il numero di blog in cui è coautore
        $sqlCoAuthor = "SELECT COUNT(*) as coauthor_count FROM co_autore WHERE utente_coautore = '$idutente';";
        $resultCoAuthor = mysqli_query($conn, $sqlCoAuthor);
        $numCoAuthor = mysqli_fetch_assoc($resultCoAuthor);

        mysqli_close($conn);

    } 
?>

<style>
    div.profilo-box-1-2 {
        position: relative;
        text-align: center; 
        margin: 1%; 
        padding: 1%; 
        top:5%;
        left:1%;
        width:450px; 
        background-color: #AAA;
    }

    div.profilo-box-1-3 {
        position: relative;
        text-align: left; 
        margin: 1%; 
        padding: 1%; 
        top: 10%;
        left:1%;
        width: 450px; 
        background-color: #AAA;
    }
    
    div.profilo-box-1-4 {         
            padding: 1%; 
            width: 450px; 
            margin-left: auto; 
            margin-right: 1%;
            margin-bottom: 5%;
            background-color: #AAA;
            position: relative;
            float: right;
            justify-content: flex-end;
    }   

    div.profilo-box-2 {
        position: relative;
        text-align: left; 
        margin: 1%; 
        padding: 1%; 
        top: 10%;
        left:1%;
        width: 450px; 
        background-color: #AAA;
    }  
</style>


<!DOCTYPE html>
    <html lang="it">
        <body>
            <?php 
                include 'head.php';
            ?>

            <?php if(isset($_SESSION['usernameutente'])){?>
            <div class="corpo-profilo">
                <div>
                    <h2 style="text-align: center; margin:1%; padding:0.5%;"> Ciao <?php echo$datiutente['username_utente'];?>, questo è il tuo profilo</h2>
                </div>

                <div class="profilo-box-1">
            
                    <div class="profilo-box-1-2">
                            <h4 class="box-1-2" style="text-align: center; margin: 1%; padding: 1%;"> I tuoi dati: </h4>
                            <p class="testo"> <b>Username</b>: <?php echo $datiutente['username_utente'];?></p>
                            <p> <b>Email</b>: <?php echo $datiutente['email_utente'];?></p>
                            <p> <b>Tipo utente</b>: <?php echo $datiutente['tipo_utente'];?></p>
                    </div>

                    <div class="profilo-box-1-3" >
                        <?php if($datiutente['tipo_utente'] == 'Semplice') : ?>
                        <p>Puoi creare fino a un massimo di 5 blog</p>
                        <p>Vuoi crearne di più?</p>
                        <a href="premium.php">Passa a premium! </a> 
                        <?php else: ?> 
                            <h3><strong>Profilo premium</strong></h3> 
                            <p><b>Abbonato il:</b> <?php echo $Premium['data_inizio_premium']?></p>
                            <p><b>Scadenza il:</b> <?php echo $Premium['data_fine_premium']?></p>
                            <p><strong>Crea tutti i blog che vuoi!</strong></p>
                        <?php endif;?>
                    </div>
                </div>

                <div class="profilo-box-2">
                    <h4 class="box-2" style="text-align: left; margin: auto; padding: 1%;">I tuoi blog</h4>
                    <!-- numero dei blog dell'utente, mostrare a sx --> 
                    <p> Numero blog in cui sei autore: <?php echo $numBlog['blog_count'];?></p>
                    
                    <!-- bottone per gestire i propri blog e post, mostrare a sx --> 
                    <p>Gestisci i tuoi blog: <a href="gestione-blog.php">Apri</a></p>

                    <h4 class="box-2" style="text-align: left; margin: 1%; padding: 1%;">Blog in cui sei co-autore</h4>
                    <p> Numero blog in cui sei co-autore: <?php echo $numCoAuthor['coauthor_count'];?></p>
                    <p>Gestisci i blog in cui sei co-autore: <a href="gestione-blog-coauthor.php">Apri</a> </p>
                    <br/>
                </div>

                <div class="profilo-box-1-4">
                    <h4 class="box-4" style="text-align: left; margin: 1%; padding: 1%;">Impostazioni profilo</h4>
                    <p>Vuoi modificare il tuo nome utente o la tua email? </p><p><a href="modifica-profilo.php">Modifica</a></p>
                    <p>Vuoi cancellare il tuo profilo utente? </p></p>
                        <a href="javascript:confirmDelete('cancella-profilo.php')">Cancella</a></p>
                        <script>
                            function confirmDelete(delUrl) {
                            if (confirm("Sei sicuro di voler cancellare il profilo? Se lo farai, perderai tutti i dati")) {
                            document.location = delUrl;
                            }
                            }
                        </script>
                </div>
            </div>
            <?php } else { // se un utente anonimo prova ad accedere a questa pagina, troverà error
            include 'error.php';
        } ?>
        </body>
</html>