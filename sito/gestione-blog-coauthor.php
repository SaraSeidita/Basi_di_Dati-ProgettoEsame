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
    $sqlBlog = "SELECT ID_blog, titolo_blog, descrizione_blog, data_blog FROM blog, co_autore WHERE utente_coautore = $idutente and blog_coautore = ID_blog";
    $resultBlog = mysqli_query($conn, $sqlBlog);
    $blog = mysqli_fetch_all($resultBlog, MYSQLI_ASSOC);

    mysqli_free_result($resultBlog);

    // chiusura connessione 
    mysqli_close($conn);
} else {
    echo 'error';
}
?>

<!DOCTYPE html>
    <html lang="it">
        <head><?php include 'head.php';?></head>
        <body>
    
        <h4>Blog in cui sei co-autore</h4>
            <?php 
            if(count($blog)>0){?>
                
                <div class="card-blo"><?php
                    foreach($blog as $blogs){?>
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
                        </div>            
                    <?php }
            } else { 
                ?> <p style="text-align:center;">Non sei co-autore in nessun blog</p> <?php
            }?>
                                
                </div>
        </body>
