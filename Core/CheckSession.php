<?php
namespace Core;

class CheckSession {
    
    static public function sessionAuth()
    {
        if(isset($_SESSION['fingerPrint']) and $_SESSION['fingerPrint'] === md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']))
        {
            return true;
        }
        else
        {
            View::renderTemplate('User/login.php');
        }
    }
}

?>