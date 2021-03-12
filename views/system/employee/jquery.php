<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();

    });
    function Init()
    {
        getUserTheme();
        getMenuInfo();
        setMenu();
        setDetail();
        setMainGrid();
        setDatepicker();
        eventDetail();
        getSelect();
        resetDetail('detail_form');
    }
    var menu_info;
    var main_grid;
    var main_grid_width = 0;
    var delete_list=[];

    function getMenuInfo()
    {
        menu_info = getAjax('/employee/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    function setDetail()
    {
        $('#write_form').html(menu_info.detail);
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
        $('#list_title').text(menu_info.title + " 리스트");
        $('#detail_form_title').text(menu_info.title + " 상세정보");
        $('#search_form').html(menu_info.search_html);
    }
    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid.setColumns(menu_info.list_columns);
        main_grid.eventGrid('click', clicklistfunction);
    }
    var clicklistfunction = function(event){
        var select_idx = main_grid.getSelection();
        if(event.recid == select_idx[select_idx.length -1]) {
            var detail_data = main_grid.getRowData(event.recid);
            showDetail(detail_data.idx);
        }
        else
        {
            newDetail();
            closeDetail();
        }
    }
    function getSelect() {
        var spot = getCodeList("employee_spot","html");
        var department = getCodeList("employee_department","html");
        var position = getCodeList("employee_position","html_default");
        var type = getCodeList("employee_type","html");

        var department1 = getCodeList("employee_department","html_default");
        var type1 = getCodeList("employee_type","html_default");

        $('#detail_form_spot').html(spot);
        $('#detail_form_department').html(department);
        $('#detail_form_position').html(position);
        $('#detail_form_type').html(type);

        $('#search_department').html(department1);
        $('#search_type').html(type1);
    }
//까지 기본설정
    function getList()
    {
        closeDetail();
        var search = getSearch('search_form');
        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        console.log(search);
        var result = getAjax('/employee/getList', 'post', {search:search}).responseText;
        result = JSON.parse(result);
        if(result.result == true) {
            main_grid.setAllData(result.data);
            main_grid.lock(false);
        }
        else
        {
            main_grid.clear();
            main_grid.lock(false);
        }
    }
    function showDetail(idx)
    {

        newDetail();
        main_grid.setSelectIdx(idx);
        var result = getAjax('/employee/showDetail', 'post', {idx : idx}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {

            $('#detail_form_number').addClass('readonly');
            $('#detail_form_number').removeClass('required');
            $('#detail_form_number').attr('readonly', true);
            $('#detail_form_number').removeClass('duplicate');
            $('#detail_form_number').removeClass('required');
            $('#detail_form_resignation_dt').attr('readonly', true);
            $.each(result.data, function(key, value){
                // console.log(key+","+ value)
                    $('#detail_form_' + key).val(value);

            });
            if($('#detail_form_type option:selected').val() == '퇴사')
            {
                $('#detail_form_resignation_dt').prop('readonly', false);
            }
            else
            {
                $('#detail_form_resignation_dt').prop('readonly', true);
            }

        }
        else
        {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }

    }

    function saveForm()
    {
        var check_duplicate = numberDuplicate('/employee/duplicate', 'detail_form');
        if(check_duplicate) {
            var result = checkRequired('detail_form');

            var number = $('#detail_form_number').val();
            var name = $('#detail_form_name').val();

            if (result) {
                var ids = $('#detail_form [id^=detail_form_]');
                if ($('#detail_form_idx').val() == '') {

                    var result = setPostAjax('/employee/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {

                        var result2 = getAjax('/employee/saveMember', 'post', {number:number, name:name}).responseText;
                        // result2 = JSON.parse(result2);
                        alert('저장 되었습니다.');
                        getList();
                        newDetail();
                        main_grid.setSelectIdx(result.idx);
                        showDetail(result.idx);
                    }
                    else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                }
                else {
                    var result = setPostAjax('/employee/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        var result2 = getAjax('/employee/saveMember', 'post', {number:number, name:name}).responseText;
                        // result2 = JSON.parse(result2);
                        alert('수정 되었습니다.');
                        getList();
                        newDetail();
                        main_grid.setSelectIdx(result.idx);
                        showDetail(result.idx);
                    }
                    else {
                        alert('수정에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                }
            }
        }

    }

    function newDetail()
    {
        main_grid.setSelectIdx(0);
        resetDetail('detail_form');
        openDetail();

    }
    function openDetail()
    {
        $('#detail_form').addClass("active");
        $('#detail_arrow_icon i').removeClass("fa-arrow-left");
        $('#detail_arrow_icon i').addClass("fa-arrow-right");
        $('#detail_form_entered_dt').val(getNowDateTime(true));



        $("#detail_form_type").on("change", function (){
            if($("#detail_form_type").val() == "퇴사")
            {
                $('#detail_form_resignation_dt').removeClass('readonly');
                $('#detail_form_resignation_dt').attr('readonly', false);
                $('#detail_form_resignation_dt').addClass('required');
                // $('#detail_form_resignation_dt').focus();
                $('#detail_form_resignation_dt').val(getNowDateTime(true));
            }
            else{
                $('#detail_form_resignation_dt').val('');
                $('#detail_form_resignation_dt').addClass('readonly');
                $('#detail_form_resignation_dt').attr('readonly', true);
                $('#detail_form_resignation_dt').removeClass('required');
            }
        });


    }
    function closeDetail()
    {
        $('#detail_form').removeClass("active");
        $('#detail_arrow_icon i').removeClass("fa-arrow-right");
        $('#detail_arrow_icon i').addClass("fa-arrow-left");
    }
    function resetDetail(form_id)
    {
        var ids = $('#' + form_id + ' textarea[id^=' + form_id + '_],select[id^=' + form_id + '_],input[id^=' + form_id + '_]');
        for(var i=0;i<ids.length;i++)
        {
            if(ids[i].id == "detail_form_spot")
            {
                $('#' + ids[i].id).val('사원');
            }
            else if(ids[i].id == "detail_form_department")
            {
                $('#' + ids[i].id).val('폴');
            }
            else if(ids[i].id == "detail_form_type")
            {
                $('#' + ids[i].id).val('근무');
            }
            else {
                $('#' + ids[i].id).val('');
            }
        }
        $('#detail_form_number').removeClass('readonly');
        $('#detail_form_number').addClass('required');
        $('#detail_form_number').addClass('duplicate');
        $('#detail_form_number').attr('readonly', false);
        $('#detail_form_resignation_dt').attr('readonly', true);

    }
    function setDelete()
    {
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
    function numberDuplicate(url, main_form_id){
        var ids = $('#' + main_form_id + ' .duplicate');
        var return_data=true;
        for(var i=0;i<ids.length;i++)
        {
            var id = ids[i].id;
            var column_name = id.replace('detail_form_','');
            var label_id = id.replace('detail_form_','label_');
            var send_data = '{"' + column_name + '":"' + $('#' + id).val() + '"}';
            send_data = JSON.parse(send_data);
            var data = getAjax(url, 'post', send_data).responseText;
            data = JSON.parse(data);
            if (data.result == true) {
                alert($('#' + label_id).text() + '가 중복되었습니다.');
                $('#' + id).focus();
                return_data = false;
                break;
            }
        }
        return return_data;
    }
</script>