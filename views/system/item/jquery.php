<script type="text/javascript">
    $(document).ready(function () {
        Init();
        getList();
    });

    function Init() {
        getUserTheme();
        getMenuInfo();
        setMenu();
        setMainGrid();
        eventDetail();
        imgShowEvent();
        getSelect();
        resetDetail();
        focusOnTopButtonClick(2,'detail_form_item_code');
    }

    var menu_info;
    var main_grid;
    var main_grid_width = 0;
    var delete_list = [];
    var checkdeleteImage = false;

    function getMenuInfo() {
        menu_info = getAjax('/item/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
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
    }

    function setMainGrid() {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false, false, true, true, true, false);
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


    function getList() {

        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/item/getList', 'post', {search: search}).responseText;
        result = JSON.parse(result);

        if (result.result) {
            main_grid.setAllData(result.data);
            main_grid.lock(false);
        } else {
            main_grid.setAllData([]);
            main_grid.lock(false);
        }
    }

    function showDetail(idx) {
        var result = getAjax('/item/showDetail', 'post', {idx: idx}).responseText;
        result = JSON.parse(result);
        if (result.result == true) {
            newDetail();
            $.each(result.data, function (key, value) {
                if (key != '') {
                    $('#detail_form_' + key).val(value);
                }
            })
            var data = result.data;
            $('#detail_form_item_code').attr('readonly', true);
            $('#detail_form_item_code').removeClass('duplicate');

            if (data.real_file_name != null) {

                $('#upload_file_img').attr("src", data.file_path + data.save_file_name);
                $('#item_image').attr("src", data.file_path + data.save_file_name);
                var file_real_name = data.real_file_name;
                var file_name_arr = file_real_name.split(".");
                var file_name1 = "";
                var file_name2 = "";
                for (var i = 0; i < file_name_arr.length; i++) {
                    if (i == (file_name_arr.length - 1)) {
                        file_name2 = file_name_arr[i];
                    } else {
                        if (i != 0) {
                            file_name1 += ".";
                        }
                        file_name1 += file_name_arr[i];
                    }
                }
                if (file_name1.length > 10) {
                    file_name1 = file_name1.substring(0, 9);
                }
                $('#upload_file_name').text(file_name1 + "..." + file_name2);
                $('#upload_file_name').attr("href", data.file_path + data.save_file_name);
                $('#upload_file_name').attr("download", data.real_file_name);
                $('#upload_file_size').text((data.file_size / 1000).toFixed(0) + ' KB');

                $('#upload_file').show();
                $('#item_image').show();
            } else {
                $('#upload_file').hide();
                $('#item_image').hide();
            }

        } else {
            alert('데이터를 불러오는 중 오류가 발생했습니다.\n관리자에게 문의 해주세요');
        }
    }

    function saveForm() {

        if($('#detail_form').hasClass("active")){
            var ids = $('input[id^="detail_form_"],select[id^="detail_form_"],textarea[id^="detail_form_"]');

            if (checkRequired('detail_form') && checkDuplicate('/item/chkDuplicate', 'detail_form') ) {


                if ($('#detail_form_idx').val() == '') {

                    var result = setPostAjax('/item/create', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        alert('저장 되었습니다.');
                        getList();
                        showDetail(result.idx);
                        main_grid.setSelectIdx(result.idx);

                    } else {
                        alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                } else {
                    if (checkdeleteImage) {
                        var result = getAjax('/item/deleteFile', 'post', {idx: $('#detail_form_idx').val()}).responseText;
                    }
                    var result = setPostAjax('/item/update', ids).responseText;
                    result = JSON.parse(result);
                    if (result.result == true) {
                        alert('수정 되었습니다.');
                        getList();

                        showDetail(result.idx);
                        main_grid.setSelectIdx(result.idx);
                    } else {
                        alert('수정에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
                    }
                }
            }
        }
        else {
            openDetail();
        }


    }

    function newDetail() {

        resetDetail("detail_form");
        openDetail();
        imgShowEvent();

    }

    function resetDetail(form_id) {
        var ids = $('#' + form_id + ' textarea[id^=' + form_id + '_],select[id^=' + form_id + '_],input[id^=' + form_id + '_]');
        for (var i = 0; i < ids.length; i++) {
            $('#' + ids[i].id).val('');
        }
        checkdeleteImage = false;
        $('#detail_form_item_code').attr('readonly', false);
        $('#detail_form_item_code').addClass('duplicate');
        $('#upload_file').hide();
        $('#item_image').hide();
        $('#detail_form_fileupload').val("");
        $('#fileupload').val('');
        $('#detail_form_item_use_yn').val('Y');
        $('#detail_form_item_unit').val('EA');
        $('#detail_form_item_division').val('완제품');
        $('#detail_form_item_code').addClass('required');
        $('#detail_form_item_code').removeClass('error');
    }

    function setDelete() {
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
        // if(true){
        //  $("#detail_form_item_code").focus();
        // }
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

    function imgShowEvent() {
        $('#detail_form_fileupload').change(function (e) {
            var files = e.target.files;
            var files_arr = Array.prototype.slice.call(files);
            files_arr.forEach(function (f) {
                if (!f.type.match("image.*")) {
                    alert("이미지만 저장 가능 합니다.");
                    $('#detail_form_fileupload').val('');
                    $('#fileupload').val('');
                    $('#item_image').attr("src", '');
                    return false;
                }
                $('#upload_file').hide();
                $('#fileupload').val(f.name);
                var sel_file = f;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#item_image').attr("src", e.target.result);
                }
                reader.readAsDataURL(f);
            });
            $('#item_image').show();
        });
    }

    function deleteImage() {
        checkdeleteImage = true;
        $('#upload_file').hide();
        $('#item_image').hide();

    }

    function getSelect() {

        var unit = getCodeList("item_unit","html");
        var unit1 =  getCodeList("item_unit","html_default");

        var division = getCodeList("item_division","html");
        var division1 = getCodeList("item_division","html_default");


        $('#detail_form_item_unit').html(unit);
        $('#detail_form_item_division').html(division);

        $('#search_item_unit').html(unit1);
        $('#search_item_division').html(division1);
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
            data.push({0:value.item_code,1:value.item_name});
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