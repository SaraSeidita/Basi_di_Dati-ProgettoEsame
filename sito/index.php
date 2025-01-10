<!-- prima pagina che compare a chi visita il sito 
gli utenti anonimi vedranno soltanto due bottoni che portano a fare la registrazione e il login, con il banner del sito 
gli utenti loggati vedranno la home del sito con il menù nell'header e l'elenco dei blog/barre di ricerca sotto nel body principale -->

<?php include('db_connect.php');?>
<?php include('header.php');?>

<?php 

    $nomeUtente = '';

    if(isset($_SESSION['usernameutente'])){
        $nomeUtente = mysqli_real_escape_string($conn, $nomeUtente);
    }

    // recupero i blog, categorie, autore blog

    $sqlGetBlog = "SELECT ID_blog, titolo_blog, descrizione_blog, nome_categoria, nome_sottocategoria, username_utente FROM blog, utente, categoria, sottocategoria
        WHERE categoria_blog = ID_categoria and sottocategoria_blog = ID_sottocategoria and autore_blog = ID_utente and username_utente = '$nomeUtente';";
    
    $sqlCategorie = "SELECT * FROM categoria";
    $sqlSottocategoria = "SELECT * FROM sottocategoria";

    $resultBlog = mysqli_query($conn, $sqlGetBlog);
    $resultCategorie = mysqli_query($conn, $sqlCategorie);
    $resultSottocategoria = mysqli_query($conn, $sqlSottocategoria);

    $blogs = mysqli_fetch_all($resultBlog);
    $categorie = mysqli_fetch_all($resultCategorie);
    $resultSottocategoria = mysqli_fetch_all($resultSottocategoria);

?>

<body>
    <?php include 'head.php';?>

    <!-- Lista ultimi 3 blog -->
    <?php if(isset($_SESSION['usernameutente'])){?>
    <div class="last-blog">
        <h3 id="titoloIndex">Ultimi 3 blog creati</h3>
        <div class="last-blog-result"><?php   
            $sql = "SELECT ID_blog, titolo_blog, descrizione_blog, data_blog, username_utente FROM blog, utente WHERE autore_blog = ID_utente ORDER BY data_blog DESC LIMIT 3;";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                while($row = $result -> fetch_assoc()){
                    ?>
                    <div style="margin:1%; padding:0.5%;border: 1px solid #ccc;float: left;width: 30%;height:30%;text-align:center; background-color:grey;">     
                            <h2><?php echo $row['titolo_blog']?></h2>
                            <p><?php echo $row['descrizione_blog']?></p>
                            <p>Blog di: <?php echo $row['username_utente']?></p>
                            <a href="visual_blog.php?ID_blog=<?php echo $row['ID_blog']?>">Apri</a>         
                    </div>
                    <?php
                }
            }?>
        </div>
        <?php?>
    </div>
    
    <!-- sezione ricerca blog -->
    <div class="search-box" style="margin:2%; padding:2%; float: left; width: 20%;">
        <!-- form ricerca blog per titolo -->
        <h3 id="titoloIndex">Ricerca blog per titolo</h3>
        <form id="name" method="POST">
        <input type="text" id="search" placeholder="Ricerca blog per titolo" />
        </form>
        <!-- form ricerca blog per categoria -->
        <h3 id="titoloIndex">Ricerca blog per categoria</h3>
        <form id="name" method="POST">
        <input type="text" id="search2" placeholder="Ricerca blog per categoria" />
        </form>
        <!-- form ricerca blog per utente --> 
        <h3 id="titoloIndex">Ricerca blog per autore</h3>
        <form id="name" method="POST">
        <input type="text" id="search3" placeholder="Ricerca blog per autore" />
        </form>
        </div>
    </div>
    <!-- Risultati della ricerca per titolo -->
        <div id="display" style="margin:1%; padding:1%; float: right; width: 30%; text-align:center;"></div>
    <!-- Risultati della ricerca per categoria -->
        <div id="display2" style="margin:2%; padding:2%; float: right; width: 20%;"></div>
    <!-- Risultati della ricerca per autore --> 
        <div id="display3" style="margin:2%; padding:2%; float: right; width: 20%;"></div>
  
    <?php }?>

    <script>
        // script per la ricerca per titolo del blog
        function fill(Value) {
            $('#search').val(Value); // assegno un valore all'id #search 
            $('#display').hide(); // nascondo il div #display
        }

        $(document).ready(function() {
        $("#search").keyup(function() { // premendo le key nella testiera, la funzione viene richiamata
            var name = $('#search').val(); // assegno una variabile che prende il valore inserito
           
            if (name == "") { // se il valore è vuoto
                $("#display").html("");
            }
           
            else { // se non è vuoto, faccio la chiamata AJAX
                $.ajax({
                    type: "POST",
                    url: "searchTitle.php",
                    data: {
                        search: name
                    },
                    // in caso di successo
                    success: function(html) {
                        // mostro il risultato in #display
                        $("#display").html(html).show();
                    }
                });
            }
        });
        });

    </script>   

    <script>
        // script per la ricerca per categoria del blog
        function fill(Value) {
            $('#search2').val(Value); // assegno un valore all'id #search 
            $('#display2').hide(); // nascondo il div #display
        }

        $(document).ready(function() {
        $("#search2").keyup(function() { // premendo le key nella testiera, la funzione viene richiamata
            var name = $('#search2').val(); // assegno una variabile che prende il valore inserito
           
            if (name == "") { // se il valore è vuoto
                $("#display2").html("");
            }
           
            else { // se non è vuoto, faccio la chiamata AJAX
                $.ajax({
                    type: "POST",
                    url: "searchCategory.php",
                    data: {
                        search2: name
                    },
                    // in caso di successo
                    success: function(html) {
                        // mostro il risultato in #display
                        $("#display2").html(html).show();
                    }
                });
            }
        });
        });

    </script> 

    <script>
        // script per la ricerca per autore del blog
        function fill(Value) {
            $('#search3').val(Value); // assegno un valore all'id #search 
            $('#display3').hide(); // nascondo il div #display
        }

        $(document).ready(function() {
        $("#search3").keyup(function() { // premendo le key nella testiera, la funzione viene richiamata
            var name = $('#search3').val(); // assegno una variabile che prende il valore inserito
           
            if (name == "") { // se il valore è vuoto
                $("#display3").html("");
            }
           
            else { // se non è vuoto, faccio la chiamata AJAX
                $.ajax({
                    type: "POST",
                    url: "searchAutore.php",
                    data: {
                        search3: name
                    },
                    // in caso di successo
                    success: function(html) {
                        // mostro il risultato in #display
                        $("#display3").html(html).show();
                    }
                });
            }
        });
        });

    </script> 

    
</body>
