<?php 
// distinzione tra utente anonimo e utente loggato 
include('server.php');
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['usernameutente'])){
    include 'user_log.php';
} else {
    include 'user_anon.php';
}
?>