<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();
    });

    var menu_info;
    var main_grid;

    function Init()
    {
        getUserTheme();
        getMenuInfo();
        setMenu();
        setMainGrid();
        getCode();
        eventDetail();
        focusOnTopButtonClick(2,'detail_form_company_code');
    }
    function getCode()
    {
        $('#detail_form_category').html(getCodeList('customer_division','html'));
        $('#search_category').html(getCodeList('customer_division','html_default'));
    }

    function getMenuInfo()
    {
        menu_info = getAjax('/company/getMenuInfo','post',{}).responseText;
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
        $('#detail_form_title').text(menu_info.title + " 상세정보");
        $('#search_form').html(menu_info.search_html);
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
        var result = getAjax('/company/getList', 'post', {search:search}).responseText;
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

    function chkDuplicate(){
        return checkDuplicate('/company/chkDuplicate', 'detail_form');
    }

    function showDetail(idx)
    {

        var result = getAjax('/company/showDetail', 'post', {idx : idx}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {
            newDetail();
            $('#detail_form_company_code').attr("readonly",true);

            $.each(result.data, function(key, value){
                if(key != 'user_pw') {
                    $('#detail_form_' + key).val(value);
                }
            });
            $('#detail_form_company_code').removeClass('duplicate');
            $('#detail_form_company_code').removeClass("required");

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
        $('#detail_form_category option:eq(0)').prop("selected",true);
        $('#detail_form_use_yn').val('Y');
        $('#detail_form_company_code').addClass('duplicate');
    }

    function saveForm()
    {
            if (checkRequired('detail_form') && chkDuplicate()) {
                var ids = $('#detail_form [id^=detail_form_]');
                if ($('#detail_form_idx').val() == '') {
                    var result = setPostAjax('/company/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        alert('저장 되었습니다.');
                        getList();
                        newDetail();
                        main_grid.setSelectIdx(result.idx);
                        showDetail(result.idx);
                    } else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                } else {
                    var result = setPostAjax('/company/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
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
    }

    function newDetail()
    {
        resetDetail('detail_form');
        $('#detail_form').addClass("active");
        $('#detail_arrow_icon i').removeClass("fa-arrow-left");
        $('#detail_arrow_icon i').addClass("fa-arrow-right");
        $('#detail_form_company_code').attr("readonly",false);
        $('#detail_form_company_code').addClass("required");
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

    function focusOnTopButtonClick(nth_child, focus_id)
    {
        $('#btn_collection a:nth-child('+nth_child+')').on('click',function(){
            $('#'+focus_id+'').focus();
        });
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
            data.push({0:value.company_code,1:value.company_name});
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