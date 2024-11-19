<?php

function logout()
{


    session_unset();
    session_destroy();
    setcookie("user_role", '', time() - 3600, "/");
    
    header('Location: login.php');
}


require 'config/session.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    logout(); 
    exit();
} else {
  
    header('Location: login.php');
    exit();
}
