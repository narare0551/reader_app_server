<?php
//include $_SERVER['DOCUMENT_ROOT'].'/models/CustomersManagement.php';
class UserController
{
    function __construct($type ='')
    {
        if($type == 'id_check')
        {
            $result = $this->id_check();
            returnData($result);
        }
        else if($type == 'sign_up')
        {
            $result = $this->sign_up();
            returnData($result);
        }
        else if($type == 'login')
        {
            $result = $this->login();
            if($result == 'error'){
                returnData($result);
            }else{
                returnData(json_encode($result));
            }
        }
    }
    
    function id_check(){
        $db_helper = new DB_helper;
        $user_id = $_REQUEST['user_id'];
        $sql = "select * from user where user_id = '".$user_id."'";
        $list = $db_helper->Select2($sql);
        if(count($list)>0){
            return "error";
        }else{
            return "available";
        }
    }

    function sign_up(){
        $db_helper = new DB_helper;
        $sql = "insert into user set ";
        foreach ($_REQUEST as $key => $value) {
            if($key == 'user_pw'){
                $sql .= $key. "= password('".$value."') ,";
            }else{
                $sql .= $key . "='" . str_replace("'", "\'", $value) . "', ";
            }
        }
        $sql .= " status='Y', reg_user_id ='".$_REQUEST['user_id']."', reg_dttm = sysdate()";
        $result = $db_helper->Insert2($sql);

        if($result > 0){
            return "true";
        }else{
            return "error";
        }
    }

    function login(){
        $db_helper = new DB_helper;
        $sql = "select * from user where user_id = '".$_REQUEST['user_id']."' and user_pw = password('".$_REQUEST['user_pw']."')";
        $list = $db_helper->Select2($sql);
        if(count($list)>0){
            return $list;
        }else{
            return "error";
        }
    }
}