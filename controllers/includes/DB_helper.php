<?php
//$server_root_path = $_SERVER['DOCUMENT_ROOT'];
//require_once($server_root_path . '/controllers/includes/config.php');

class DB_helper
{
    public $connect;

    function __construct()
    {


    }
    public function Connect()
    {
        $config = new init_Config();
        $this->connect = @mysql_connect($config->host, $config->userid, $config->password, true);
        $db_select = @mysql_select_db($config->dbname, $this->connect);
    }
    public function Select($query)
    {
        $result = mysql_query($query);
        $i = 0;
        $return = array();
        while ($row = mysql_fetch_array($result)) {
            $return[$i] = $row;
            $i++;
        }
        return $return;
    }
    public function Query($query)
    {
        $result = mysql_query($query);
        return $result;
    }
    public function Connect2()
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $db_select = @mysqli_select_db($this->connect, $config->dbname);
    }
    public function Select2($query)
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
        $result = mysqli_query($this->connect, $query);
        $i = 0;
        $return = array();
        while ($row = mysqli_fetch_array($result)) {
            $return[$i] = $row;
            $i++;
        }
        @mysqli_close($this->connect);
        return $return;
    }
    public function Select2_assoc($query)
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
        $result = mysqli_query($this->connect, $query);
        $i = 0;
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[$i] = $row;
            $i++;
        }
        @mysqli_close($this->connect);
        return $return;
    }
    public function Update2($query)
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
        $result = mysqli_query($this->connect, $query);
        @mysqli_close($this->connect);
        return $result;
    }
    public function Delete2($query)
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
        $result = mysqli_query($this->connect, $query);
        @mysqli_close($this->connect);
        return $result;
    }
    public function Insert2($query)
    {
        $config = new init_Config();
        $this->connect = mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
        $result = mysqli_query($this->connect, $query);
        $result = mysqli_query($this->connect, 'SELECT LAST_INSERT_ID();');
        $result = mysqli_fetch_array($result);
        mysqli_close($this->connect);
        return $result[0];
    }
    public function Connection()
    {
        $config = new init_Config();
        $this->connect = @mysqli_connect($config->host, $config->userid, $config->password, $config->dbname);
        $result = mysqli_query($this->connect,"set names utf8;");
    }
    public function Disconnect()
    {
        @mysqli_close($this->connect);
    }
    public function StartTransaction()
    {
        return mysqli_query($this->connect,"START TRANSACTION;");
    }
    public function tInsert($query)
    {
        $result = mysqli_query($this->connect, $query);
        $result = mysqli_query($this->connect, 'SELECT LAST_INSERT_ID();');
        $result = mysqli_fetch_array($result);
        return $result[0];
    }
    public function tSelect($query)
    {
        $result = mysqli_query($this->connect, $query);
        $i = 0;
        $return = array();
        while ($row = mysqli_fetch_array($result)) {
            $return[$i] = $row;
            $i++;
        }
        return $return;
    }
    public function tUpdate($query)
    {
        $result = mysqli_query($this->connect, $query);
        return $result;
    }
    public function Commit()
    {
        return mysqli_query($this->connect,"COMMIT;");
    }
    public function Rollback()
    {
        return mysqli_query($this->connect,"ROLLBACK;");
    }


}