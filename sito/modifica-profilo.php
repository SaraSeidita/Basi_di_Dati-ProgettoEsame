<?php 
    include('db_connect.php'); // connessione al database
    include('header.php');
?>

<?php
    
    if(isset($_SESSION['usernameutente'])){
        
        // recupero dati utente 
        $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']); 

        $sql = "SELECT ID_utente, username_utente, email_utente FROM utente WHERE username_utente = '$nomeUtente';";
        $res = mysqli_query($conn, $sql);
        $dati = mysqli_fetch_assoc($res);

        $id = $dati['ID_utente'];
        $username = $dati['username_utente'];
        $email = $dati['email_utente'];
    

            // per la modifica del nome utente
            if(isset($_POST['submit_up_user'])){
                $username2 = mysqli_real_escape_string($conn, $_POST['usernamemodifica']);

                // controllo se il nuovo username è presente nel database
                $check = mysqli_query($conn, "SELECT id_utente FROM utente WHERE username_utente = '$username2'"); 
                $numrows=mysqli_num_rows($check);

                if($numrows > 0){
                    ?><script>
                    // se si inseriscono dei dati già presenti nel database
                    if (window.confirm('Nome utente già esistente')) 
                        {
                            window.location.href='modifica-profilo.php';
                    };
                    </script><?php
                } else {   // altrimenti si aggiornano i dati
                    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']); 

                    // recupero l'id utente
                    $sql = "SELECT ID_utente, username_utente FROM utente WHERE username_utente = '$nomeUtente';";
                    $res = mysqli_query($conn, $sql);
                    $dati = mysqli_fetch_assoc($res);
                    $id = $dati['ID_utente'];

                    // aggiorno il dato
                    $sqlup = "UPDATE utente SET username_utente = '$username2' WHERE ID_utente = '$id';";
                    $resup = mysqli_query($conn, $sqlup);
                    ?>
                        <script>
                        // per confermare la modifica dei dati l'utente deve effettuare nuovamente il login
                        if (window.confirm('Fai di nuovo il login per confermare la modifica dei tuoi dati')) 
                            {
                                window.location.href='login.php';
                        };
                        </script>
                    <?php
                }
        }
            // per la modifica della email, come per il nome utente
            if(isset($_POST['submit_up_email'])){
                $email2 = mysqli_real_escape_string($conn, $_POST['emailmodifica']);

                $check = mysqli_query($conn, "SELECT id_utente FROM utente WHERE email_utente = '$email2'"); 
                $numrows=mysqli_num_rows($check);

                if($numrows > 0){
                    ?><script>
                    // se si inseriscono dei dati già presenti nel database
                    if (window.confirm('Email già esistente')) 
                        {
                            window.location.href='modifica-profilo.php';
                    };
                    </script><?php
                }
                else
                {   // altrimenti si aggiornano i dati
                    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['usernameutente']); 
                    // recupero l'id utente
                    $sql = "SELECT ID_utente, username_utente FROM utente WHERE username_utente = '$nomeUtente';";
                    $res = mysqli_query($conn, $sql);
                    $dati = mysqli_fetch_assoc($res);
                    $id = $dati['ID_utente'];

                    // aggiorno
                    $sqlup = "UPDATE utente SET email_utente = '$email2' WHERE ID_utente = '$id';";
                    $resup = mysqli_query($conn, $sqlup);
                    ?>
                        <script>
                        // per confermare la modifica dei dati
                        if (window.confirm('Fai di nuovo il login per confermare la modifica dei tuoi dati')) 
                            {
                                window.location.href='login.php';
                        };
                        </script>
                    <?php
                }
        }
    }
?>


<!DOCTYPE html>
    <html lang="it">
        <body>
            <?php 
                include 'head.php';
            ?>
            <div class="form-group">
                <h4>Modifica i tuoi dati</h4>
                <form action="modifica-profilo.php" id="modifica" method="POST">
                        <div style="margin:2%;padding:1%;">
                            <label>Username</label>
                            <input type="text" name="usernamemodifica" value="<?php echo $username ?>" id="usernamemodifica">
                            <button type="submit" id="submit_up_user" name="submit_up_user">Invia i tuoi dati</button>
                        </div>   
                        <div style="margin:2%;padding:1%;">
                            <label>Email</label>
                            <input type="text" name="emailmodifica" value="<?php echo $email?>" id="emailmodifica">
                            <button type="submit" id="submit_up_email" name="submit_up_email">Invia i tuoi dati</button>
                        </div>
                </form>
            </div>

            <script>   
                jQuery.validator.addMethod("regex", function(value, element) {
                return this.optional(element) || /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
                }, 'Inserisci una email valida.');
            </script>
            <script>
                $(document).ready(function() {
                    $('#modifica').validate({
                        rules: {
                            usernamemodifica: {
                                required: true,
                                minlength: 3
                            },
                            emailmodifica: {
                                required: true,
                                email: true,
                                regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                            
                            }
                        },
                            messages: {
                                usernamemodifica: {
                                required: 'Inserisci un username!', 
                                minlength: 'Il tuo username deve avere almeno 3 caratteri'
                            },
                            emailmodifica: {
                                required: 'Inserisci la tua email!',
                                email: 'Inserire una email valida!',
                                regex: 'Inserire una email valida!'
                            }
                        }})});
            </script>
        </body>
        <footer>
            <?php include 'footer.php';?>
    </html>