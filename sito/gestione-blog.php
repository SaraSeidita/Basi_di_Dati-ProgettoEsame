<?php include 'db_connect.php';?>
<?php include 'header.php';?>

<?php 
if(isset($_SESSION['usernameutente'])){
    $blog = $tipoutente = '';

    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);

    $sqlIDutente = "SELECT ID_utente FROM utente WHERE username_utente = '$nomeUtente';";
    $resultID = mysqli_query($conn, $sqlIDutente);
    $datiUtente = mysqli_fetch_assoc($resultID);
    $idutente = $datiUtente['ID_utente'];

    // recupero i blog creati dall'utente 
    $sqlBlog = "SELECT ID_blog, titolo_blog, descrizione_blog, data_blog, autore_blog FROM blog WHERE autore_blog = '$idutente'";

    // recupero tipo utente 
    $sqlTipoUtente = "SELECT tipo_utente FROM utente WHERE username_utente = '$nomeUtente'";
    $resultTipoUtente = mysqli_query($conn, $sqlTipoUtente);
    $datoTipoutente = mysqli_fetch_assoc($resultTipoUtente);
    $tipoUtente = $datoTipoutente['tipo_utente'];
    
    // risultato delle query precedenti 
    $resultBlog = mysqli_query($conn, $sqlBlog);
    $resultTipoUtente = mysqli_query($conn, $sqlTipoUtente);

    // count dei blog dell'utente 
    $num_blog = mysqli_num_rows($resultBlog);

    // righe dei risultato delle query 
    $blog = mysqli_fetch_all($resultBlog, MYSQLI_ASSOC);

    mysqli_free_result($resultBlog);

    // chiusura connessione 
    mysqli_close($conn);
} 
?> 

<!DOCTYPE html>
    <html lang="it">
        <head><?php include 'head.php';?></head>
        <body>
        
        <?php if(isset($_SESSION['usernameutente'])){?>
        
            <div class="container">

                <div class="blog-count1">
                    <?php if(count($blog)>0){?>
                        <h4>Gestisci i tuoi blog</h4>
                        <div class="card-blo">
                            <?php foreach($blog as $blogs){?>
                                <div class="box-blog">
                                    <div>
                                        <h3 class="titolo-blog"><?php echo htmlspecialchars($blogs['titolo_blog']);?></h3>
                                    </div>
                                    <div>
                                        <p class="descrizioneblog"><?php echo htmlspecialchars($blogs['descrizione_blog']);?></p>
                                        <p class="datacreazioneblog">Blog creato il: <?php echo htmlspecialchars($blogs['data_blog']);?></p>
                                    </div>
                                    <div>
                                        <p><a href="visual_blog.php?ID_blog=<?php echo $blogs['ID_blog']?>">Apri</a></p>
                                    </div>
                                    <div>
                                        <p><a href="gestione-coauthor.php?ID_blog=<?php echo $blogs['ID_blog']?>">Gestisci i co-autori</a></p>
                                    </div>
                                    <div>
                                    <p>
                                        <a href="javascript:confirmDelete('cancella-blog.php?ID_blog=<?php echo $blogs['ID_blog']?>')">Elimina</a>
                                        <script>
                                        function confirmDelete(delUrl) {
                                        if (confirm("Sei sicuro di voler cancellare il blog? Se lo farai, non lo potrai recuperare")) {
                                        document.location = delUrl;
                                        }
                                        }
                                        </script>
                                    </p>
                                    </div>
                                    
                                </div><?php 
                            }
                            if(($tipoUtente == "Semplice" && $num_blog < 5) || $tipoUtente == "Premium") {?>
                                <div class="card-new-blog"><p><a href="crea-blog.php">Crea un nuovo blog</a></p></div>
                
                            <?php }?>
                            <div class="blog-new"> 

                    <?php } else {?>
                        <p style="text-align: center;">Non hai ancora nessun blog! Creane uno!
                    <?php
                        if(isset($_SESSION['usernameutente'])){?>
                            <a href="crea-blog.php">Crea il tuo blog</a>
                        <?php }?>
                        </p>
                    <?php } ?>
            <?php } else {
            include 'error.php';
        }?>
    </body> 

    <footer>
        <?php include('footer.php');?>
    </footer>
</html>