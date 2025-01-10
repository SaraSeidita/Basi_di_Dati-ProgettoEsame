<?php 

include('db_connect.php');
include('header.php');

$blog = $posts = $like = $utenteSession = '';

if(isset($_GET['ID_blog'])){

    $idBlog = mysqli_real_escape_string($conn, $_GET['ID_blog']);

    // sql codice
    $sqlBlog = "SELECT * FROM blog WHERE ID_blog = $idBlog"; //dati blog
    $sqlPost = "SELECT * FROM post, utente WHERE ID_utente = autore_post and blog_post = $idBlog"; //elenco post
    $sqlCommenti = "SELECT * FROM commento, utente WHERE ID_utente = utente_commento ORDER BY data_commento DESC"; // commenti per post
    $sqlCoautori = "SELECT DISTINCT utente_coautore, username_utente FROM co_autore, utente WHERE ID_utente = utente_coautore and blog_coautore = $idBlog"; // coautori
    $sqlCategoria = "SELECT nome_categoria FROM categoria, blog WHERE ID_categoria = categoria_blog and ID_blog = '$idBlog';";
    $sqlSottocategoria = "SELECT nome_sottocategoria FROM sottocategoria, blog WHERE ID_sottocategoria = sottocategoria_blog and ID_blog = '$idBlog'";

    // risultato righe query
    $risBlog = mysqli_query($conn, $sqlBlog);
    $risPost = mysqli_query($conn, $sqlPost);
    $risCommenti = mysqli_query($conn, $sqlCommenti);
    $risCoautori = mysqli_query($conn, $sqlCoautori);
    $risCategoria = mysqli_query($conn, $sqlCategoria);
    $risSottocategoria = mysqli_query($conn, $sqlSottocategoria);

    // fetch righe risultato in un array
    $blog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato
    $posts = mysqli_fetch_all($risPost, MYSQLI_ASSOC);
    $commenti = mysqli_fetch_all($risCommenti, MYSQLI_ASSOC);
    $coautori = mysqli_fetch_assoc($risCoautori);
    $categorie = mysqli_fetch_assoc($risCategoria);
    $sottocategoria = mysqli_fetch_assoc($risSottocategoria);

    // gestione co autore 
    // sql coauthor 
    $sqlCoAuthor = "SELECT DISTINCT username_utente FROM co_autore, utente, blog WHERE ID_utente = utente_coautore and blog_coautore = '$idBlog';";
    $result = $conn -> query($sqlCoAuthor);

    // nome autore post 
    $sqlNamePost = "SELECT username_utente FROM post, utente, blog WHERE blog_post = $idBlog and ID_utente = autore_post;";
    $risNamePost = mysqli_query($conn, $sqlNamePost);
    $NamePost = mysqli_fetch_all($risNamePost);

    if(isset($_SESSION['usernameutente'])){
        $utenteSession = mysqli_real_escape_string($conn, $_SESSION['usernameutente']);
        $sqlIdUtente = "SELECT * FROM utente WHERE username_utente = '$utenteSession';";
        $risIdUtente = mysqli_query($conn, $sqlIdUtente);
        $IdUtente = mysqli_fetch_assoc($risIdUtente);
        $id = $IdUtente['ID_utente'];

        // recupero nome autore del blog
        $sqlAutoreBlog = "SELECT username_utente, ID_utente FROM blog, utente WHERE autore_blog = ID_utente and ID_blog = $idBlog;";
        $risAutore = mysqli_query($conn, $sqlAutoreBlog);
        $autore = mysqli_fetch_assoc($risAutore);

        // recupero co autore 
        $sqlCoAuthor2 = "SELECT username_utente, ID_utente, ID_CoAutore FROM co_autore, utente, blog WHERE utente_coautore = ID_utente and blog_coautore = $idBlog;";
        $result2 = $conn -> query($sqlCoAuthor2);
        $coautore2 = mysqli_fetch_assoc($result2);
    }

}
    


?>

