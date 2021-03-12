<script type="text/javascript">
    $(document).ready(function () {
        Init();
        getList();

    });

    function Init() {
        getUserTheme();
        getMenuInfo();
        getMenuInfo2();
        getMenuInfo3();

        setMenu();
        setMainGrid();
        setDatepicker();
        eventDetail();


        resetDetail();
        $("#pop_item").on('shown.bs.modal', function (e) {
            getPopupItemList();
        });


        $('#popup_search_form input').on('keydown',function(key){
            if (key.keyCode == 13) {
                getPopupItemList();
            }
        });
        getCompanyList();
        getOrderStatus();

    }

    var menu_info;
    var menu_info1;
    var menu_info2;

    var main_grid;
    var main_grid1;
    var main_grid2;

    var main_grid_width = 0;
    var delete_list = [];


    //메인그리드
    function getMenuInfo() {
        menu_info = getAjax('/order/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    //디테일그리드
    function getMenuInfo2() {
        menu_info1 = getAjax('/order/getOrderItems', 'post', {}).responseText;
        menu_info1 = JSON.parse(menu_info1);
    }

    //팝업그리드
    function getMenuInfo3() {
        menu_info2 = getAjax('/order/getItemList', 'post', {}).responseText;
        menu_info2 = JSON.parse(menu_info2);
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


        $('#search_order_dt').addClass('facnroll-datepicker')
        $('#search_order_dt_ed').addClass('facnroll-datepicker')
    }

    function setMainGrid() {
        main_grid = new FNRGrid();
        main_grid1 = new FNRGrid();
        main_grid2 = new FNRGrid();

        main_grid.setGrid('grid', 28, '', false, false, true, true, true, false);
        main_grid1.setGrid('grid1', 28, '', false, false, true, true, true, false);
        main_grid2.setGrid('grid2', 28, '', false, false, true, true, true, false);

        main_grid.setColumns(menu_info.list_columns);
        main_grid1.setColumns(menu_info1.list_columns);
        main_grid2.setColumns(menu_info2.list_columns);


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

    //메인리스트
    function getList() {

        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/order/getList', 'post', {search: search}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            main_grid.setAllData(result.data);
            main_grid.lock(false);
        } else {
            main_grid.setAllData([]);
            main_grid.lock(false);
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


    //메인디테일
    function showDetail(idx) {
        var result = getAjax('/order/showDetail', 'post', {idx: idx}).responseText;
        result = JSON.parse(result);
        if (result.result == true) {
            newDetail();
            $.each(result.data, function (key, value) {
                if (key != '') {
                    $('#detail_form_' + key).val(value);
                }
            })
            showOrderItemsDetail(result.data.order_code);

        } else {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }
    }

    //발주품목디테일
    function showOrderItemsDetail(order_code){
        var result = getAjax('/order/getOrderItemsList', 'post', {order_code: order_code}).responseText;
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

                    var result = setPostAjax('/order/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        // saveOrderItemsList(result.data.order_code);
                        saveOrderItemsList(result.order_code)
                        alert('저장 되었습니다.');
                        getList();
                        showDetail(result.idx);
                        main_grid.setSelectIdx(result.idx);

                    } else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                } else {
                    if(!IsNullorEmpty(delete_item_list)){
                        var result = getAjax('/order/itemDelete','post', {data : delete_item_list}).responseText;
                    }
                    var result = setPostAjax('/order/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        saveOrderItemsList(result.order_code);
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
    function saveOrderItemsList(order_code){
        main_grid1.save();

        var list = [];

        var data = main_grid1.getRowData();


        for (var i=0; i<data.length; i++){
            var obj = new Object();
            if(!IsNullorEmpty(data[i].idx)){
            obj.idx = data[i].idx;
           }
           obj.item_code = data[i].item_code;
           obj.count = data[i].count == null ? 0 : data[i].count;
           obj.price = data[i].price == null ? 0 : data[i].price;
           obj.remark = data[i].remark == null ? '' : data[i].remark;
           obj.surtax = data[i].surtax == null ? 0 : data[i].surtax;
           obj.unit_price =data[i].unit_price == null ? 0 : data[i].unit_price;
           list.push(obj);
        }


        if(list.length>0){
            var result = getAjax('/order/saveOrderItemsList', 'post', {data : list ,order_code : order_code}).responseText;
            result = JSON.parse(result);
            if(result.result == true)
            {


            }
            else
            {

            }
        }

    }
    //발주품목추가
    function setItem(){
        var ids = main_grid2.getSelection();
        var row_data = main_grid2.getRowData(ids);

        var recid = main_grid1.getRowData().length+1;

        for (var i=0; i<row_data.length; i++){
            row_data[i].recid = recid++;
        }
        main_grid1.addRow(row_data);

        main_grid2.grid.selectNone();


    }

    var delete_item_list = [];


    //발주품목제거
    function  removeItemRow(){
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

    function newDetail() {

        resetDetail("detail_form");
        openDetail();


    }

    function resetDetail(form_id) {
        var ids = $('#' + form_id + ' textarea[id^=' + form_id + '_],select[id^=' + form_id + '_],input[id^=' + form_id + '_]');
        for (var i = 0; i < ids.length; i++) {
            if(ids[i].id != 'detail_form_company_code' && ids[i].id != 'detail_form_order_status'){
            $('#' + ids[i].id).val('');
            }
        }
        main_grid1.clearData();
        delete_item_list = [];
        $('#detail_form_idx').val('');
        var now = getNowDateTime(true,false,false);
        $('#detail_form_delivery_dt').val(now);
        $('#detail_form_order_dt').val(now);
        $('#detail_form_reg_user_id').val('admin');



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
            list.push({'idx':data[i].idx,'order_code':data[i].order_code});
        }

        var check = confirm("삭제하시겠습니까?\n삭제한 뒤엔 복구가 불가능 합니다");
        if(check){
            var result = getAjax('/order/delete','post',{list:list}).responseText;
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
    //거래처리스트가져오기
    function getCompanyList(){
        var result = getAjax('/company/getCompanyList','post',{option:'html',type:'receipt'}).responseText
        result = JSON.parse(result);


        var result1 = getAjax('/company/getCompanyList','post',{option:'html_default',type:'receipt'}).responseText
        result1 = JSON.parse(result1);


        $('#detail_form_company_code').html(result);
        $('#search_company_code').html(result1);
    }


    function getOrderStatus() {
        getCodeList("order_status","html")

        var result = getCodeList("order_status","html");
        var result1 = getCodeList("order_status","html_default");


        $('#detail_form_order_status').html(result);
        $('#search_order_status').html(result1);

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

