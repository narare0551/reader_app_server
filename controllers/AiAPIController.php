<?php
class AiAPIController
{
/*
 * json {filetoUpload : 파일,
 *       filetoUpload_result : 파일,
 *       mac_addr : 스캐너 블루투스 및 타블렛 wifi 맥어드레스,
 *       result_data : 결과값,
 *       accuracy : 정확도,
 *       userid : 사용자,
 *       barcode : 바코드
 *       modelid : 모델id
 *       factoryid : 사업장코드
 *       menu_name : 메뉴명
 *       process_code : 공정코드
 *       battery : 공정코드
 *       }
 */
    public function __construct($type ='')
    {
        if($type=='scan_data') {
            $this->scan_save();
        }
        else if($type == 'history'){
            returnData(json_encode($this->history()));
        }
        else if($type == 'history_detail'){
            returnData(json_encode($this->history_detail()));
        }
        else if($type == 'update_history'){
            $result = $this->update_history();
            if($result > 0){
                returnData("true");
            }else{
                returnData("false");
            }
        }
        else if($type == 'save_data'){
            $this->save_data();
        }
    }
    private function scan_save()
    {
        $db_helper = new DB_helper();
        $upload_directory = 'files/ocr/';
        $result_img_idx1 = "";
        $result_img_idx2 = "";
        if(!is_dir($upload_directory))
        {
            mkdir($upload_directory);
        }

        if(isset($_FILES['filetoUpload'])) {
            $file = $_FILES['filetoUpload'];

            $file_name = $file['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = $file_extension[count($file_extension) - 1];
            $file_size = $file['size'];
            $file_type = $file['type'];
            $file_temp_name = explode('/', $file['tmp_name']);
            $file_temp_name = $file_temp_name[count($file_temp_name) - 1];    //현재시간+난수를 발생하여 구해도 좋다
            $query = "insert into scan_data set ";
            $query .= "menu_name='".$_REQUEST['menu_name']."', ";
            $query .= "device_mac_addr='".$_REQUEST['mac_addr']."', ";
            $query .= "reg_dttm=sysdate(), ";
            $query .= "result_data='".$_REQUEST['result_data']."', ";
            $query .= "upload_file_idx_result='', ";
            $query .= "upload_file_idx_image='', ";
            $query .= "accuracy='".$_REQUEST['accuracy']."', ";
            $query .= "reg_user_id='".$_REQUEST['userid']."', ";
            $query .= "model_id='".$_REQUEST['modelid']."', ";
            $query .= "factory_id='".$_REQUEST['factoryid']."', ";
            $query .= "process_code='".$_REQUEST['process_code']."', ";
            $query .= "barcode='".$_REQUEST['barcode']."', ";
            $query .= "battery='".$_REQUEST['battery']."'; ";
            $result_idx = $db_helper->Insert2($query);


            if (move_uploaded_file($file['tmp_name'], $upload_directory.$file_temp_name)) {


                $query = "insert into upload_file set ";
                $query .= "table_name='scan_data', ";
                $query .= "db_name='nobis3', ";
                $query .= "save_file_name='".$file_temp_name."', ";
                $query .= "real_file_name='".$file_name."', ";
                $query .= "file_type='".$file_type."', ";
                $query .= "file_size='".$file_size."', ";
                $query .= "file_path='".$upload_directory."', ";
                $query .= "reg_dttm=sysdate(), ";
                $query .= "table_name_idx='".$result_idx."' ";
                $result_img_idx1 = $db_helper->Insert2($query);
            }
        }
        if(isset($_FILES['filetoUpload_result'])) {
            $file2 = $_FILES['filetoUpload_result'];

            $file_name2 = $file2['name'];
            $file_extension2 = explode('.', $file_name2);
            $file_extension2 = $file_extension2[count($file_extension2) - 1];
            $file_size2 = $file2['size'];
            $file_type2 = $file2['type'];
            $file_temp_name2 = explode('/', $file2['tmp_name']);
            $file_temp_name2 = $file_temp_name2[count($file_temp_name2) - 1];    //현재시간+난수를 발생하여 구해도 좋다

            if (move_uploaded_file($file2['tmp_name'], $upload_directory.$file_temp_name2)) {

                $query = "insert into upload_file set ";
                $query .= "table_name='scan_data', ";
                $query .= "db_name='nobis3', ";
                $query .= "save_file_name='".$file_temp_name2."', ";
                $query .= "real_file_name='".$file_name2."', ";
                $query .= "file_type='".$file_type2."', ";
                $query .= "file_size='".$file_size2."', ";
                $query .= "file_path='".$upload_directory."', ";
                $query .= "reg_dttm=sysdate(), ";
                $query .= "table_name_idx='".$result_idx."' ";
                $result_img_idx2 = $db_helper->Insert2($query);
            }
        }

        $query = "update scan_data set ";
        $query .= "upload_file_idx_result='".$result_img_idx1."', ";
        $query .= "upload_file_idx_image='".$result_img_idx2."' ";
        $query .= "where idx=".$result_idx.";";
        $db_helper->Update2($query);

        $sql = "select * from device_info";
        $list = $db_helper->Select2($sql);
        foreach($list as $row){
            $sql = "insert into pushalarm (device_mac, title, content, reg_dttm, status, read_check, scan_data_idx) values ('".$row['mac_addr']."','신규작업','".$_REQUEST['menu_name']."메뉴에서 신규작업 발생', sysdate(),'X','X','$result_idx') ";
            $db_helper->Insert2($sql);
        }
    }

    private function history()
    {
        //dd($_REQUEST);
        $db_helper = new DB_helper();
        $sql = "select scan_data.*, user.name from scan_data left join user on user.user_id = scan_data.reg_user_id where 1=1 ";
        if(!empty($_REQUEST['start_dttm']) && !empty($_REQUEST['end_dttm'])){
          $start_dttm =  $_REQUEST['start_dttm'];
          $end_dttm =  $_REQUEST['end_dttm'];
          $sql .= " and date_format(scan_data.reg_dttm,'%Y-%m-%d') >= '".$start_dttm."' and  date_format(scan_data.reg_dttm,'%Y-%m-%d') <= '".$end_dttm."'";
        }

        $sql .= "order by idx desc";
        $result = $db_helper->Select2($sql);
        return $result;
    }

    private function history_detail()
    {
        $idx = $_REQUEST['idx'];
        $db_helper = new DB_helper();
        $sql = "select scan_data.*,  upload_file.* from scan_data left join  upload_file on upload_file.idx = scan_data.upload_file_idx_image where scan_data.idx = '".$idx."'";
        $result = $db_helper->Select2($sql);
        return $result[0];
    }
    private function update_history()
    {
        $idx = $_REQUEST['idx'];
        $user_result_data = $_REQUEST['user_result_data'];
        $db_helper = new DB_helper();
        $sql = "update scan_data set user_result_data = '".$user_result_data."' where idx = '".$idx."'";
        $result = $db_helper->Update2($sql);
        return $result;
    }

    private function save_data()
    {
        $db_helper = new DB_helper();
        $sql = "insert into scan_data set ";
        foreach ($_REQUEST as $key => $value) {
            $sql .= $key . "='" . str_replace("'", "\'", $value) . "', ";
        }
        $sql .= " reg_dttm = sysdate()";
        $result = $db_helper->Insert2($sql);
    }

}