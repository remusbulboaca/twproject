<?php


function redirect($location){
    return header("location:{$location}");
}

require_once ('includes/functions/config.php');

if(isset($_COOKIE['username'])){
    unset($_COOKIE['username']);
    setcookie('username','',time()-86400);
}
session_destroy();
redirect('profile-nologin.php');
?>