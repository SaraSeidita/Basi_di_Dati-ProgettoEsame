<?php 
    include('server.php'); // includo server.php 
?>

<!DOCTYPE html>
    <html lang="it">

    <?php 
        include('head.php'); // includo head.php del sito 
    ?> 

        <body> 

            <div class="form-group">
                <h4 class="title">Registrazione</h4>

                <form id="register-form" method="POST" action="server.php" class="register-form">
                    
                    <div>
                        <div class="form-group">
                                <label for="usernameUtente">Username</label>
                                <input type="text" id="usernameUtente" class="form-control" name="usernameUtente" placeholder="Inserisci un nome utente">
                                <small>Il nome utente è riservato</small> 
                        </div>
                        <div class="form-group">
                                <label for="emailUtente">Email</label>
                                <input type="text" id="emailUtente" class="form-control" name="emailUtente" placeholder="Inserisci la tua email">
                                <small>L'informazione sulla tua email è riservata</small> 
                        </div>
                        <div class="form-group">
                                <label for="passwordUtente">Password</label>
                                <input type="password" id="pw" class="form-control" name="pw" placeholder="Inserisci una password">
                                <small>La password è riservata</small> 
                        </div>
                        <div class="form-group">
                                <label for="password2Utente">Conferma password</label>
                                <input type="password" id="pw2" class="form-control" name="pw2" placeholder="Conferma la password">
                                <small>La password è riservata</small> 
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <button type="submit" name="register-btn">Registrati</button>
                        </div>
                        <p>Sei già iscritto? Vai al <a href="login.php">Login</a></p> 
                    </div>
                    
                </form>          
            </div>
            
            <script>
            // CODICE PER VALIDARE L'EMAIL, usando addMethod, preso dalla documentazione di jquery validation 
            // https://jqueryvalidation.org/jQuery.validator.addMethod/

            jQuery.validator.addMethod("regex", function(value, element) {
            return this.optional(element) || /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
            }, 'Please enter a valid email address.');

            // validazione della form di registrazione
            $(document).ready(function() {
            $('#register-form').validate({
                rules: {
                    usernameUtente: { 
                        required: true,
                        minlength: 3 
                    },
                    emailUtente: {
                        required: true,
                        email: true,
                        regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                    },
                    pw: {
                        required: true,
                        minlength: 8
                    },
                    pw2: {
                        required: true,
                        equalTo: '#pw'
                    }
                },
                    messages: {
                    usernameUtente: { 
                        required: 'Inserisci un username!', 
                        minlength: 'Il tuo username deve avere almeno 3 caratteri'
                    },
                    emailUtente: {
                        required: 'Inserisci la tua email!',
                        email: 'Inserire una email valida!',
                        regex: 'Inserire una email valida!'
                    },
                    pw: {
                        required: 'Inserisci la password',
                        minlength: 'La password deve essere lunga almeno 8 caratteri'
                    },
                    pw2: {
                        required: 'Conferma la tua password',
                        equalTo: 'Le password non corrispondono'
                    }
            }
            })
            });
            </script>

        </body>

        <footer>
        <?php 
            include('footer.php');
        ?> <!-- il footer del sito -->
        </footer>
    </html>