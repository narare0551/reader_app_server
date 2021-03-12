<?php
    function getTitle()
    {
        $config = new init_Config();
        return $config->title;
    }
    //api 값을 리턴하는 함수
    function returnData($obj, $json = false)
    {
        if($json == true) {
            echo json_encode($obj);
        }
        else{
            echo $obj;
        }
    }
    //인자변수 값을 확인하는 함수
    function dd($show)
    {
        echo "<pre>";
        print_r($show);
        die(1);
    }
    //view내용을 로드하는 함수
    function view($template, $data = [])
    {
        if (is_file($template)) {
            ob_start();
            include $template;
//            return ob_get_clean();
        }
    }
    //다른주소로 연결하는 함수
    function url_direct($url)
    {
        echo "<script>location.replace('" . $url . "');</script>";
    }
    //모델의 옵션 값 기준하여 자동으로 query의 where문 생성
    function makeSearchQuery($search_options, $search_data)
    {
        $where = ' where 1=1 ';
        foreach($search_data as $key=>$value)
        {
            if($value != '') {
                foreach ($search_options as $row) {
                    if($row['hidden'] == false) {
                        if ($key == $row['column']) {
                            $where .= $row['where'] . ' ' . $row['column'] . ' ';
                            if ($row['condition1'] == 'like') {
                                $where .= $row['condition1'] . " '%" . $value . "%' ";
                            } else {
                                $where .= $row['condition1'] . " '" . $value . "' ";
                            }
                        }
                    }
                }
            }
        }
        return $where;
    }
    //모델의 옵션 값 기준하여 자동으로 검색창 html소스 생성
    function makeSearchHtml($search_options)
    {
        $html ='';
        $total_cnt = count($search_options) - 1;
        $now_cnt = 0;
        foreach($search_options as $row) {
            $html .= '<div class="col-md-2">';
            $html .= '    <div class="form-group pb0">';

            if($now_cnt == $total_cnt)
            {
                $html .= '      <label for="search_'.$row['column'].'" class="col-sm-4 control-label pl0 pr1">'.$row['search_name'].'</label>';
                $html .= '        <div class="col-sm-6 p0">';
            }
            else{
                $html .= '      <label for="search_'.$row['column'].'" class="col-sm-4 control-label pl0 pr0">'.$row['search_name'].'</label>';
                $html .= '        <div class="col-sm-8">';
            }
            if($row['type'] == 'text')
            {
                $html .= '          <input type="text" class="form-control" id="search_'.$row['column'].'" placeholder="'.$row['search_name'].'">';
            }
            else if($row['type'] == 'select')
            {
                $html .= '          <select class="form-control" id="search_'.$row['column'].'">';
                $html .= '              <option value="">[전체]</option>';
                for($i=0;$i<count($row['data']);$i++)
                {
                    $selected = '';
                    if($row['data'][$i]['selected'] == true)
                    {
                        $selected = " selected";
                    }
                    $html .= '              <option value="'.$row['data'][$i]['value'].'"'.$selected.'>'.$row['data'][$i]['text'].'</option>';
                }
                $html .= '          </select>';
            }
            $html .= '    </div>';
            if($now_cnt == $total_cnt)
            {
                $html .= '        <div class="col-sm-2 m0 p0">';
                $html .= '                <a href="javascript:getList();" class="btn btn-default"><i class="fa fa-fw fa-search"></i></a>';
                $html .= '        </div>';
            }
            $html .= '  </div>';
            $html .= '</div>';
//            $now_cnt++;
        }
        return $html;
    }
    function makeDetailHtml($write_form)
    {


        $html ='';
        foreach($write_form as $row)
        {
            if($row['hidden'] == true)
            {
                $html .= '<input type="hidden" class="form-control" id="detail_form_'.$row['field'].'" placeholder="'.$row['label'].'" value="'.$row['default'].'">';
            }
            else
            {
                if($row['type'] == 'text')
                {
                    $html .= makeInputBox($row);
                }
                else if($row['type'] == 'password')
                {
                    $html .= makeInputBox($row);
                }
                else if($row['type'] == 'select')
                {
                    $html .= makeSelectBox($row);
                }
                else if($row['type'] == 'textarea')
                {
                    $html .= makeTextareaBox($row);
                }
                else if($row['type'] == 'date')
                {
                    $html .= makeDatepicker($row);
                }
            }
        }
        return $html;
    }
    function makeInputBox($row)
    {
        $html = "";
        $add_class = "";
        if($row['duplicate'] == true)
        {
            $add_class .= " duplicate ";
        }
        if($row['required'] == true)
        {
            $add_class .= " required ";
        }
        $add_status = "";
        if($row['readonly'] == true)
        {
            $add_status .= " readonly ";
        }
        if($row['disabled'] == true)
        {
            $add_status .= " disabled ";
        }
        $add_style = "";
        $add_function = "";
        if($row['align'] == 'left')
        {
            $add_style .= "text-align:left;";
        }
        else if($row['align'] == 'right')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'center')
        {
            $add_style .= "text-align:center;";
        }
        else if($row['align'] == 'int')
        {
            $add_style .= "text-align:right;";
            $add_function .= "onkeyup=\"commapoint_format(this, 0, '".$row['align']."');\"";
        }
        else if($row['align'] == 'float')
        {
            $add_style .= "text-align:right;";
            $add_function .= "onkeyup=\"commapoint_format(this, 0, '".$row['align']."');\"";
        }
        $html .= '<div class="col-md-'.$row['md-col'].'" style="height:40px;">';
        $html .= '    <div class="form-group">';
        $html .= '        <label for="detail_form_'.$row['field'].'" class="col-sm-'.(12-$row['sm-col']).' control-label" id="label_'.$row['field'].'">'.$row['label'].'</label>';
        $html .= '        <div class="col-sm-'.$row['sm-col'].'">';
        $html .= '            <input type="'.$row['type'].'" class="form-control '.$add_class.'" style="'.$row['style'].$add_style.'" '.$add_function.' id="detail_form_'.$row['field'].'" placeholder="'.$row['label'].'" value="'.$row['default'].'" '.$add_status.'>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
    function makeTextareaBox($row)
    {
        $html = "";
        $add_class = "";
        if($row['required'] == true)
        {
            $add_class .= " required ";
        }
        $add_status = "";
        if($row['readonly'] == true)
        {
            $add_status .= " readonly ";
        }
        if($row['disabled'] == true)
        {
            $add_status .= " disabled ";
        }
        $add_style = "";
        if($row['align'] == 'left')
        {
            $add_style .= "text-align:left;";
        }
        else if($row['align'] == 'right')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'center')
        {
            $add_style .= "text-align:center;";
        }
        else if($row['align'] == 'int')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'float')
        {
            $add_style .= "text-align:right;";
        }
        $html .= '<div class="col-md-'.$row['md-col'].'" style="height:40px;">';
        $html .= '    <div class="form-group">';
        $html .= '        <label for="detail_form_'.$row['field'].'" class="col-sm-'.(12-$row['sm-col']).' control-label" id="label_'.$row['field'].'">'.$row['label'].'</label>';
        $html .= '        <div class="col-sm-'.$row['sm-col'].'">';
        $html .= '            <textarea class="form-control '.$add_class.'" style="'.$row['style'].$add_style.'" id="detail_form_'.$row['field'].'" placeholder="'.$row['label'].'" value="'.$row['default'].'" '.$add_status.'></textarea>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
    //현재 적용중
    function makeNote($row)
    {
        $html = "";
        $add_class = "";
        if($row['required'] == true)
        {
            $add_class .= " required ";
        }
        $add_status = "";
        if($row['readonly'] == true)
        {
            $add_status .= " readonly ";
        }
        if($row['disabled'] == true)
        {
            $add_status .= " disabled ";
        }
        $add_style = "";
        if($row['align'] == 'left')
        {
            $add_style .= "text-align:left;";
        }
        else if($row['align'] == 'right')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'center')
        {
            $add_style .= "text-align:center;";
        }
        else if($row['align'] == 'int')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'float')
        {
            $add_style .= "text-align:right;";
        }
