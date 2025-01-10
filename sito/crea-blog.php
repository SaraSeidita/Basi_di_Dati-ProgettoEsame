<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$nomeUtente = $_SESSION['usernameutente'];

// recupero ID utente e sql blog creati dall'utente loggato(se sono più di 3 e l'utente non è premium, devo nascondere la pagina)
$sqlIDutente = "SELECT ID_utente FROM utente WHERE username_utente = '$nomeUtente';";
$resultID = mysqli_query($conn, $sqlIDutente);
$datiUtente = mysqli_fetch_assoc($resultID);
$idutente = $datiUtente['ID_utente'];

$sqlContaBlog = "SELECT COUNT(*) as contati FROM blog WHERE autore_blog = '$idutente'";
$risContaBlog = mysqli_query($conn, $sqlContaBlog);
$numBlog = mysqli_fetch_assoc($risContaBlog);

// recupero tipo utente
$sqlTipoUtente = "SELECT tipo_utente FROM utente WHERE username_utente = '$nomeUtente'";
$risTipoUtente = mysqli_query($conn, $sqlTipoUtente);
$tipoUtente = mysqli_fetch_assoc($risTipoUtente);


// accedono a crea blog solo gli utenti normali che hanno meno di 3 blog o quelli che sono premium
if (($tipoUtente['tipo_utente'] == "Semplice" && $numBlog['contati'] < 5) || $tipoUtente['tipo_utente'] == "Premium") {

    //inizializzo le variabili vuote 
    $titolo = $descrizione = $data = $id_categoria = $id_sottocategoria = $nome_categoria = $nome_sottocategoria = $descrizione = '';

    //array associativo che immagazzina gli errori
    $errors = array('titoloBlog' => '', 'descBlog' => '', 'catBlog' => '', 'sotCatBlog' => '');

    // mi prendo le categorie e sottocategorie per i controlli sul form e per controllare se sono già esistenti nel db
    $sqlCategorie = "SELECT * FROM categoria";
    $risCategorie = mysqli_query($conn, $sqlCategorie);
    $categorie = mysqli_fetch_all($risCategorie, MYSQLI_ASSOC);

    $sqlSottocategorie = "SELECT * FROM sottocategoria";
    $resSottocategorie = mysqli_query($conn, $sqlSottocategorie);
    $sottocategorie = mysqli_fetch_all($resSottocategorie, MYSQLI_ASSOC);

    if (isset($_POST['creablog_invia'])) {

        // check titolo blog
        if (empty($_POST['titoloBlog'])) {
            $errors['titoloBlog'] = '<p>' . 'Manca un titolo per il tuo blog.' . '</p>';
        } else {
            $titolo = $_POST['titoloBlog'];
        }

        //check descrizione
        if (empty($_POST['descBlog'])) {
            $errors['descBlog'] = '<p>' . 'Manca una descrizione per il tuo blog!' . '</p>';
        } else {
            $descrizione = $_POST['descBlog'];
        }

        
        //check categoria
        if (empty($_POST['catBlog'])) {
            $errors['catBlog'] = '<p>' . 'Manca una categoria per il tuo blog!' . '</p>';
        } else {

            $nome_categoria = mysqli_real_escape_string($conn, $_POST['catBlog']); // variabili di utility per nome categoria inserito da utente

            if (!preg_match('/^[ A-Za-z]+$/', $nome_categoria)) {

                echo $errors['catBlog'] = '<p style="color:red;">Categoria deve contenere solo lettere e spazi' . '</p>';

            } else {
                // cerco la categoria nella tabella categorie se presente
                $trovato = $i = 0;
                while ($i < sizeof($categorie) and !$trovato) {
                    if (strtolower($nome_categoria) === strtolower($categorie[$i]['nome_categoria'])) {
                        $id_categoria = $categorie[$i]['ID_categoria'];
                        $trovato = 1;
                    }
                    $i = $i + 1;
                }
                // se non la trovo la inserisco perché nuova
                if (!$trovato) {
                    $sqlInserisciCateg = "INSERT INTO categoria (ID_categoria, nome_categoria) VALUES('NULL', '$nome_categoria')";

                    if (mysqli_query($conn, $sqlInserisciCateg)) {
                        $id_categoria = mysqli_insert_id($conn);
                    } else {
                        echo "Inserimento fallito per la nuova categoria";
                    }
                }

            }
        }
     
        // check sottocategoria, come per la categoria
        if (empty($_POST['sotCatBlog'])) {
            $errors['sotCatBlog'] = '<p>' . 'Manca una sottocategoria per il tuo blog!' . '</p>';
        } else {
       
            $nome_sottocategoria = mysqli_real_escape_string($conn, $_POST['sotCatBlog']); 

            if (!preg_match('/^[ A-Za-z]+$/', $nome_sottocategoria)) {

                echo $errors['sotCatBlog'] = 'La sottocategoria deve contenere solo lettere e spazi' . '</p>';

            } else {
                // cerco categoria in db tabella categorie
                $found = $n = 0;
                while ($n < sizeof($sottocategorie) and !$found) {

                    if (strtolower($nome_sottocategoria) === strtolower($sottocategorie[$n]['nome_sottocategoria'])) {
                        $id_sottocategoria = $sottocategorie[$n]['ID_sottocategoria'];
                        $found = 1;
                    }
                    $n = $n + 1;

                }
                // se non la trovo la inserisco
                if (!$found) {
                    $sqlInserisciSottoCateg = "INSERT INTO sottocategoria (ID_sottocategoria, nome_sottocategoria, categoria_padre, categoria_figlio) VALUES('NULL', '$nome_sottocategoria', '$id_categoria', '$id_categoria')";

                    if (mysqli_query($conn, $sqlInserisciSottoCateg)) {
                        $id_sottocategoria = mysqli_insert_id($conn);
                    } else {
                        echo "Inserimento fallito per la nuova categoria";
                    }
                }

            }
        }

        //recupero data timestamp
        $timestamp = date("Y-m-d H:i:s");

        //se non ci sono errori
        if (!array_filter($errors)) {

            //escape sql chars
            $titolo = mysqli_real_escape_string($conn, strtolower($_POST['titoloBlog']));
            $descrizione = mysqli_real_escape_string($conn, $_POST['descBlog']);
            
            $data = $timestamp;
            
            $sqlIDutenteBlog = "SELECT ID_utente FROM utente WHERE username_utente = '$nomeUtente';";
            $resultIDBlog = mysqli_query($conn, $sqlIDutenteBlog);
            $datiUtenteBlog = mysqli_fetch_assoc($resultIDBlog);
            $idutenteBlog = $datiUtenteBlog['ID_utente'];

            //tabella sql in cui inserire il dato
            $sqlNuovoBlog = "INSERT INTO blog (titolo_blog, descrizione_blog, data_blog, autore_blog, categoria_blog, sottocategoria_blog) VALUES('$titolo', '$descrizione', '$data', '$idutenteBlog', '$id_categoria', '$id_sottocategoria')";

            //controlla e salva sul db
            if (mysqli_query($conn, $sqlNuovoBlog)) {
                header("Location: gestione-blog.php");
            } else {
                //errore
                echo 'errore query: ' . mysqli_error($conn);
            }
        }
        //chiudi connessione
        mysqli_close($conn);
    }
} 
?>

