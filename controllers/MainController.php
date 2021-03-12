<?php
class MainController
{
    public function __construct($type ='')
    {
        url_direct('/login');
//        if(getAuth('login_status') == 'Member')
//        {
//            echo("<script>location.replace('/dashboard');</script>");
//        }
//        else {
//            echo("<script>location.replace('/login/');</script>");
//        }
    }
}