<!DOCTYPE html>
<head>
<?php include 'head.php';?>
</head>
<body>
    <div>

    <?php if(isset($_SESSION['usernameutente'])){?>

    </div>
    <div class="infoBlog">
        <?php if($blog):?>
            <div class="visualtitleblog">
                <h4 class="visualtitleblog"><?php echo htmlspecialchars($blog['titolo_blog']);?></h4>
            </div>
            <p class="visualAuthorBlog"><b>Blog creato da:</b> <?php echo htmlspecialchars($autore['username_utente']);?></p> 
            <p class="visualDataBlog"><b>Creato il:</b> <?php echo htmlspecialchars($blog['data_blog'])?></p>
            <p class="visualCategoriaBlog"><b>Categoria del blog:</b> <?php echo htmlspecialchars($categorie['nome_categoria'])?></p>
            <p><b>Sottocategoria del blog:</b> <?php echo htmlspecialchars($sottocategoria['nome_sottocategoria'])?></p>
            <p>
                <b>Co-autore del blog:</b>
                <?php 
                if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                    ?>
                        <p style="text-align:center;"><?php echo $row['username_utente']?></p>
                    </div>
                
                    <?php }
                } else {
                ?>      <p style="text-align:center">Questo blog non ha coautori</p><?php
                }
                endif;?>
            </p>
    </div>

    <div class="gestioneBlog">
        <?php 
        // controllo se utente è autore o coautore
        // se è autore, vedrà il pulsante crea post, gestione blog
        // se è coautore, vedrà solo il pulsante crea post
        if(isset($_SESSION['usernameutente']) && ($_SESSION['usernameutente'] == $autore['username_utente'])){
            ?><p><a href="crea_post.php?ID_blog=<?php echo $blog['ID_blog']?>">Crea post</a></p>
            <p><a href="gestione-blog.php">Gestione blog</a></p>
            <?php
        } 
        elseif($coautore2){
            if(isset($_SESSION['usernameutente']) && ($_SESSION['usernameutente'] == $coautore2['username_utente'])){
            ?><p><a href="crea_post.php?ID_blog=<?php echo $blog['ID_blog']?>">Crea post</a></p>
                <?php
        }}
        ?>
    </div>

    <div class="visualPost">
        <?php if(!$posts):?>
            <p style="text-align:center;"><?php echo 'Non ci sono ancora i post';?></p>
        <?php else:?>
        <?php endif;?>
        <?php foreach($posts as $post){?>
             
            <div class="visualPostBox" style="padding: 1%; width: 50%; margin: 2% auto;">
                <h2 class="titoloPost"><?php echo htmlspecialchars($post['titolo_post']);?></h2>
                <p class="testoPost"><?php echo htmlspecialchars($post['testo_post']);?></p>
                <p><b>Post creato da:</b> <?php echo htmlspecialchars($post['username_utente']);?></p>
                <p><b>Post creato il:</b> <?php echo htmlspecialchars($post['data_post']);?></p>
                <div class="comments"><h3>Commenti post</h3>
                    <?php if(!$commenti){
                        ?><p>Ancora nessun commento</p><?php
                    } 
                    if($commenti){
                    foreach($commenti as $commento){
                        if ($commento['post_commento'] === $post['ID_post']) { 
                            $postID = $post['ID_post'];
                            
                        ?>
                            <div style="margin:0.1%;">
                            <p> 
                                <b><?php echo htmlspecialchars($commento['username_utente'])?></b>
                            </p>
                            <p>
                                <?php echo htmlspecialchars($commento['testo_commento'])?>
                            </p>
                            <p>
                                <small><?php echo htmlspecialchars($commento['data_commento'])?></small>
                                <?php if(isset($_SESSION['usernameutente']) && ($_SESSION['usernameutente']==$commento['username_utente'])){
                                    ?><a href="delete_commento.php?ID_commento=<?php echo $commento['ID_commento']?>">Delete</a>
                                    <?php
                                    }?>
                            </p>
                </div>
                    <?php
                }}}
                ?>
            </div>
                <div>
                    <form method="POST" class="insertCommento" id="insertCommento" action="insert_commento.php?ID_post=<?php echo $post['ID_post']?>&ID_blog=<?php echo $blog['ID_blog']?>">
                        <p>Aggiungi un commento</p>
                        <textarea name="testoCommento" id="testoCommento" placeholder="testoCommento"></textarea>
                        <p><button name="crea_commento" type="submit" href="crea_post.php?ID_post=<?php echo $post['ID_post'];?>">
                        Aggiungi commento</button></p>
                    </form>
                    <form method="POST" class="insertLike" id="insertLike" action="insert_like.php?ID_post=<?php echo $post['ID_post']?>&ID_blog=<?php echo $blog['ID_blog']?>">
                        <p><button name="insert_like" type="submit" href="crea_post.php?ID_post=<?php echo $post['ID_post'];?>">Like</button></p>
                    </form>
                    <p><?php echo htmlspecialchars($post['conteggio_like_post']);?>
                </div>
            </div>
                <?php if(isset($_SESSION['usernameutente']) && ($_SESSION['usernameutente'] == $autore['username_utente'])){
                    ?><div class="canc-post-btn"><p><a href="javascript:confirmDelete('cancella-post.php?ID_post=<?php echo $post['ID_post']?>')">Elimina post</a></p></div><?php
                ?><script>
                    function confirmDelete(delUrl) {
                        if (confirm("Sei sicuro di voler cancellare il post? Se lo farai, non lo potrai recuperare")) {
                        document.location = delUrl;
                        }
                    }
                    </script>
                
                <?php 
                }
                ?>
                <?php
        }
            ?>
        <?php } else {
            include 'error.php';
        }?>
    </body>
    <footer>
        <?php include 'footer.php';?>
    </footer>
</html>