<?php 

include('db_connect.php');

$limit = $_GET['limit'];
$offset = $_GET['offset'];

$sql = "SELECT ID_blog, titolo_blog, descrizione_blog, data_blog, username_utente FROM blog, utente WHERE autore_blog = ID_utente ORDER BY titolo_blog LIMIT $limit OFFSET $offset";
$result = $conn -> query($sql);
if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()){
        ?>
        <p><div class='list-blog-visual'>     
                <h2><?php echo $row['titolo_blog']?></h2>
                <p><?php echo $row['descrizione_blog']?></p>
                <p>Blog di: <?php echo $row['username_utente']?></p>
                <a href="visual_blog.php?ID_blog=<?php echo $row['ID_blog']?>">Apri</a>         
        </div>
        </p>
        <?php       
    }
}
?>
 