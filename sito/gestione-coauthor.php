<?php 

include('db_connect.php');
include('header.php');

$blog = $coautore = $numCoauthor = $utenteSession = '' ;

if(isset($_SESSION['usernameutente'])){
    $utenteSession = mysqli_real_escape_string($conn, $utenteSession);

    if(isset($_GET['ID_blog'])){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $idBlog = mysqli_real_escape_string($conn, $_GET['ID_blog']);

        // sql blog 
        $sqlBlog = "SELECT * FROM blog WHERE ID_blog = $idBlog"; //dati blog
        $risBlog = mysqli_query($conn, $sqlBlog);
        $blog = mysqli_fetch_assoc($risBlog);
        $ID_Blog = $blog['ID_blog'];

        // sql coauthor 
        $sqlCoAuthor = "SELECT DISTINCT username_utente, ID_utente FROM co_autore, utente, blog WHERE ID_utente = utente_coautore and blog_coautore = '$idBlog';";
        $result = $conn -> query($sqlCoAuthor);
    
    }
    
}
?>

<!DOCTYPE html>
<head>
<?php include 'head.php';?>
</head>
<body>

    <div class="coauthor-list">
    <h2 style="text-align:center; margin: 1%; padding: 1%;">Gestione co-autore del blog</h2>
        <?php 
        if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
                ?>
                <p style="text-align:center;"><?php echo $row['username_utente']?></p><p style="text-align:center;"><a href="remove_coauthor.php?ID_utente=<?php echo $row['ID_utente']?>&ID_blog=<?php echo $blog['ID_blog']?>">Rimuovi</a></p>
                </div>
                </p>
                <?php       
            }
        }else{
            ?><p style="text-align:center">Questo blog non ha un coautore</p><?php
        }
        ?>
    
    </div>
    

    <div class="add-coautori">
        <?php if($result -> num_rows < 1){?>
        <h2 style="text-align:center; margin: 1%; padding: 1%;">Aggiungi co-autore</h2>
        <div>
            <div class="frmSearch">
            <form method="post" action="add_coauthor.php?ID_blog=<?php echo $idBlog?>">
            <input type="text" id="username" name="username" placeholder="Cerca utente da aggiungere" />
            <button type="submit" name="add-coauthor" id="add-coauthor">Aggiungi</button>
            </form>
            <div id="suggestion-box"></div>
            </div>
        </div>
        <?php } else {
            ?><h2 style="text-align:center; margin: 1%; padding: 1%;">Aggiungi co-autore</h2><p style="text-align:center; margin: 1%; padding: 1%;"><?php echo 'Puoi avere un solo co-autore';?></p><?php
        }?>
        <script>
        $(document).ready(function() {
            $("#username").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "search_user.php",
                    data: 'keyword=' + $(this).val(),
                    success: function(data) {
                        $("#suggestion-box").show();
                        $("#suggestion-box").html(data);
                        $("#username").css("background", "#FFF");
                    }
                });
            });
        });
        </script>
    </div>
</body>
