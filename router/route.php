<?php

class Route
{
    private $_uri = array();
    private $_method = array();
    public function add($uri, $method = null)
    {
        $this->_uri[] = '/'.trim($uri, '/');
        if($method != null)
        {
            $this->_method[] = $method;
            include 'controllers/'.$method.'.php';
        }
    }
    public function submit()
    {

        $_GET['uri'] = str_replace('/bumhoerp', '', $_SERVER['REQUEST_URI']);
//        if(substr($_GET['uri'], -1) != '/')
//        {
//            $_GET['uri'] .= '/';
//        }
        $check_uri = false;
        $uriGetProgram = $_GET['uri'];
        foreach ($this->_uri as $key => $value) {
            $value_arr = explode('/', $value);
            $uri_arr = explode('/', $uriGetProgram);

            $check_type = "";
            $check_index = 0;
            for ($i = 0; $i < count($value_arr); $i++) {
                $check_value = str_split($value_arr[$i], 1);
                if ($check_value[0] == '{' && $check_value[count($check_value) - 1] == '}') {
                    $check_type = "parameter";
                    $check_index = $i;

                }
            }

            if (count($value_arr) == count($uri_arr)) {
                if ($check_type == 'parameter') {
                    $check_uri = false;
                    for ($i = 0; $i < count($value_arr); $i++) {
                        if ($i != $check_index) {
                            if ($value_arr[$i] == $uri_arr[$i]) {
                                $check_uri = true;
                            } else {
                                $check_uri = false;
                                break;
                            }
                        }
                    }

                    if ($check_uri) {
                        $useMethod = $this->_method[$key];

                        new $useMethod($uri_arr[$check_index]);

//                        call_user_func($this->_method[$key], $uri_arr[$check_index]);
                        break;
                    }


                } else {
                    if ($value == $uriGetProgram) {
                        if (is_string($this->_method[$key])) {
                            $useMethod = $this->_method[$key];
                            $check_uri = true;
                            new $useMethod();
                            break;
                        } else {
                            $check_uri = true;
                            call_user_func($this->_method[$key]);
                            break;
                        }
                    }
                }
            } else if (count($value_arr) - 1 == count($uri_arr)) {
                for ($i = 0; $i < count($value_arr) - 1; $i++) {
                    if ($i != $check_index) {
                        if ($value_arr[$i] == $uri_arr[$i]) {
                            $check_uri = true;
                        } else {
                            $check_uri = false;
                            break;
                        }
                    }
                }
                if ($check_uri) {
                    $useMethod = $this->_method[$key];
                    new $useMethod();
//                        call_user_func($this->_method[$key], $uri_arr[$check_index]);
                    break;
                }

            }

        }
        if (!$check_uri) {
            echo("<script>location.replace('/error');</script>");
        }
    }
}