<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db_connect.php');

   $search3 = '';

   if (isset($_POST['search3'])) {
      $search3 = $_POST['search3'];
      $Query3 = "SELECT ID_blog, titolo_blog, username_utente, nome_categoria FROM blog, utente, categoria WHERE username_utente LIKE '%$search3%' and autore_blog = ID_utente and categoria_blog = ID_categoria LIMIT 5;";
      $ExecQuery3 = MySQLi_query($conn, $Query3);
        
      while ($Result3 = MySQLi_fetch_array($ExecQuery3)) {
          ?>
      <p onclick='fill("<?php echo $Result3["titolo_blog"];?>")'></p>
      <p><div class='list-blog-visual'>     
                <h2><?php echo $Result3['titolo_blog']?></h2>
                <p>Blog creato da: <?php echo $Result3['username_utente']?></p>
                <p>Categoria: <?php echo $Result3['nome_categoria']?></p>
                <a href="visual_blog.php?ID_blog=<?php echo $Result3['ID_blog']?>">Apri</a>         
      </div>    
      </p>
      </a>
      <?php
   }} else {
      include 'error.php';
   }
?>
