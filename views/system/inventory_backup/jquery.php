<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();
    });
    // 재고 품목 리스트
    var menu_info;
    var main_grid;

    // 재고 히스토리 리스트
    var menu_info2;
    var history_grid;

    // 창고별 재고 리스트
    var menu_info3;
    var rack_grid;

    function Init()
    {
        getUserTheme();
        getMenuInfo();
        getMenuInfo2();
        getMenuInfo3();
        setMenu();
        setMainGrid();
        setHistoryGrid();
        setRackGrid();
        getCode();
        eventDetail();
        numberOnly();
        $('#btn_create').hide();
    }
    function getCode()
    {
        $('#search_item_division').html(getCodeList('item_division','html_default'));
    }

    function numberOnly()
    {
        $("#detail_form_change_stock,#detail_form_safety_stock").on("keyup", function() {

            var str;
            var inputVal = $(this).val();
            str = inputVal.replace(/[^-0-9]/gi,'');
            if(str.lastIndexOf("-")>0){ //중간에 '-' 가 있다면 replace
                if(str.indexOf("-")==1){ //음수라면 replace 후 '-' 붙여준다.
                    str = "-"+str.replace(/[-]/gi,'');
                }else{
                    str = str.replace(/[-]/gi,'');
                }
            }
            str = str.replace(/(^0+)/, "");
            $(this).val(str);
            if($(this).val().length==0 || $(this).val()=='-'){ // 모두 지우거나 '-' 만 남았을 경우 '0' 세팅
                $(this).val("0");
            }
            $(this).val(commapoint_format($(this).val(),0,'int'));
        });
    }

    function getMenuInfo()
    {
        menu_info = getAjax('/inventory/getMenuInfo','post',{}).responseText;
        menu_info = JSON.parse(menu_info);
    }

    function getMenuInfo2()
    {
        menu_info2 = getAjax('/inventory/getMenuInfo2','post',{}).responseText;
        menu_info2 = JSON.parse(menu_info2);
    }
    function getMenuInfo3()
    {
        menu_info3 = getAjax('/inventory/getMenuInfo3','post',{}).responseText;
        menu_info3 = JSON.parse(menu_info3);
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

    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid.setColumns(menu_info.list_columns);
        // main_grid.eventGrid('change', changefunction);
        // main_grid.eventGrid('click', on_click);
        main_grid.eventGrid('click', clicklistfunction);
    }

    function setHistoryGrid()
    {
        history_grid = new FNRGrid();
        history_grid.setGrid('grid2', 24, '', false,false,true,true,false,false);
        history_grid_width = history_grid.setColumns(menu_info2.list_columns);
    }

    function setRackGrid()
    {
        rack_grid = new FNRGrid();
        rack_grid.setGrid('grid3', 24, '', false,false,true,true,false,false);
        rack_grid_width = rack_grid.setColumns(menu_info3.list_columns);
        // rack_grid.eventGrid('click', clickracklistfunction)
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

    // var clickracklistfunction = function(event){
    //     var select_idx = rack_grid.getSelection();
    //     if(event.recid == select_idx[select_idx.length -1]) {
    //         var detail_data = rack_grid.getRowData(event.recid);
    //         $('#detail_form_rack_name').val(detail_data.rack_name);
    //         $('#detail_form_slave_name').val(detail_data.slave_name);
    //     }
    // }

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



    // var changefunction = function(event){
    //     if(event.column == 7) {
    //         var change_data = main_grid.getRowData(event.recid);
    //         console.log(change_data);
    //         change_data.menu_icon = event.value_new;
    //         change_data.menu_icon_view = '<i class="fa ' + event.value_new + '"></i>';
    //         main_grid.setRowData(event.recid, change_data);
    //     }
    // }

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
        history_grid.clearData();
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
        $('#detail_form').addClass("active");
        $('#detail_form_change_stock').val("0");
        $('#detail_form_change_stock').focus();
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

    function setPrint(){

        var ids = main_grid.getSelection();
        var row_data = main_grid.getRowData(ids);
        if(row_data.length==0){
            alert("체크된 항목이 없습니다.");
            return;
        }
        var data= [];
        $.each(row_data,function (key,value){
            data.push({0:value.inventory_code,1:value.inventory_name});
        });
        mulPrintBarcode(data,'print_div');
        main_grid.grid.selectNone();
    }


    function mulPrintBarcode(dataObj=null,id="print_div",onePage=true,useQR=false,nameLabel=false){
        var id = id;
        var useQR = useQR;
        var nameLabel =nameLabel;
        var onePage = onePage;
        var data;
        if(!IsNullorEmpty(dataObj)){
            data = dataObj;
        }else {

        }
        if(!IsNullorEmpty(data)){
            $('#'+id).attr('style','display:none;')

            var html ='';
            $('#'+id).html(html);
            for(var i=0; i<data.length; i++){
                if(onePage){
                    html += `<div id ='`+"barcode_"+i+`' style='page-break-before:always'>`;
                }else {
                    html += `<div id ='`+"barcode_"+i+`'  style='page: a4sheet;'>`;
                }
                html += `<table>`;
                html += `<tr>`;

                html += `<td>`;
                html += `<div class=barcode_canvas>`
                html += `</div>`
                html += `</td>`;

                html += `<td>`;
                html += `<div class=barcode_text style="margin-left: 30px">`
                html += `</div>`
                html += `</td>`;

                html += `</tr>`;
                html += `</table>`;
                html += `</div>`;

            }
            $('#'+id).html(html);

            if(useQR){

                for(var i=0; i<data.length; i++){
                    $('#barcode_'+i+" .barcode_canvas").attr('style','padding: 0px; overflow: auto; width: 50px;');
                    $('#barcode_'+i+" .barcode_canvas").qrcode({
                        render: 'table',
                        width:40,
                        height:40,
                        fontcolor: '#000',
                        text	: data[i][0]
                    });
                    if(nameLabel){
                        $('#barcode_'+i+" .barcode_text").text(data[i][1]);
                    }


                }


            }else {
                for(var i=0; i<data.length; i++){
                    $('#barcode_'+i+" .barcode_canvas").attr('style','padding: 0px; overflow: auto; width: 90%;');
                    $('#barcode_'+i+" .barcode_canvas").barcode(data[i][0], "code128",{barWidth:2, barHeight:30});
                    if(nameLabel){
                        $('#barcode_'+i+" .barcode_text").text(data[i][1]);
                    }
                }

            }

            var win =window.open();
            self.focus();
            win.document.open();
            win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
            win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
            win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');

            win.document.write($('#'+id).html());

            win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
            win.document.close();
            win.print();
            win.close();
        }
    }

</script>