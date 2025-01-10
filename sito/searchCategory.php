<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db_connect.php');

   $search2 = '';

   if (isset($_POST['search2'])) {
      $search2 = $_POST['search2'];
      $Query2 = "SELECT ID_blog, titolo_blog, username_utente, nome_categoria FROM blog, utente, categoria WHERE nome_categoria LIKE '%$search2%' and autore_blog = ID_utente and categoria_blog = ID_categoria LIMIT 5;";
      $ExecQuery2 = MySQLi_query($conn, $Query2);
        
      while ($Result2 = MySQLi_fetch_array($ExecQuery2)) {
          ?>
      <p onclick='fill("<?php echo $Result2["titolo_blog"];?>")'></p>
      <p><div class='list-blog-visual'>     
                <h2><?php echo $Result2['titolo_blog']?></h2>
                <p>Blog creato da: <?php echo $Result2['username_utente']?></p>
                <p>Categoria: <?php echo $Result2['nome_categoria']?></p>
                <a href="visual_blog.php?ID_blog=<?php echo $Result2['ID_blog']?>">Apri</a>         
      </div>    
      </p>
      </a>
      <?php
   }} else {
      include 'error.php';
   }
?>
