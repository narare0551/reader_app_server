<?php
//include $_SERVER['DOCUMENT_ROOT'].'/models/CustomersManagement.php';
class ItemController
{
    function __construct($type ='')
    {
        if($type == 'getList')
        {
            $result = $this->getlist();
            returnData(json_encode($result));
        }
    
    }
    
    function getlist(){
        $db_helper = new DB_helper;
        $sql = "select * from item order by idx desc";
        $list = $db_helper->Select2($sql);
        return $list;
    }
}