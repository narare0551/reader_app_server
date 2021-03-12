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
    }
    var menu_info;
    var main_grid;
    var main_grid_width = 0;
    var delete_list=[];

    function getMenuInfo()
    {
        menu_info = getAjax('/member/getMenuInfo', 'post', {}).responseText;
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
//까지 기본설정
    function getList()
    {
        closeDetail();
        var search = getSearch('search_form');
        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/member/getList', 'post', {search:search}).responseText;
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
        var result = getAjax('/member/showDetail', 'post', {idx : idx}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {
            newDetail();
            $('#detail_form_user_id').addClass('readonly');
            $('#detail_form_user_id').removeClass('required');
            $('#detail_form_user_id').attr('readonly', true);
            $('#detail_form_user_id').removeClass('duplicate');
            $('#detail_form_user_pw').removeClass('required');
            $.each(result.data, function(key, value){
                if(key != 'user_pw') {
                    $('#detail_form_' + key).val(value);
                }
            })
        }
        else
        {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }
    }

    function saveForm()
    {
        var check_duplicate = checkDuplicate('/member/duplicate', 'detail_form');
        if(check_duplicate) {
            var result = checkRequired('detail_form');
            if (result) {
                var ids = $('#detail_form [id^=detail_form_]');
                if ($('#detail_form_idx').val() == '') {

                    var result = setPostAjax('/member/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
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
                    var result = setPostAjax('/member/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
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
        resetDetail('detail_form');
        openDetail();
    }
    function openDetail()
    {
        $('#detail_form').addClass("active");
        $('#detail_arrow_icon i').removeClass("fa-arrow-left");
        $('#detail_arrow_icon i').addClass("fa-arrow-right");
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
            $('#' + ids[i].id).val('');
        }
        $('#detail_form_user_id').removeClass('readonly');
        $('#detail_form_user_id').addClass('required');
        $('#detail_form_user_id').addClass('duplicate');
        $('#detail_form_user_id').attr('readonly', false);
        $('#detail_form_user_pw').addClass('required');
        $('#detail_form_status').val('Y');
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
</script>
