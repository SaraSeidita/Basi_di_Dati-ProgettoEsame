<?php 

include('db_connect.php');

$utenteusername = $idBlog = $idUtente = '';

    if(isset($_GET['ID_blog'])){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $idBlog = mysqli_real_escape_string($conn, $_GET['ID_blog']);
        
        // sql blog 
        $sqlBlog = "SELECT * FROM blog WHERE ID_blog = '$idBlog';"; //dati blog
        $risBlog = mysqli_query($conn, $sqlBlog);
        $blog = mysqli_fetch_assoc($risBlog);

        if(isset($_POST['add-coauthor'])){

            $utenteusername = mysqli_real_escape_string($conn, $_POST['username']);
    
            // sql utente 
            $sqlUtente = "SELECT * FROM utente WHERE username_utente = '$utenteusername';";
            $risUtente = mysqli_query($conn, $sqlUtente);
            $utente = mysqli_fetch_assoc($risUtente);

                // se il nome utente esiste 
                if(mysqli_num_rows($risUtente) == 1){

                    $idBlog = $blog['ID_blog'];
                    $idUtente = $utente['ID_utente'];

                    // controllo se il coautore è già inserito 
                    $sqlCoAutore = "SELECT utente_coautore, blog_coautore FROM co_autore, utente, blog WHERE utente_coautore = $idUtente and blog_coautore = $idBlog;";
                    $risCoAutore = mysqli_query($conn, $sqlCoAutore);


                    if(mysqli_num_rows($risCoAutore) == 0){
                        $sqlAdd = "INSERT INTO co_autore (ID_CoAutore, blog_coautore, utente_coautore) VALUES (NULL, '$idBlog', '$idUtente');";
                            if(mysqli_query($conn, $sqlAdd)){
                                header("Location: gestione-coauthor.php?ID_blog=$idBlog");
                            } else {
                                echo 'error';
                            }
                    } elseif(mysqli_num_rows($risCoAutore) > 0) 
                    { ?><script>
                        // perciò l'utente verrà riportato alla registrazione per reinserire nuovi dati
                        if (window.confirm('Utente già inserito come co-autore')) 
                            {
                                window.location.href='gestione-coauthor.php?ID_blog=<?php echo $idBlog?>';
                        };
                    </script><?php

                    } else {
                        echo 'error';
                    }
            } elseif(mysqli_num_rows($risUtente) == 0){
                ?><script>
                        // perciò l'utente verrà riportato alla registrazione per reinserire nuovi dati
                        if (window.confirm('Il nome utente non esiste')) 
                            {
                                window.location.href='gestione-coauthor.php?ID_blog=<?php echo $idBlog?>';
                        };
                    </script><?php
            }
} else {
    include 'error.php';
}

}
