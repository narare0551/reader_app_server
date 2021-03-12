<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();
    });
    var menu_info;
    var main_grid;
    var rack_grid;

    function Init()
    {
        getUserTheme();
        getMenuInfo();
        setMenu();
        setMainGrid();
        setRackGrid();
        getCode();
        eventDetail();
        setDetail();
        $('#btn_create').hide();
    }
    function getCode()
    {
        $('#search_item_division').html(getCodeList('item_division','html_default'));
    }

    function getMenuInfo()
    {
        menu_info = getAjax('/inventory/getMenuInfo','post',{}).responseText;
        menu_info = JSON.parse(menu_info);
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
        $('#detail_form_title').text(menu_info.title + " 상세정보 / 히스토리");
        $('#search_form').html(menu_info.search_html);
    }
    function setDetail()
    {
        $('#write_form').html(menu_info.detail);
    }
    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid.setColumns(menu_info.list_columns);
        main_grid.eventGrid('click', mainlist_click);
    }

    function setRackGrid()
    {
        console.log(menu_info.rack_columns);
        rack_grid = new FNRGrid();
        rack_grid.setGrid('rack_grid', 24, '', false,false,true,true,true,false,true);
        var rack_grid_width = rack_grid.setColumns(menu_info.rack_columns);
        rack_grid.eventGrid('change', rack_change);
    }
    var rack_change = function(event){
        console.log(event);
    }
    function addRow()
    {
        rack_grid.addRow();
    }
    var delete_list = [];
    function deleteRow()
    {
        var delete_data = rack_grid.removeRow();
        for(var i=0;i<delete_data.length;i++)
        {
            if(!IsNullorEmpty(delete_data[i].idx))
            {
                delete_list.push(delete_data[i]);
            }
        }
        rack_grid.setUnSelection();
    }
    var mainlist_click = function(event){
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

    function getList()
    {
        main_grid.lock(true, 'Loading...');

        var search = getSearch();
        var result = getAjax('/inventory/getList', 'post', {search:search}).responseText;
        result = JSON.parse(result);
        // if(result != '[]') {
        if(result.result == true){
            main_grid.setAllData(result.data);
            main_grid.lock(false);
        }
        else
        {
            alert("데이터를 가져올 수 없습니다.\n관리자에게 문의바랍니다.");
            main_grid.lock(false);
        }
    }

    function showDetail(idx)
    {

        var result = getAjax('/inventory/showDetail', 'post', {idx : idx}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {
            newDetail();

            $.each(result.data, function(key, value){
                if(key != 'user_pw') {
                    if(key=='stock' || key=='safety_stock' || key=='change_stock'){
                        $('#detail_form_' + key).val(commapoint_format(value,0,'int'));
                    }
                    else{
                        $('#detail_form_' + key).val(value);
                    }
                }
            });
            // 히스토리 리스트
            var result = getAjax('/inventory/getList','post',{item_code: $('#detail_form_item_code').val()}).responseText;
            result = JSON.parse(result);
            // if(result != '[]') {
            if(result.result == true){
                history_grid.setAllData(result.data);
                history_grid.lock(false);
            }
            else
            {
                alert("데이터를 가져올 수 없습니다.\n관리자에게 문의바랍니다.");
                history_grid.lock(false);
            }

            // 창고 리스트
            var result = getAjax('/inventory/getRackList', 'post',{item_code:$('#detail_form_item_code').val()}).responseText;
            result = JSON.parse(result);
            if(result.result) {
                rack_grid.setAllData(result.data);
                rack_grid.lock(false);
                setRackStock();
            }
            else
            {
                alert("데이터를 가져올 수 없습니다.\n관리자에게 문의바랍니다.");
                rack_grid.lock(false);
            }

        }
        else
        {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }
    }

    function resetDetail(form_id)
    {
        var ids = $('#' + form_id + ' textarea[id^=' + form_id + '_],select[id^=' + form_id + '_],input[id^=' + form_id + '_]');
        for(var i=0;i<ids.length;i++)
        {
            $('#' + ids[i].id).val('');
        }
        // history_grid.clearData();
    }

    function saveForm()
    {
        $('#detail_form_stock').val(commapoint_format($('#detail_form_stock').val(),1,'int'));
        $('#detail_form_safety_stock').val(commapoint_format($('#detail_form_safety_stock').val(),1,'int'));
        $('#detail_form_change_stock').val(commapoint_format($('#detail_form_change_stock').val(),1,'int'));
        $('#rack_total').val(commapoint_format($('#rack_total').val(),1,'int'));
        var stock = parseInt($('#detail_form_stock').val());
        var change_stock = parseInt($('#detail_form_change_stock').val());
        var rack_total = parseInt($('#rack_total').val());
        console.log(change_stock+rack_total);
        if(change_stock+stock<rack_total){
            alert("현재고는 창고재고보다 많아야합니다. \n창고재고를 변경 후 현재고를 변경해주세요.");
            return;
        }
                var ids = $('#detail_form [id^=detail_form_]');
                    var result = setPostAjax('/inventory/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        if(result.change != false) {
                            var result = setPostAjax('/inventory/create', ids).responseText;
                            result = JSON.parse(result);
                            if (result.result == true) {
                                getList();
                                newDetail();
                                main_grid.setSelectIdx(result.idx);
                                showDetail(result.idx);
                            } else {
                                alert('히스토리 저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                            }
                        }
                        alert('저장 되었습니다.');
                        getList();
                        newDetail();
                        main_grid.setSelectIdx(result.idx);
                        showDetail(result.idx);
                    } else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
    }

    function newDetail()
    {
        resetDetail('detail_form');
        $('#detail_form_safety_stock').val("0");
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
    function setDelete()
    {
    }

    function setExcelUpload()
    {
    }

    function getExcelDownload()
    {
    }

    function setRackStock()
    {
        var rack_total = 0;
        var rack_remain;

        for(var i=0;i<rack_grid.getRowData().length;i++){
            rack_total = rack_total + parseInt(rack_grid.getRowData(i+1).item_amount);
        }
        rack_remain = parseInt(commapoint_format($('#detail_form_stock').val(),1,'int'))-rack_total;
        $('#rack_total').val(commapoint_format(rack_total+"",0,'int'));
        $('#rack_remain').val(commapoint_format(rack_remain+"",0,'int'));
    }

</script>