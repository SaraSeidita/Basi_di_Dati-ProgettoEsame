<?php 

include('db_connect.php');
include('header.php');

    $titoloPost = $dataPost = $testoPost = $idBlog = '';

    
    $errors = array('titoloPost' => '', 'testoPost' => '');

    if (isset($_GET['ID_blog'])) {

        // id del blog in cui inserire il post
        $idBlog = mysqli_real_escape_string($conn, $_GET['ID_blog']);

        $sqlIdBlog = "SELECT ID_blog, titolo_blog FROM blog WHERE ID_Blog = $idBlog";

        $risIdBlog = mysqli_query($conn, $sqlIdBlog);

        $blog = mysqli_fetch_assoc($risIdBlog); 
        $_SESSION['ID_blog'] = $idBlog;
    } 

    if (isset($_POST['crea_post_submit'])) {
        
        $idBlog = $_SESSION['ID_blog'];

        
        if (empty($_POST['titoloPost'])) {
            $errors['titoloPost'] = '<p>' . 'Manca un titolo per il tuo post!' . '</p>';
        } else {
            $titoloPost = $_POST['titoloPost'];
            if (!preg_match('/^[ A-Za-z]+$/', $titoloPost)) {
                echo $errors['titoloPost'] = '<p>' . 'Il titolo deve contenere solo lettere e spazi' . '</p>';
            }
        }

        
        if (empty($_POST['testoPost'])) {
            $errors['testoPost'] = '<p>' . 'Manca una descrizione per il tuo blog!' . '</p>';
        } else {
            $testoPost = $_POST['testoPost'];
        }


        //recupero data timestamp
        $timestamp = date("Y-m-d H:i:s");

        if (!array_filter($errors)) {

            //escape sql chars
            $titoloPost = mysqli_real_escape_string($conn, $_POST['titoloPost']);
            $testoPost = mysqli_real_escape_string($conn, $_POST['testoPost']);
            $dataPost = $timestamp;

            // 
            $nomeUtente = $_SESSION['usernameutente'];

            $sqlIDutentePost = "SELECT ID_utente FROM utente, blog WHERE autore_blog = ID_utente and username_utente = '$nomeUtente';";
            $resultIDPost = mysqli_query($conn, $sqlIDutentePost);
            $datiUtentePost = mysqli_fetch_assoc($resultIDPost);
            $idutentePost = $datiUtentePost['ID_utente'];

            //query creazione post
            $sqlNuovoPost = "INSERT INTO post (ID_post, titolo_post, testo_post, data_post, blog_post, autore_post) VALUES (NULL, '$titoloPost', '$testoPost', '$dataPost', '$idBlog', '$idutentePost');";

            //controlla e salva sul db
            if (mysqli_query($conn, $sqlNuovoPost)) {

                // successo: passo id blog appena creato all'url della pagina visual_blog e lo apro(per permettere all'utente di creare subito un nuovo post)
                $idBlog = $_SESSION['ID_blog'];
                header("Location: visual_blog.php?ID_blog=$idBlog");

            } else {

                //errore
                echo 'errore query: ' . mysqli_error($conn);

            }
        }

        //chiudi connessione
        mysqli_close($conn);
    } 

?>


<!DOCTYPE html>
<?php include 'head.php'?>

    <style>
        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            resize: none;
            background: #ffe4e1;

        }
    </style>

    <body>
        <?php if (isset($_GET['ID_blog'])) { ?>
        <div class="create-new-post">
            <div class="new-post">
                <h4>Crea un nuovo post</h4>
            </div>

            <div class="new-post-form">
                <form method="POST" name="creapost" id="creapost" action="crea_post.php">
                    <label for="titoloPost">Titolo post</label>
                    <input type="text" id="titoloPost" name="titoloPost" placeholder="Inserisci un titolo">

                    <label for="testoPost">Testo post</label>
                    <textarea type="text" id="testoPost" name="testoPost" placeholder="Inserisci un testo per il tuo post"></textarea>

                    <button type="submit" value="Crea" id="crea_post_submit" name="crea_post_submit">Invia</button> 
                </form>
            </div>
        <?php } else {
        include 'error.php';
        }?>
                <script>
                    $(document).ready(function(){
                        $('#creapost').validate({
                            rules: {
                                titoloPost: 'required',
                                testoPost: {
                                    required: true,
                                }
                            }, 
                                messages: {
                                    titoloPost: 'Devi inserire un titolo per il tuo post',
                                    testoPost: {
                                        required: 'Devi inserire il testo per il tuo post'
                                    }
                                }
                        })
                    })
                </script>
</body>