<!DOCTYPE html>
    <html lang="it">
        <?php include 'head.php'?> 

        <body>
            <?php if (($tipoUtente['tipo_utente'] == "Semplice" && $numBlog['contati'] < 5) || $tipoUtente['tipo_utente'] == "Premium") {?>
            <div class="create-blog-page">
                <div class="new-blog">
                    <h4>Ciao <?php echo $nomeUtente ?></h4>
                    <h4>Crea un nuovo blog</h4>
                </div>

                <div class="form-group">
                    <form method="POST" name="creablog" id="creablog" action="crea-blog.php">
                        <label for="titoloBlog">Titolo blog</label>
                        <input type="text" id="titoloBlog" name="titoloBlog" placeholder="Inserisci un titolo">

                        <label for="descBlog">Descrizione blog</label>
                        <input type="text" id="descBlog" name="descBlog" placeholder="Inserisci una breve descrizione del tuo blog">

                        <label for="catBlog">Categoria blog:</label> 
                        <input type="text" id="catBlog" name="catBlog" placeholder="Inserisci una categoria per il blog">

                        <label for="sotcatBlog">Sottocategoria blog:</label>
                        <input type="text" id="sotCatBlog" name="sotCatBlog" placeholder="Inserisci una sottocategoria">
                        
                        <button type="submit" value="Crea" id="creablog_invia" name="creablog_invia">Invia</button> 
                    </form>
                </div>
            </div>
            <?php } else {
                echo '<h4 style="text-align:center">Ops</h4><p style="text-align:center"><span>Hai creato il massimo di blog</span></p>';
                echo '<h3 style="text-align:center"><span>Vuoi crearne altri?</span></h3>';
                echo '<p style="text-align:center"><a href="premium.php">Diventa Premium</a></p>';
            }
            ?>
                
                <script>
                    $(document).ready(function(){
                        $('#creablog').validate({
                            rules: {
                                titoloBlog: {
                                    required: true,
                                },
                                descBlog: {
                                    required: true,
                                    maxlength: 160
                                },
                                catBlog: {
                                    required: true
                                },
                                sotCatBlog: {
                                    required: true
                                }
                            }, 
                                messages: {
                                    titoloBlog: 'Devi inserire un titolo per il tuo blog',
                                    descBlog: {
                                        required: 'Devi inserire la descrizione per il tuo blog',
                                        maxlength: 'La descrizione può contenere al massimo 160 caratteri'
                                    }, 
                                    catBlog: 'Devi inserire la categoria per il tuo blog', 
                                    sotCatBlog: 'Devi inserire la sottocategoria per il tuo blog'
                            }
                        })
                    })
                    </script>         
        </body>
        
    
        <footer>
            <?php include('footer.php');?>
        </footer>

</html>

