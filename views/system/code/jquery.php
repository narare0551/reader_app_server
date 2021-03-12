<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();

        //그리드 헤더 클릭시 포커스 이동
        $('#main_heading').on("click", function(){
           focus_location = "main";
           focusChk();
        });
        $('#detail_heading').on("click", function(){
            focus_location = "detail";
            focusChk();
        });
        //그리드 클릭시 포커스 이동
        $('#grid1').on("click", function(){
            focus_location = "main";
            focusChk();
        });
        $('#grid2').on("click", function(){
            focus_location = "detail";
            focusChk();
        });
    });
    function Init()
    {
        getUserTheme();
        getMenuInfo();
        getSlaveColumns();
        setMenu();
        setMainGrid();
        setMainGrid2();
        // setDatepicker();
    }
    var menu_info;
    var slave_columns;
    var main_grid1, main_grid2;
    var main_grid_width = 0;
    var delete_list1=[];
    var delete_list2=[];

    function getMenuInfo()
    {
        menu_info = getAjax('/code/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    function getSlaveColumns()
    {
        slave_columns = getAjax('/code/getSlaveColumns', 'post', {}).responseText;
        slave_columns = JSON.parse(slave_columns);
    }
    function setMenu()
    {
        $('#menu_title').text(menu_info.title);
        var sm_title_html = "<li class=\"\"><a href=\"\">Home</a></li>";
        for(var i=menu_info.menu_path.length-1;i>=1;i--)
        {
            sm_title_html += '<li class=""><a href="">'+menu_info.menu_path[i]+'</a></li>';
        }
        sm_title_html += '<li class="active"><a href="">'+menu_info.menu_path[0]+'</a></li>';
        $('#menu_sm_title').html(sm_title_html);
        $('#btn_collection').html(menu_info.btn_html);
        $('#list_title').text("대분류 리스트");
        $('#detail_title').text("소분류 리스트");
        $('#search_form').html(menu_info.search_html);
    }
    function setMainGrid()
    {
        main_grid1 = new FNRGrid();
        main_grid1.setGrid('grid1', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid1.setColumns(menu_info.list_columns);
        main_grid1.eventGrid('editField', changefunction);
        main_grid1.eventGrid('click', on_click);
    }
    function setMainGrid2()
    {
        main_grid2 = new FNRGrid();
        main_grid2.setGrid('grid2', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid2.setColumns(slave_columns.list_columns);
        main_grid2.eventGrid('editField', changefunction);
        main_grid2.eventGrid('click', on_clickDetail);
    }

    var edit_recid = 0;
    var changefunction = function(event)
    {
        if(focus_location == "main")
        {
            edit_recid = event.recid;
            if(event.column == 1) {
                var check_idx = main_grid1.getRowData(edit_recid);
                if(check_idx.idx == '') {
                    // $('input#grid_grid1_edit_' + event.recid + '_1').attr('readonly', false);
                    $('input#grid_grid1_edit_' + event.recid + '_1').on('blur', function () {
                        var change_data = main_grid1.getRowData(edit_recid);
                        change_data.mod_dttm = getNowDateTime(true, true);
                        main_grid1.setRowData(edit_recid, change_data);
                        // setTimeout(function () {
                        //     main_grid1.save();
                        // }, 100);
                    });
                }
                else
                {
                    main_grid1.save();
                    // $('input#grid_grid1_edit_' + event.recid + '_1').attr('readonly', true);
                }
            }
        }
        else {
            edit_recid = event.recid;
            if(event.column == 2) {
                var check_idx = main_grid2.getRowData(edit_recid);
                if(check_idx.idx == '') {
                    // $('input#grid_grid1_edit_' + event.recid + '_1').attr('readonly', false);
                    $('input#grid_grid2_edit_' + event.recid + '_2').on('blur', function () {
                        var change_data = main_grid2.getRowData(edit_recid);
                        change_data.mod_dttm = getNowDateTime(true, true);
                        main_grid2.setRowData(edit_recid, change_data);
                        // setTimeout(function () {
                        //     main_grid1.save();
                        // }, 100);
                    });
                }
                else
                {
                    main_grid2.save();
                    // $('input#grid_grid1_edit_' + event.recid + '_1').attr('readonly', true);
                }
            }
        }
    }
    //row 클릭시 포커스 이동
    var focus_location = 'main';
    var on_click = function(event){
        var list = main_grid1.getSelection();
        if(list.length > 0) {
            var data = main_grid1.getRowData(list[0]);
            focus_location = "main";
            focusChk();
            if(!IsNullorEmpty(data.idx)) {
                showDetail(data.master_code);
            }
        }
    }
    var on_clickDetail = function(event){
        focus_location = 'detail';
        var list = main_grid2.getSelection();
        if(list.length > 0) {
            var data = main_grid2.getRowData(list[0]);
            focusChk();
        }
    }

    function addRow()
    {
        if(focus_location == "main")
        {
            var data = {
                master_code: "",
                master_name: "",
                use_yn: true,
                mod_dttm: "",
                mod_user_id: "",
                reg_dttm: getNowDateTime(true,true),
                reg_user_id: "",
                recid:'',
                idx:''
            };
            main_grid1.addRow(data);
        }
        else
        {
            var data = {
                master_code: "",
                slave_code: "",
                slave_name: "",
                use_yn: true,
                mod_dttm: "",
                mod_user_id: "",
                reg_dttm: getNowDateTime(true,true),
                reg_user_id: "",
                recid:'',
                idx:''
            };
            if(IsNullorEmpty(main_grid1.getSelection()))
            {
                alert('대분류를 선택해주세요.');
                focus_location = 'main';
                focusChk();
            }
            else{
                main_grid2.addRow(data);
            }
        }
    }
    function removeRow()
    {
        if(focus_location == "main")
        {
            var recid = main_grid1.getSelection();
            var data = main_grid1.getRowData(recid);
            var result = confirm("삭제하면 복구할 수 없습니다. 삭제하시겠습니까?");
            if(result)
            {
                for(var i=0; i<data.length; i++)
                {
                    if(data[i].idx == "")
                    {
                        main_grid1.removeRow(data[i].recid);
                    }
                    else
                    {
                        data[i].use_yn = false;
                        main_grid1.setRowData(data[i].recid, data[i]);
                    }
                }
            }
            else{}
        }
        else
        {
            var recid = main_grid2.getSelection();
            var data = main_grid2.getRowData(recid);
            var result = confirm("삭제하면 복구할 수 없습니다. 삭제하시겠습니까?");
            if(result)
            {
                for(var i=0; i<data.length; i++)
                {
                    if(data[i].idx == "")
                    {
                        main_grid2.removeRow(data[i].recid);
                    }
                    else
                    {
                        data[i].use_yn = false;
                        main_grid2.setRowData(data[i].recid, data[i]);
                    }
                }
            }
            else{}
        }
    }
    //포커스 위치 체크 후 그리드 배경색 변경
    function focusChk()
    {
        if(focus_location == "detail")
        {
            $("#main_heading").css('backgroundColor', '#aaaaaa');
            $("#detail_heading").css('backgroundColor', '#37474f');
        }
        else{
            $("#main_heading").css('backgroundColor', '#37474f');
            $("#detail_heading").css('backgroundColor', '#aaaaaa');
        }
    }

    //대분류코드 중복값 체크
    function chkMasterCode()
    {
        var default_list = main_grid1.getRowData();
        var default_list1 = main_grid1.getRowData();
        var return_data = true;
        for(var i=0;i<default_list.length;i++)
        {
            for(var j=0;j<default_list1.length;j++)
            {
                if(i != j)
                {
                    if(default_list[i].master_code == default_list1[j].master_code)
                    {
                        var date1 = new Date(default_list[i].mod_dttm);
                        var date2 = new Date(default_list1[j].mod_dttm);
                        if(date1.getTime() > date2.getTime())
                        {
                            edit_recid = i+1;
                        }
                        else
                        {
                            edit_recid = j+1;
                        }
                        return_data = false;
                        break;
                    }
                    else if(IsNullorEmpty(default_list[i].master_code) || IsNullorEmpty(default_list[i].master_code))
                    {
                        return_data = false;
                    }
                }
            }
        }
        if(!return_data)
        {
            setTimeout(function () {
                main_grid1.editFocus(edit_recid, 1);
            }, 100);
            return false;
        }
        else
        {
            return true;
        }
    }

    //소분류코드 중복값 체크
    function chkSlaveCode()
    {
        var default_list = main_grid2.getRowData();
        var default_list1 = main_grid2.getRowData();
        var return_data = true;
        for(var i=0;i<default_list.length;i++)
        {
            for(var j=0;j<default_list1.length;j++)
            {
                if(i != j)
                {
                    if(default_list[i].slave_code == default_list1[j].slave_code)
                    {
                        var date1 = new Date(default_list[i].mod_dttm);
                        var date2 = new Date(default_list1[j].mod_dttm);
                        if( date1.getTime() >  date2.getTime() )
                        {
                            edit_recid = i+1;
                        }
                        else
                        {
                            edit_recid = j+1;
                        }
                        return_data = false;
                        break;
                    }
                    else if(IsNullorEmpty(default_list[i].slave_code) || IsNullorEmpty(default_list[i].slave_code))
                    {
                        return_data = false;
                    }
                }
            }
        }
        if(!return_data)
        {
            setTimeout(function () {
                main_grid2.editFocus(edit_recid, 2);
            }, 100);
            return false;
        }
        else
        {
            return true;
        }
    }

    //필수 함수
    function getList()
    {
        resetDetail();
        var search = getSearch();
        var result = getAjax('/code/getList', 'post', {search:search}).responseText;
        result = JSON.parse(result);
        if(result.result) {
            main_grid1.setAllData(result.data);
            if(!IsNullorEmpty(search))
            {
                focus_location = 'main';
                focusChk();
            }
        }
        else
        {
            main_grid1.setAllData(result.data);
        }
    }

    function showDetail(master_code)
    {
        var result = getAjax('/code/showDetail', 'post', {master_code:master_code}).responseText;
        result = JSON.parse(result);
        if(result.result) {
            main_grid2.setAllData(result.data);
        }
        else
        {
            main_grid2.setAllData(result.data);
        }
    }

    function saveForm()
    {
        if(focus_location == "main")
        {
            main_grid1.save();

            for(var i = 1; i<=main_grid1.getRowData().length; i++)
            {
                var master_code = main_grid1.getRowData(i).master_code;
                var master_name = main_grid1.getRowData(i).master_name;
                if(master_code == "")
                {
                    alert("대분류코드은(는) 필수 값 입니다.");
                    return false;
                }
                else if(master_name == "")
                {
                    alert("대분류명은(는) 필수 값 입니다.");
                    return false;
                }
            }
            if(chkMasterCode() == false)
            {
                chkMasterCode();
                alert("대분류코드이(가) 중복되었습니다.");
                return false;
            }
            else{
                var result = getAjax('/code/save', 'post', {data : main_grid1.getRowData()}).responseText;
                result = JSON.parse(result);
                if(result.result == true)
                {
                    alert('저장 되었습니다.');
                    delete_list1=[];
                    getList();
                }
                else
                {
                    alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                }
            }
        }
        else
        {
            var list = main_grid1.getSelection();
            var master_code;
            if(list.length > 0) {
                var data = main_grid1.getRowData(list[0]);
                master_code = data.master_code;
            }
            main_grid2.save();
            for(var i = 1; i<=main_grid2.getRowData().length; i++)
            {
                var slave_code = main_grid2.getRowData(i).slave_code;
                var slave_name = main_grid2.getRowData(i).slave_name;
                if(slave_code == "")
                {
                    alert("소분류코드은(는) 필수 값 입니다.");
                    return false;
                }
                else if(slave_name == "")
                {
                    alert("소분류명은(는) 필수 값 입니다.");
                    return false;
                }
            }
            if(chkSlaveCode() == false)
            {
                chkSlaveCode();
                alert("소분류코드이(가) 중복되었습니다.");
                return false;
            }
            var result = getAjax('/code/save_detail', 'post', {data : main_grid2.getRowData(), master_code:master_code}).responseText;
            result = JSON.parse(result);
            if(result.result == true)
            {
                alert('저장 되었습니다.');
                delete_list2=[];
                showDetail(master_code);
            }
            else
            {
                alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
            }
        }
    }
    function newDetail()
    {
        addRow();
    }
    function resetDetail()
    {
        main_grid2.clearData();
    }
    function setDelete()
    {
        removeRow();
    }
    function setPrint()
    {
    }
    function setExcelUpload()
    {
    }
    function getExcelDownload()
    {
    }

</script>