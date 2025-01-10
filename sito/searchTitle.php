<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db_connect.php');

   $search = '';

   if (isset($_POST['search'])) {
      $search = $_POST['search'];
      $Query = "SELECT ID_blog, titolo_blog, username_utente, nome_categoria FROM blog, utente, categoria WHERE titolo_blog LIKE '%$search%' and autore_blog = ID_utente and ID_categoria = categoria_blog LIMIT 5;";
      $ExecQuery = MySQLi_query($conn, $Query);
        
      while ($Result = MySQLi_fetch_array($ExecQuery)) {
          ?>
      <p onclick='fill("<?php echo $Result["titolo_blog"];?>")'></p>
      <p><div class='list-blog-visual'>     
                <h2><?php echo $Result['titolo_blog']?></h2>
                <p>Autore: <?php echo $Result['username_utente']?></p>
                <p>Categoria: <?php echo $Result['nome_categoria']?></p>
                <a href="visual_blog.php?ID_blog=<?php echo $Result['ID_blog']?>">Apri</a>         
      </div>    
      </p>
      </a>
      <?php
   }} else {
      include 'error.php';
   }
?>


