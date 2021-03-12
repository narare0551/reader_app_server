<script type="text/javascript">
    $(document).ready(function () {
        Init();
        getList();




    });

    function Init() {
        getUserTheme();
        getMenuInfo();
        getMenuInfo1();
        getMenuInfo2();
        getUserInfo();
        getUserName();


        setMenu();
        setMainGrid();
        eventDetail();

        getSelect();
        resetDetail();
        $("#pop_item").on('shown.bs.modal', function (e) {
            getPopupItemList();
        });


        $('#popup_search_form input').on('keydown',function(key){
            if (key.keyCode == 13) {
                getPopupItemList();
            }
        });

    }

    var menu_info;
    var menu_info1;
    var menu_info2;


    var main_grid;
    var main_grid1;
    var main_grid2;

    var user_info;

    var main_grid_width = 0;
    var delete_list = [];

    var user_name;

    //메인그리드
    function getMenuInfo() {
        menu_info = getAjax('/receipt/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    //디테일그리드
    function getMenuInfo1() {
        menu_info1 = getAjax('/receipt/getMenuInfo1', 'post', {}).responseText;
        menu_info1 = JSON.parse(menu_info1);
    }

    //팝업그리드
    function getMenuInfo2() {
        menu_info2 = getAjax('/order/getItemList', 'post', {}).responseText;
        menu_info2 = JSON.parse(menu_info2);
    }

    function getUserInfo() {
        user_info = getAjax('/member/getUserInfo', 'post', {}).responseText;
        user_info = JSON.parse(user_info);
    }
    function getUserName() {
        var name = getAjax('/receipt/getUserName', 'post', {}).responseText;
        name = JSON.parse(name);

        if(name != 'error'){
            user_name = name['result'];
        }
    }

    //팝업리스트
    function getPopupItemList(){
        main_grid2.lock(true, 'Loading...');
        var search = getSearch('popup_search_form');

        var result = getAjax('/order/getPopupItemList', 'post', {search: search}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            main_grid2.setAllData(result.data);
            main_grid2.lock(false);
        } else {
            main_grid2.setAllData([]);
            main_grid2.lock(false);
        }

    }


    function setMenu() {
        $('#menu_title').text(menu_info.title);
        var sm_title_html = "<li class=\"\"><a href=\"\">Home</a></li>";
        for (var i = menu_info.menu_path.length - 1; i >= 1; i--) {
            sm_title_html += '<li class=""><a href="">' + menu_info.menu_path[i] + '</a></li>';
        }
        sm_title_html += '<li class="active"><a href="">' + menu_info.menu_path[0] + '</a></li>';
        $('#menu_sm_title').html(sm_title_html);
        $('#list_title').text(menu_info.title + " 리스트");
        $('#detail_form_title').text(menu_info.title + " 상세정보");
        $('#btn_collection').html(menu_info.btn_html);
        $('#search_form').html(menu_info.search_html);

        $('#popup_search_form').html(menu_info2.search_html);


    }

    function setMainGrid() {
        main_grid = new FNRGrid();
        main_grid1 = new FNRGrid();
        main_grid2 = new FNRGrid();


        main_grid.setGrid('grid', 28, '', false, false, true, true, true, false);
        main_grid1.setGrid('grid1', 28, '', false, false, true, true, true, false);
        main_grid2.setGrid('grid2', 28, '', false, false, true, true, true, false);


        main_grid.setColumns(menu_info.list_columns);

        items = menu_info1.list_columns[2]['editable']['items']
        main_grid1.setColumns(menu_info1.list_columns);

        main_grid2.setColumns(menu_info2.list_columns);



        main_grid.eventGrid('click', clicklistfunction);
        main_grid1.eventGrid('change', changefunction);
        main_grid1.eventGrid('click', clickfunction2);

    }

    var items;
    var changefunction = function (event) {

        if (event.column == 2) {
            var text = '';
            var select_idx = main_grid1.getSelection();
            if (event.recid == select_idx[select_idx.length - 1]) {
                var data = main_grid1.getRowData(event.recid);

                var item_code = data.w2ui.changes.item_code;


                for (var i = 0; i < items.length; i++) {
                    if (items[i].id == item_code) {
                        text = items[i].text;
                        break;
                    }
                }
                main_grid1.setRowData(event.recid, {item_name: text});

            }


        }

        else if(event.column == 7){
            main_grid1.save();
        }


    }

    var clickfunction2 = function (event){

        if (event.column == 8) {
            var data = main_grid1.getRowData(event.recid)
            var rack_code = data.rack_code == null ? '' : data.rack_code;

            if (IsNullorEmpty(rack_code)) {
                main_grid1.grid['columns'][8]['editable']['items'] = [{id:'',text:''}];
            } else {
                var obj = '';
                obj = getAjax('/receipt/getRackSlaveCode', 'post', {rack_code: rack_code}).responseText;
                if (!IsNullorEmpty(obj)) {
                    obj = JSON.parse(obj);
                    main_grid1.grid['columns'][8]['editable']['items'] = obj;
                }else {
                    main_grid1.grid['columns'][8]['editable']['items'] = [{id:'',text:''}];
                }
            }
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


    //메인리스트
    function getList() {

        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/receipt/getList', 'post', {search: search}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            main_grid.setAllData(result.data);
            main_grid.lock(false);
        } else {
            main_grid.setAllData([]);
            main_grid.lock(false);
        }
    }

    function addItemRow(){

        // var row = main_grid1.getColumn(3);
        // console.log(row)


        var obj = new Object();
        obj.recid = '';
        obj.receipt_dt = getNowDateTime(true,true,false);
        obj.receipt_count = 0;
        obj.order_count = 0;
        main_grid1.addRow(obj);
    }

    var delete_item_list = [];
    //품목제거
    function removeItemRow(){
        var ids = main_grid1.getSelection();
        var data = main_grid1.getRowData(ids);
        main_grid1.removeRow();
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
        main_grid1.grid.selectNone();
        main_grid1.save();
    }

    function setItem(){
        var ids = main_grid2.getSelection();
        var row_data = main_grid2.getRowData(ids);

        var recid = main_grid1.getRowData().length+1;

        for (var i=0; i<row_data.length; i++){
            row_data[i].recid = recid++;
            row_data[i].receipt_dt = getNowDateTime(true,true,false);
            row_data[i].order_count = 0;
            row_data[i].receipt_count = 0;

        }
        main_grid1.addRow(row_data);

        main_grid2.grid.selectNone();


    }

    function getSelect() {

        var receipt_status = getCodeList("receipt_status","html");
        var receipt_status1 =  getCodeList("receipt_status","html_default");

        var receipt_type = getCodeList("receipt_type","html");
        var receipt_type1 = getCodeList("receipt_type","html_default");



        var company1 = getAjax('/company/getCompanyList','post',{option:'html_default',type:'receipt'}).responseText;
        company1 = JSON.parse(company1);

        $('#detail_form_receipt_status').html(receipt_status);
        $('#detail_form_receipt_type').html(receipt_type);
        $('#detail_form_company_code').html(company1);

        $('#search_receipt_status').html(receipt_status1);
        $('#search_receipt_type').html(receipt_type1);
        $('#search_company_code').html(company1);

        $("#detail_form_receipt_type").attr('readonly',true);




    }




    //메인디테일
    function showDetail(idx) {
        var result = getAjax('/receipt/showDetail', 'post', {idx: idx}).responseText;
        result = JSON.parse(result);
        if (result.result == true) {
            newDetail();
            $.each(result.data, function (key, value) {
                if (key != 'mod_user_id') {
                    $('#detail_form_' + key).val(value);
                }
            })
            $('#detail_form_receipt_code').attr('readonly', true);
            showItemsDetail(result.data.receipt_code);

        } else {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }
    }

    //발주디테일
    function showItemsDetail(code){
        var result = getAjax('/receipt/getItemsList', 'post', {receipt_code: code}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            main_grid1.setAllData(result.data);
            main_grid1.lock(false);

        } else {
            main_grid1.setAllData([]);
            main_grid1.lock(false);
        }
    }

    //메인저장
    function saveForm() {

        if($('#detail_form').hasClass("active")){
            var ids = $('input[id^="detail_form_"],select[id^="detail_form_"],textarea[id^="detail_form_"]');
                if ($('#detail_form_idx').val() == '') {
                    $('#detail_form_reg_user_id').val(user_info[0]['user_id']);
                    $('#detail_form_mod_user_id').val(user_info[0]['user_id']);
                    var result = setPostAjax('/receipt/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {

                        saveItemsList(result.receipt_code);

                        alert('저장 되었습니다.');
                        getList();
                        showDetail(result.idx);
                        main_grid.setSelectIdx(result.idx);

                    } else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                } else {
                    if(!IsNullorEmpty(delete_item_list)){
                        var result = getAjax('/receipt/itemDelete','post', {data : delete_item_list}).responseText;
                    }

                    var result = setPostAjax('/receipt/update', ids).responseText;

                    result = JSON.parse(result);
                    if (result.result == true) {
                        saveItemsList(result.receipt_code);

                        alert('수정 되었습니다.');
                        getList();
                        showDetail(result.idx);
                        main_grid.setSelectIdx(result.idx);
                    } else {
                        alert('수정에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                }

        }
        else {
            openDetail();
        }


    }
    //발주품목저장
    function saveItemsList(code){
        main_grid1.save();


        var list = [];

        var data = main_grid1.getRowData();


        for (var i=0; i<data.length; i++){
            if(!IsNullorEmpty(data[i].item_code)){
                var obj = new Object();
                if(!IsNullorEmpty(data[i].idx)){
                obj.idx = data[i].idx;
               }
               obj.item_code = data[i].item_code;
               obj.receipt_dt = data[i].receipt_dt == null ? '' : data[i].receipt_dt;
               obj.order_count = data[i].order_count == null ? '' : data[i].order_count;
               obj.receipt_count = data[i].receipt_count == null ? 0 : data[i].receipt_count;
               obj.remark = data[i].remark == null ? '' : data[i].remark;
               obj.rack_code = data[i].rack_code == null ? '' : data[i].rack_code;
               obj.rack_slave_code = data[i].rack_slave_code == null ? '' : data[i].rack_slave_code;

               list.push(obj);
            }
        }


        if(list.length>0){
            var result = getAjax('/receipt/saveReceiptItemsList', 'post', {data : list ,receipt_code : code}).responseText;
            result = JSON.parse(result);
            if(result.result == true)
            {


            }
            else
            {

            }
        }

    }

    function newDetail() {

        resetDetail("detail_form");
        openDetail();


    }

    function resetDetail(form_id) {
        var ids = $('#' + form_id + ' textarea[id^=' + form_id + '_],select[id^=' + form_id + '_],input[id^=' + form_id + '_]');
        for (var i = 0; i < ids.length; i++) {
            if(ids[i].id != 'detail_form_receipt_status' && ids[i].id != 'detail_form_receipt_type' && ids[i].id != 'detail_form_company_code'){
            $('#' + ids[i].id).val('');
            }
        }
        main_grid1.clearData();
        $('#detail_form_receipt_code').attr('readonly', false);
        delete_item_list = [];
        $('#detail_form_idx').val('');
        $('#detail_form_reg_user_id').val(user_name);
        $('#detail_form_mod_user_id').val(user_name);
        $('#detail_form_receipt_type').val("예외입고");



    }
    //발주제거
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
            list.push({'idx':data[i].idx,'receipt_code':data[i].receipt_code});
        }

        var check = confirm("삭제하시겠습니까?\n삭제한 뒤엔 복구가 불가능 합니다");
        if(check){
            var result = getAjax('/receipt/delete','post',{list:list}).responseText;
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





    function setExcelUpload() {
    }

    function getExcelDownload() {
    }

    function focusOnTopButtonClick(nth_child, focus_id)
    {
        $('#btn_collection a:nth-child('+nth_child+')').on('click',function(){
            $('#'+focus_id+'').focus();
        });
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







</script>