<?php 
    include('head.php');

    session_start();
    // unset($_SESSION[''])
    session_destroy();
?> 

<body> 
    <div> <p>Sei stato disconnesso!</p> </div>
    <div> <a href="index.php">Torna alla home</a></div>
</body> 


