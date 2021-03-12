<?php

session_start();
function getAuth($key = '')
{
    if($key == '')
    {
        return $_SESSION;
    }
    else
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        else
        {
            return '';
        }
    }
}
function checkLogin()
{
    if(getAuth('login_status') == 'login')
    {
        return true;
    }
    else {
        return false;
    }
}
function destroyAuth()
{
    session_destroy();
}
function setAuth($key, $data)
{
    $_SESSION[$key] = $data;
}