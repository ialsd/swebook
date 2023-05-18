<?php
//require_once("settings.php");

class auth_ssh
{
  function login($login, $pwd, $source)
  {
    global $dbconnect;
    session_start();
    $lg = pg_escape_string($login);
    
    $result = pg_query($dbconnect, "SELECT * FROM students WHERE login='$lg'");
    $found = pg_fetch_assoc($result);
    if($found) {
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $found['role'];
            $_SESSION['hash'] = $found['id'];
            return $found['role'];
        }

        return false;
    }
    
//----------------------------------------------------------------------------------------------

    function logout()
    {
        $_SESSION['login'] = '';
        $_SESSION['role'] = 0;
        $_SESSION['hash'] = '';
        $_SESSION['username'] = '';
    }
    
//----------------------------------------------------------------------------------------------
    
    function loggedIn($hash = "") {
        if (array_key_exists('login', $_SESSION)) {
            return $_SESSION['login'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------

function isTeacher($hash = '') {
    if (array_key_exists('role', $_SESSION)) {
        return ($_SESSION['role'] == 2);
    }
    else
        return false;
}

//----------------------------------------------------------------------------------------------
    
    function isAdmin($hash = '')
    {
        if (array_key_exists('role', $_SESSION))
        {
            return ($_SESSION['role'] == 1);
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function isAdminOrTeacher($hash = '') {
        if (array_key_exists('role', $_SESSION)) {
            return (($_SESSION['role'] == 1) || ($_SESSION['role'] == 2));
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function getUserId($hash = '')
    {
        if (array_key_exists('hash', $_SESSION))
        {
            return $_SESSION['hash'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
    
    function getUserLogin($hash = '')
    {
        if (array_key_exists('login', $_SESSION))
        {
            return $_SESSION['login'];
        }
        else
            return false;
    }
    
//----------------------------------------------------------------------------------------------
}
