<?php include('server.php')?>

<!DOCTYPE html>
    <html lang="it">

    <?php 
        include 'head.php'; // HEAD DEL SITO 
    ?>

        <body>
            <div>
                <h4 class="title">Login</h4>
                    <!-- FORM LOGIN -->
                <form id="formLogin" method="POST" action="server.php">
                    <div>
                        <div class="form-group">
                            <label for="loginUsername">Username</label>
                            <input type="text" id="loginUsername" class="form-control" name="loginUsername" placeholder="Inserisci il tuo nome utente">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" class="form-control" name="loginPassword" placeHolder="Inserisci la tua password">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <button type="submit">Fai il login</button>
                        </div>
                        <p>Non sei ancora iscritto? Allora vai alla</p> <a href="register.php">registrazione</a>
                    </div>
                </form>
            </div>

    <script>
        $(document).ready(function() {
      $('#formLogin').validate({
        rules: {
            loginUsername: { 
                required: true,
                minlength: 3 
            },
            loginPassword: {
                required: true,
                minlength: 8
            }
        },
            messages: {
            loginPassword: { 
                required: 'Inserisci il tuo username!', 
                minlength: 'Il tuo username deve avere almeno 3 caratteri'
            },
            loginPassword: {
                required: 'Inserisci la tua password',
                minlength: 'La password deve essere lunga almeno 8 caratteri'
            }
        }
        })
        });
    </script>

</body> 

<?php include('footer.php')?>

