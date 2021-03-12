<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();
    });
    // 출고 리스트
    var menu_info;
    var main_grid;

    // 출고 품목 리스트
    var menu_info2;
    var sub_grid;
    
    // 팝업
    var menu_info3;
    var popup_grid;
    function Init()
    {
        getUserTheme();
        getMenuInfo();
        getMenuInfo2();
        getMenuInfo3();

        setMenu();
        setMainGrid();
        setSubGrid();
        setPopupGrid();

        eventDetail();
        setDetail();
        // numberOnly();
        getCode();

        $("#pop_item").on('shown.bs.modal', function (e) {
            getPopupItemList();
        });

        $('#popup_search_form input').on('keydown',function(key){
            if (key.keyCode == 13) {
                getPopupItemList();
            }
        });


    }

    function getCode()
    {
        $('#search_status').html(getCodeList('outgoing_status','html_default'));
        $('#detail_form_status').html(getCodeList('outgoing_status','html'));
        var result = getAjax('/company/getCompanyList','post',{option:'html',type:'outgoing'}).responseText;
        $('#detail_form_company_code').html(JSON.parse(result));
        var result = getAjax('/company/getCompanyList','post',{option:'html_default',type:'outgoing'}).responseText;
        $('#search_company_code').html(JSON.parse(result));
    }
    function setDetail()
    {
        $('#write_form').html(menu_info.detail);
    }
    // function numberOnly()
    // {
    //     $("#detail_form_change_stock,#detail_form_safety_stock").on("keyup", function() {
    //
    //         var str;
    //         var inputVal = $(this).val();
    //         str = inputVal.replace(/[^-0-9]/gi,'');
    //         if(str.lastIndexOf("-")>0){ //중간에 '-' 가 있다면 replace
    //             if(str.indexOf("-")==1){ //음수라면 replace 후 '-' 붙여준다.
    //                 str = "-"+str.replace(/[-]/gi,'');
    //             }else{
    //                 str = str.replace(/[-]/gi,'');
    //             }
    //         }
    //         str = str.replace(/(^0+)/, "");
    //         $(this).val(str);
    //         if($(this).val().length==0 || $(this).val()=='-'){ // 모두 지우거나 '-' 만 남았을 경우 '0' 세팅
    //             $(this).val("0");
    //         }
    //         $(this).val(commapoint_format($(this).val(),0,'int'));
    //     });
    // }

    function getMenuInfo()
    {
        menu_info = getAjax('/outgoing/getMenuInfo','post',{}).responseText;
        menu_info = JSON.parse(menu_info);
    }

    function getMenuInfo2()
    {
        menu_info2 = getAjax('/outgoing/getMenuInfo2','post',{}).responseText;
        menu_info2 = JSON.parse(menu_info2);
    }

    //팝업그리드
    function getMenuInfo3() {
        menu_info3 = getAjax('/order/getItemList', 'post', {}).responseText;
        menu_info3 = JSON.parse(menu_info3);
    }

    //팝업리스트
    function getPopupItemList(){
        popup_grid.lock(true, 'Loading...');
        var search = getSearch('popup_search_form');

        var result = getAjax('/order/getPopupItemList', 'post', {search: search}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            popup_grid.setAllData(result.data);
            popup_grid.lock(false);
        } else {
            popup_grid.setAllData([]);
            popup_grid.lock(false);
        }
    }

    function setItem(){
        var ids = popup_grid.getSelection();
        var row_data = popup_grid.getRowData(ids);

        var recid = sub_grid.getRowData().length+1;

        for (var i=0; i<row_data.length; i++){
            row_data[i].recid = recid++;
            row_data[i].outgoing_date = getNowDateTime(true,true,false);
            row_data[i].amount = 0;
        }
        sub_grid.addRow(row_data);

        popup_grid.grid.selectNone();
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
        $('#popup_search_form').html(menu_info3.search_html);
        items = menu_info2.list_columns[2]['editable']['items'];
    }

    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,true,false);
        main_grid_width = main_grid.setColumns(menu_info.list_columns);
        // main_grid.eventGrid('change', changefunction);
        // main_grid.eventGrid('click', on_click);
        main_grid.eventGrid('click', clicklistfunction);
    }

    function setSubGrid()
    {
        sub_grid = new FNRGrid();
        sub_grid.setGrid('sub_grid', 28, '', false,false,true,true,true,false);
        sub_grid_width = sub_grid.setColumns(menu_info2.list_columns);
        sub_grid.eventGrid('change',changefunction);
        sub_grid.eventGrid('click',clickfunction2);
    }

    function setPopupGrid()
    {
        popup_grid = new FNRGrid();
        popup_grid.setGrid('grid2', 28, '', false,false,true,true,true,false);
        popup_grid_width = popup_grid.setColumns(menu_info3.list_columns);
    }


    var items;
    var changefunction = function (event) {
        if (event.column == 2) {
            var text = '';
            var select_idx = sub_grid.getSelection();
            if (event.recid == select_idx[select_idx.length - 1]) {
                var data = sub_grid.getRowData(event.recid);
                var item_code = data.w2ui.changes.item_code;
                for (var i = 0; i < items.length; i++) {
                    if (items[i].id == item_code) {
                        text = items[i].text;
                        break;
                    }
                }
                sub_grid.setRowData(event.recid, {item_name: text});
            }

        }
        else if(event.column == 6){
            sub_grid.save();
        }
    }

    var clickfunction2 = function (event){
        if (event.column == 7) {
            var data = sub_grid.getRowData(event.recid);

            var rack_code = data.rack_code == null ? '' : data.rack_code;


            if (IsNullorEmpty(rack_code)) {
                console.log(1);
                sub_grid.grid['columns'][7]['editable']['items'] = [{id:'',text:''}];
            } else {
                var obj = '';

                obj = getAjax('/receipt/getRackSlaveCode', 'post', {rack_code: rack_code}).responseText;
                if (!IsNullorEmpty(obj)) {
                    obj = JSON.parse(obj);
                    sub_grid.grid['columns'][7]['editable']['items'] = obj;
                } else {
                    sub_grid.grid['columns'][7]['editable']['items'] = [{id:'',text:''}];
                }
            }
        }
    }

    var on_click = function(event){
        var list = main_grid.getSelection();
        if(list.length > 0) {
            var detail_data = main_grid.getRowData(event.recid);
            showDetail(detail_data.idx);
        }
        else
        {
            newDetail();
        }
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

    function getList()
    {
        main_grid.lock(true, 'Loading...');

        var search = getSearch();
        var result = getAjax('/outgoing/getList', 'post', {search:search}).responseText;
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
        var result = getAjax('/outgoing/showDetail', 'post', {idx : idx}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {
            newDetail();

            $.each(result.data, function(key, value){
                        $('#detail_form_' + key).val(value);
            });
            var result = getAjax('/outgoing/getList','post',{outgoing_code: $('#detail_form_outgoing_code').val()}).responseText;
            result = JSON.parse(result);
            // if(result != '[]') {
            if(result.result == true){
                sub_grid.setAllData(result.data);
                sub_grid.lock(false);
            }
            else
            {
                alert("데이터를 가져올 수 없습니다.\n관리자에게 문의바랍니다.");
                sub_grid.lock(false);
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
        sub_grid.clearData();
    }

    var delete_item_list = [];
    // 출고품목제거
    function  removeItemRow(){
        var ids = sub_grid.getSelection();
        var data = sub_grid.getRowData(ids);
        sub_grid.removeRow();
        for(var i=0; i<data.length; i++)
        {
            if(data[i].idx == null)
            {

            }
            else
            {
                delete_item_list.push(data[i].idx);
            }
        }
        sub_grid.grid.selectNone();
        sub_grid.save();
    }
    
    // function removeRow()
    // {
    //         var recid = sub_grid.getSelection();
    //         var data = sub_grid.getRowData(recid);
    //         var result = confirm("삭제하면 복구할 수 없습니다. 삭제하시겠습니까?");
    //         if(result)
    //         {
    //             for(var i=0; i<data.length; i++)
    //             {
    //                     sub_grid.removeRow(data[i].recid);
    //             }
    //         }
    // }

    function setDelete() {
        var list =[];
        var ids = main_grid.getSelection();
        var data = main_grid.getRowData(ids);

        if(data.length<=0){
            alert("체크된 항목이 없습니다.");
            return;
        }

        for(var i=0; i<data.length; i++)
        {
            list.push({'idx':data[i].idx,'outgoing_code':data[i].outgoing_code});
        }

        var check = confirm("삭제하면 복구할 수 없습니다. 삭제하시겠습니까?");
        if(check){
            var result = getAjax('/outgoing/delete','post',{list:list}).responseText;
            result = JSON.parse(result);
            if(result.result){
                alert("삭제되었습니다.")
            }else {
                alert("삭제에 실패 하였습니다.\n시스템관리자에게 문의하여 주세요")
            }
        }

        main_grid.grid.selectNone();
        getList();
        resetDetail("detail_form");
    }


    function saveForm()
    {
            var ids = $('#detail_form [id^=detail_form_]');
            if ($('#detail_form_idx').val() == '') {
                var result = setPostAjax('/outgoing/create', ids).responseText;
                result = JSON.parse(result);
                if (result.result == true && saveOutgoingItemList(result.outgoing_code)) {
                // if (result.result == true) {

                    alert('저장 되었습니다.');
                    getList();
                    newDetail();
                    main_grid.setSelectIdx(result.idx);
                    showDetail(result.idx);
                } else {
                    alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                }
            } else {
                if(!IsNullorEmpty(delete_item_list)){
                    var result = getAjax('/outgoing/itemDelete','post', {data : delete_item_list}).responseText;
                }
                var result = setPostAjax('/outgoing/update', ids).responseText;
                result = JSON.parse(result);
                if (result.result == true && saveOutgoingItemList(result.outgoing_code)) {
                    alert('수정 되었습니다.');
                    getList();
                    newDetail();
                    main_grid.setSelectIdx(result.idx);
                    showDetail(result.idx);
                } else {
                    alert('수정에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                }
            }
    }

    function saveOutgoingItemList(outgoing_code){
        sub_grid.save();
        var list = [];
        var data = sub_grid.getRowData();
        for (var i=0; i<data.length; i++){
            var obj = new Object();
            if(!IsNullorEmpty(data[i].idx)){
                obj.idx = data[i].idx;
            }
            obj.item_code = data[i].item_code;
            obj.amount = data[i].amount == null ? 0 : data[i].amount;
            obj.outgoing_date = data[i].outgoing_date == null ? '' : data[i].outgoing_date;
            obj.remark = data[i].remark == null ? '' : data[i].remark;
            obj.rack_code = data[i].rack_code == null ? '' : data[i].rack_code;
            obj.rack_slave_code = data[i].rack_slave_code == null ? '' : data[i].rack_slave_code;
            list.push(obj);
        }
        if(list.length>0){
            var result = getAjax('/outgoing/saveOutgoingItemList', 'post', {data : list ,outgoing_code : outgoing_code}).responseText;
            result = JSON.parse(result);
            if(result.result == true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else{
            return true;
        }
    }

    function newDetail()
    {
        resetDetail('detail_form');
        $('#detail_form').addClass("active");
        $('#detail_form_company_code option:eq(0)').prop("selected",true);
        $('#detail_form_status option:eq(0)').prop("selected",true);
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


    function setExcelUpload()
    {
    }

    function getExcelDownload()
    {
    }

    function setPrint(){
    }

</script>