//        <div class="col-12">
//            <div class="form-group">
//                <label for="detail_form_remark" class="col-sm-1 control-label" id="label_remark">비고</label>
//                <div class="col-sm-11" >
//                    <div class="note scroll-pane has-scrollbar form-control" spellcheck="false" style="height: 250px;">
//                        <div class="scroll-content note-air-editor note-editable " tabindex="0" style="right: -17px;" id="note-editor-1" contenteditable="true">
//                        </div>
//                        <div class="scroll-track" style="display: block;">
//                            <div class="scroll-thumb" style="height: 334px; transform: translate(0px, 0px);"></div>
//                        </div>
//                    </div>
//                </div>
//            </div>
//        </div>
        $html .= '<div class="col-md-'.$row['md-col'].'" style="height:40px;">';
        $html .= '    <div class="form-group">';
        $html .= '        <label for="detail_form_'.$row['field'].'" class="col-sm-'.(12-$row['sm-col']).' control-label" id="label_'.$row['field'].'">'.$row['label'].'</label>';
        $html .= '        <div class="col-sm-'.$row['sm-col'].'">';
        $html .= '            <textarea class="form-control '.$add_class.'" style="'.$row['style'].$add_style.'" id="detail_form_'.$row['field'].'" placeholder="'.$row['label'].'" value="'.$row['default'].'" '.$add_status.'></textarea>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
    function makeDatepicker($row)
    {
        $html = "";
        $add_class = "";
        if($row['required'] == true)
        {
            $add_class .= " required ";
        }
        $add_status = "";
        if($row['readonly'] == true)
        {
            $add_status .= " readonly ";
        }
        if($row['disabled'] == true)
        {
            $add_status .= " disabled ";
        }
        $add_style = "";
        if($row['align'] == 'left')
        {
            $add_style .= "text-align:left;";
        }
        else if($row['align'] == 'right')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'center')
        {
            $add_style .= "text-align:center;";
        }
        else if($row['align'] == 'int')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'float')
        {
            $add_style .= "text-align:right;";
        }
        $html .= '<div class="col-md-'.$row['md-col'].'" style="height:40px;">';
        $html .= '    <div class="form-group">';
        $html .= '        <label for="detail_form_remark1" class="col-sm-'.(12-$row['sm-col']).' control-label" id="label_'.$row['field'].'">'.$row['label'].'</label>';
        $html .= '        <div class="col-sm-'.$row['sm-col'].'">';
        $html .= '           <div class="input-group date">';
        $html .= '                <input type="text" class="form-control '.$add_class.' facnroll-datepicker" style="'.$row['style'].$add_style.'" placeholder="'.$row['label'].'" id="detail_form_'.$row['field'].'" value="'.$row['default'].'" '.$add_status.'>';
        $html .= '                <span class="input-group-addon" onclick="$(\'#detail_form_'.$row['field'].'\').focus();">';
        $html .= '                    <i class="fa fa-calendar"></i>';
        $html .= '                </span>';
        $html .= '            </div>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
    function makeSelectBox($row)
    {
        $html = "";
        $add_class = "";
        if($row['required'] == true)
        {
            $add_class .= " required ";
        }
        $add_status = "";
        if($row['readonly'] == true)
        {
            $add_status .= " readonly ";
        }
        if($row['disabled'] == true)
        {
            $add_status .= " disabled ";
        }
        $add_style = "";
        if($row['align'] == 'left')
        {
            $add_style .= "text-align:left;";
        }
        else if($row['align'] == 'right')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'center')
        {
            $add_style .= "text-align:center;";
        }
        else if($row['align'] == 'int')
        {
            $add_style .= "text-align:right;";
        }
        else if($row['align'] == 'float')
        {
            $add_style .= "text-align:right;";
        }
        $html .= '<div class="col-md-'.$row['md-col'].'" style="height:40px;">';
        $html .= '    <div class="form-group">';
        $html .= '        <label for="detail_form_'.$row['field'].'" class="col-sm-'.(12-$row['sm-col']).' control-label" id="label_'.$row['field'].'">'.$row['label'].'</label>';
        $html .= '        <div class="col-sm-'.$row['sm-col'].'">';
        $html .= '            <select class="form-control '.$add_class.'" style="'.$row['style'].$add_style.'" id="detail_form_'.$row['field'].'" '.$add_status.'>';
        for($i=0;$i<count($row['data']);$i++)
        {
            $html .= '<option value="'.$row['data'][$i]['id'].'" '.($row['data'][$i]['selected']==true?'selected':'').'>'.$row['data'][$i]['text'].'</option>';
        }
        $html .= '            </select>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
    //엑셀 다운로드 체크 후 사용가능 현재 미체크
    function downloadExcel($model, $where, $file_name)
    {
        $db_help = new DB_helper();
        $result = $db_help->Select2("select * from ".$model->db_name.".".$model->table_name." ".$where.' order by 1 asc');
        $excel_data = array();
        $excel_data[0] = array();
        $excel_data[1] = array();
        foreach($model->columns as $key=>$row)
        {
            if($row['excel'] == true) {
                array_push($excel_data[0], $key);
                array_push($excel_data[1], $row['name']);
            }
        }
        $i=2;
        foreach($result as $row)
        {
            foreach($row as $key=>$col)
            {
                for($j=0;$j<count($excel_data[0]);$j++)
                {
                    if($excel_data[0][$j] == $key)
                    {
                        $excel_data[$i][$j] = $col;
                    }
                }
            }
            $i++;
        }
        //엑셀객체선언
        $excel = new PHPExcel();
        //엑셀파일정보
        $excel->getProperties()->setCreator('')
            ->setLastModifiedBy('')
            ->setTitle($file_name.'_'.date('Y-m-d'))
            ->setSubject($file_name.'_'.date('Y-m-d'))
            ->setDescription('');
        //엑셀시츠생성
        $excel->setActiveSheetIndex(0);
        //엑셀 데이터 입력
    //        $excel->getActiveSheet()->setCellValue('A1','asdf');
        $char_s = 'A';
        $char_e = $char_s + count($excel_data[0]) - 1;
        array_splice($excel_data, 0, 1);
        $excel->getActiveSheet()->fromArray($excel_data, NULL, $char_s.'1');
        //엑셀 스타일 정의
        //폰트설정
    //        $excel->getActiveSheet()->getStyle($char_s.'1:'.$char_e.'1')->getFont()->setBold();
        //라인 및 배경설정
    //        $excel->getActiveSheet()->getStyle($char_s.'1:'.$char_e.'1')->applyFromArray(
    //            array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,
    //                                    'color'=>array('argb'=>'FFCCFFCC')
    //                    ),
    //                'borders' => array('bootom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //                                    'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
    //                    )
    //            )
    //        );
        //셀넓이조절
    //        $excel->getActiveSheet()->getColumnDimension($char_s)->setWidth(25);
        //셀정렬

        //최종생성
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Content-type: application/x-msexcel;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$file_name.'_'.date('Y-m-d').'.xls"');
        header('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    //        $writer->save($file_name.'_'.date('Y-m-d').'.xls"');
        $writer->save('php://output');
    //        $xlsData = ob_get_contents();
    //        ob_end_clean();
    //
    //        $response =  array(
    //            'op' => 'ok',
    //            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    //        );
    //
    //        returnData(json_encode($response));
    }
    //엑셀 업로드 체크 후 사용가능 현재 미체크
    function uploadExcel($col_cnt)
    {
        $col_cnt = $col_cnt - 1;
        $file = $_FILES['excelupload_0'];

        $fileName = $file['name'];
        $FilePath = "/home/wellchem/files/temp/";
        if(!@is_dir($FilePath))
        {
            @mkdir($FilePath, 0777);
            @chmod($FilePath, 0777);
        }
        $tmp_fileName = date('YmdHis');
        $milliseconds = round(microtime(true) * 1000);
        $tmp_fileName .= $milliseconds;
    //            dd($image['tmp_name'].'//////'. $FilePath . $tmp_fileName);
        $result = move_uploaded_file($file['tmp_name'], $FilePath . $tmp_fileName);
        $return_data = [];
        if(@is_file($FilePath . $tmp_fileName)) {
            $excel_filename = $FilePath . $tmp_fileName; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.

            try {
                // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
                $objReader = PHPExcel_IOFactory::createReaderForFile($excel_filename);
                // 읽기전용으로 설정
                $objReader->setReadDataOnly(false);
    //                 엑셀파일을 읽는다
                $objExcel = $objReader->load($excel_filename);

                // 첫번째 시트를 선택
                $objExcel->setActiveSheetIndex(0);
                $objWorksheet = $objExcel->getActiveSheet();
                $rowIterator = $objWorksheet->getRowIterator();
    //
                foreach ($rowIterator as $row) { // 모든 행에 대해서
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                }
    //
                $maxRow = $objWorksheet->getHighestRow();
                //바로배열로 받아오는 함수
    //            $objWorksheet->toArray();
                //엑셀의 스타일을 가져오기 위한 루프문
                for ($i = 1; $i <= $maxRow; $i++) {
                    $start_char = 'A';
                    $return_data[$i-1][0] = '';
                    for($j=1;$j <= $col_cnt;$j++) {
                        $col = ''.$start_char++;
                        $return_data[$i-1][$j]['value'] = $objWorksheet->getCell(  $col. $i)->getValue();
                        $return_data[$i-1][$j]['background'] = $objWorksheet->getCell(  $col. $i)->getStyle($col. $i)->getFill()->getStartColor()->getRGB();
                        //                            $return_data[$i][$j] = $col.$i;
                    }
                    //                        $reg_date = $objWorksheet->getCell('F' . $i)->getValue(); // F열
                    //                        $reg_date = PHPExcel_Style_NumberFormat::toFormattedString($reg_date, 'YYYY-MM-DD'); // 날짜 형태의 셀을 읽을때는 toFormattedString를 사용한다.
                }
                unlink($FilePath . $tmp_fileName);
            } catch (exception $e) {
    //                echo $e;
            }
        }
        return $return_data;
    }
    
    function Contains($string, $find)
    {
        $position = strpos($string, $find);
        if($position === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    //파일 인크루드 하기
    function get_include_constents($filename) {
        $check = file_exists($filename);
        if ($check) {
            ob_start();

            include $filename;
            $contents = ob_get_contents();
            ob_end_clean();
            echo $contents;
        }
        return false;
    }
    //현메뉴정보 가져오기
    function convertMenuInfo($model)
    {
        $return_data['title'] = $model->title;
        $return_data['db_name'] = $model->db_name;
        $return_data['table_name'] = $model->table_name;
        $return_data['list_columns'] = $model->list_columns;
        $return_data['detail'] = makeDetailHtml($model->write_form);
        $return_data['search'] = $model->search_options;
        $setup_menu_info = getMenuArray();
        $return_data['menu_path'] = $setup_menu_info[0];
        $return_data['btn_html'] = convertMenuButtonHtml($setup_menu_info[1]);
        if(count($setup_menu_info)>0) {
            $return_data['menu_path'] = $setup_menu_info[0];
            $return_data['btn_html'] = convertMenuButtonHtml($setup_menu_info[1]);
        }
        else {
            $return_data['menu_path'] = null;
            $return_data['btn_html'] = "";
        }
        return $return_data;
    }
    //저장데이터로 변환
    function makeupSaveData($model, $data)
    {
        $temp_arr = [];
        for($i=0;$i<count($model->columns);$i++)
        {
            $temp_arr[$model->columns[$i]] = $data[$model->columns[$i]];
        }
        return $temp_arr;
    }
    //셋업메뉴 정보 가져오기
    function getMenuArray()
    {
        $db_helper = new DB_helper();
        $split_arr = explode('/', $_SERVER['REQUEST_URI']);
        $result = $db_helper->Select2("select * from setup_menu where menu_url='/" .$split_arr[1]."'");
        $return_data = array();

        if(count($result)>0) {
            $result_data[0] = $result[0]['menu_name'];
            $temp_name[0] = $result_data[0];
            $result_data = getMenuRecursive($result[0]['parent_menu_code'], $result_data);
            $return_data[0] = $result_data != ''? $result_data:$temp_name;
            $return_data[1] = $result[0];
        }
        return $return_data;
    }
    function getMenuRecursive($parent_code, $result_data)
    {
        $db_helper = new DB_helper();
        $result = $db_helper->Select2("select * from setup_menu where menu_code='" .$parent_code."'");
        if(count($result) > 0)
        {
            $result_data[count($result_data)] = $result[0]['menu_name'];
            if($result[0]['parent_menu_code'] != '')
            {
                $result_data = getMenuRecursive($result[0]['parent_menu_code'], $result_data);

            }
            return $result_data;
        }
    }
    //메뉴별 버튼 html로 컨버팅하기
    function convertMenuButtonHtml($result)
    {
        $html = '';
        if($result['btn_select'] == 'true') { $html .= '<a href="javascript:getList()" id="btn_search" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">검색</a>'; }
        if($result['btn_create'] == 'true') { $html .= '<a href="javascript:newDetail();" id="btn_create" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">추가</a><a href="javascript:saveForm()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">저장</a>'; }
//        if($result['btn_update'] == 'true') { $html .= '<a href="javascript:saveForm()" id="btn_update" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">저장</a>'; }
        if($result['btn_delete'] == 'true') { $html .= '<a href="javascript:setDelete();" id="btn_delete" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">삭제</a>'; }
        if($result['btn_print'] == 'true') { $html .= '<a href="javascript:setPrint();" id="btn_print" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">인쇄</a>'; }
        if($result['btn_excelupload'] == 'true') { $html .= '<a href="javascript:setExcelUpload();" id="btn_excelupload" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">엑셀업로드</a>'; }
        if($result['btn_exceldownload'] == 'true') { $html .= '<a href="javascript:getExcelDownload();" id="btn_exceldownload" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">엑셀다운로드</a>'; }
        if($result['btn_reload'] == 'true') { $html .= '<a href="javascript:location.reload();" id="btn_reload" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">새로고침</a>'; }
        return $html;

    }
    //메뉴를 html로 가져오기
    function getMenuListHtml()
    {
        $html = "";
        $config = new init_Config();
        $db_helper = new DB_helper();
        $query = "SELECT * FROM ".$config->dbname.".setup_menu where parent_menu_code='' and use_yn='true' order by seq asc;";
        $result = $db_helper->Select2($query);
        $depth = 0;
        foreach($result as $row)
        {
            if(Contains($row['menu_code'], 'separator'))
            {
                $html .= '<li class="'.$row['menu_icon'].'">'.$row['menu_name'].'</li>';
            }
            else
            {
                $query = "select count(idx) from ".$config->dbname.".setup_menu where parent_menu_code='".$row['menu_code']."'  and use_yn='true'";
                $result_cnt = $db_helper->Select2($query);
                if($result_cnt[0][0] > 0)
                {
                    $menu_icon = "";
                    if(!empty($row['menu_icon']))
                    {
                        $menu_icon = '<i class="fa '.$row['menu_icon'].'"></i>';
                    }
                    if(empty($row['menu_url']))
                    {
                        $row['menu_url'] = "javascript:void(0);";
                    }
                    $html .= '<li class="hasChild"><a href="'.$row['menu_url'].'" id="menu_btn_'.$row['menu_code'].'">'.$menu_icon.'<span>'.$row['menu_name'].'</span></a>';
                    $html .= '<ul class="acc-menu">';
                    $html .= getMenuListHtmlRecursive($row['menu_code'], $config->dbname, ($depth+1));
                    $html .= '</ul>';
                    $html .= '</li>';
                }
                else
                {
                    $menu_icon = "";
                    if(!empty($row['menu_icon']))
                    {
                        $menu_icon = '<i class="fa '.$row['menu_icon'].'"></i>';
                    }
                    if(empty($row['menu_url']))
                    {
                        $row['menu_url'] = "javascript:void(0);";
                    }
                    $html .= '<li><a href="'.$row['menu_url'].'" id="menu_btn_'.$row['menu_code'].'">'.$menu_icon.'<span>'.$row['menu_name'].'</span></a></li>';
                }
            }
        }
        return $html;
    }
    function getMenuListHtmlRecursive($parent_menu_code, $db_name, $depth)
    {
        $html = '';
        $db_helper = new DB_helper();
        $query = "SELECT * FROM ".$db_name.".setup_menu where parent_menu_code='".$parent_menu_code."' and use_yn='true' order by seq asc;";
        $result = $db_helper->Select2($query);
        foreach($result as $row)
        {
            if(Contains($row['menu_code'], 'separator'))
            {
                $html .= '<li class="'.$row['menu_icon'].'">'.$row['menu_name'].'</li>';
            }
            else
            {
                $query = "select count(idx) from ".$db_name.".setup_menu where parent_menu_code='".$row['menu_code']."' and use_yn='true'";
                $result_cnt = $db_helper->Select2($query);
                if($result_cnt[0][0] > 0)
                {
                    $menu_icon = "";
                    if(!empty($row['menu_icon']))
                    {
                        $menu_icon = '<i class="fa '.$row['menu_icon'].'"></i>';
                    }
                    if(empty($row['menu_url']))
                    {
                        $row['menu_url'] = "javascript:void(0);";
                    }
                    $html .= '<li class="hasChild"><a href="'.$row['menu_url'].'" id="menu_btn_'.$row['menu_code'].'">'.$menu_icon.'<span>'.$row['menu_name'].'</span></a>';
                    $html .= '<ul class="acc-menu">';
                    $html .= getMenuListHtmlRecursive($row['menu_code'], $db_name, ($depth+1));
                    $html .= '</ul>';
                    $html .= '</li>';
                }
                else
                {
                    $menu_icon = "";
                    if(!empty($row['menu_icon']))
                    {
                        $menu_icon = '<i class="fa '.$row['menu_icon'].'"></i>';
                    }
                    if(empty($row['menu_url']))
                    {
                        $row['menu_url'] = "javascript:void(0);";
                    }
                    $html .= '<li><a href="'.$row['menu_url'].'" id="menu_btn_'.$row['menu_code'].'">'.$menu_icon.''.$row['menu_name'].'</a></li>';
                }
            }
        }
        return $html;
    }

    /**
     * Return bool
     * @param object $model <p>
     * 중복체크 할 모델 클래스
     * </p>
     * @param string $column <p>
     * 중복 체크할 칼럼명
     * </p>
     * @param string $value <p>
     * 중복 체크할 데이터
     * </p>
     * @return bool 중복이 되었으면 true/ 중복이 안되었으면 false.
     */
    function checkDuplicate($model, $column, $value)
    {
        $db_helper = new DB_helper();
        $config = new init_Config();
        $query = "select * from ".$config->dbname.".".$model->table_name." where ".$column."='".$value."'";
        $result = $db_helper->Select2($query);
        if(count($result)>0){
            return true;
        }
        return false;
    }
    function makeItemList($model, $id_column, $text_column, $use_yn=false)
    {
        $db_helper = new DB_helper();
        $config = new init_Config();
        $query = "select ".$id_column." as id, ".$text_column." as text from ".$config->dbname.".".$model->table_name." ";
        if($use_yn == true)
        {
            $query .= " where use_yn='Y' order by idx asc";
        }
        $result = $db_helper->Select2_assoc($query);
        return $result;

    }
    function getUserInfo()
    {
        $config = new init_Config();
        $db_helper = new DB_helper();
        $user_id = getAuth('login_id');
        if(empty($user_id))
        {
            $query = "select * from ".$config->dbname.".setup_theme where user_id='admin'";
            $result = $db_helper->Select2($query);
            return $result;
        }
        else
        {
            $query = "select * from ".$config->dbname.".setup_theme where user_id='".$user_id."'";
            $result = $db_helper->Select2($query);
            if(count($result) > 0)
            {
                return $result;
            }
            else
            {
                $query = "select * from ".$config->dbname.".setup_theme where user_id='admin'";
                $result = $db_helper->Select2($query);
                return $result;
            }
        }

    }


