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
        getRackColumns();
        setMenu();
        setMainGrid();
        setMainGrid2();
        // setDatepicker();
    }
    var menu_info;
    var rack_columns;
    var main_grid1, main_grid2;
    var main_grid_width = 0;
    var delete_list1=[];
    var delete_list2=[];

    function getMenuInfo()
    {
        menu_info = getAjax('/rack/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    function getRackColumns()
    {
        rack_columns = getAjax('/rack/getRackColumns', 'post', {}).responseText;
        rack_columns = JSON.parse(rack_columns);
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
        $('#list_title').text("창고 리스트");
        $('#detail_title').text("창고 위치 리스트");
        $('#search_form').html(menu_info.search_html);
    }
    function setMainGrid()
    {
        main_grid1 = new FNRGrid();
        main_grid1.setGrid('grid1', 28, '', false,false,true,true,true,false,true);
        main_grid_width = main_grid1.setColumns(rack_columns.list_columns);
        main_grid1.eventGrid('editField', changefunction);
        main_grid1.eventGrid('click', on_click);
    }
    function setMainGrid2()
    {
        main_grid2 = new FNRGrid();
        main_grid2.setGrid('grid2', 28, '', false,false,true,true,true,false,true);
        main_grid_width = main_grid2.setColumns(menu_info.list_columns);
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
                    $('input#grid_grid1_edit_' + event.recid + '_2').on('blur', function () {
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
            if(event.column == 3) {
                var check_idx = main_grid2.getRowData(edit_recid);
                if(check_idx.idx == '') {
                    // $('input#grid_grid1_edit_' + event.recid + '_1').attr('readonly', false);
                    $('input#grid_grid2_edit_' + event.recid + '_4').on('blur', function () {
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
                showDetail(data.rack_code);
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
                rack_code: "",
                rack_name: "",
                use_yn: true,
                mod_dttm: "",
                mod_user_id: "",
                reg_dttm: getNowDateTime(true,true),
                reg_user_id: "",
                recid:'',
                idx:''
            };
            main_grid1.addRow(data);
            resetDetail();
        }
        else
        {
            var select_code = main_grid1.getSelection();
            var get_rack_code = main_grid1.getRowData(select_code);
            var rack_name;
            //선택한 창고코드 자동으로 입력되게 함
            if(IsNullorEmpty(select_code))
            {
                rack_name = "";
            }
            else
            {
                rack_name = get_rack_code[0].rack_name;
            }

            var data = {
                rack_name: rack_name,
                slave_code: "",
                slave_name: "",
                use_yn: true,
                item_code: "",
                item_name: "",
                item_amount: 0,
                mod_dttm: "",
                mod_user_id: "",
                reg_dttm: getNowDateTime(true,true),
                reg_user_id: "",
                recid:'',
                idx:''
            };
            if(IsNullorEmpty(main_grid1.getSelection()))
            {
                alert('위치를 추가할 창고를 선택해주세요.');
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
            main_grid1.save();
            var return_data = true;
            var data = main_grid1.getSelection();
            if(data.length == 0)
            {
                alert('선택된 창고가 없습니다.');
                return false;
            }
            if(confirm('창고를 삭제하시겠습니까?\n※주의 : 삭제 시 복구 되지 않습니다.')) {
                for (var i = 0; i < data.length; i++) {
                    var temp = main_grid1.getRowData(data[i]);
                    if (IsNullorEmpty(temp.idx)) {
                        main_grid1.removeRow(temp.recid);
                    } else {
                        var result = getAjax('/rack/checkSlave', 'post', {rack_code : temp.rack_code}).responseText;
                        result = JSON.parse(result);
                        if(result.result == false) {
                            delete_list1.push(temp.idx);
                            main_grid1.removeRow(temp.recid);
                            return_data = true;
                        }
                        else
                        {
                            alert(temp.rack_name + '은(는) 창고 위치가 등록되어 있어 삭제 할 수 없습니다.');
                            return_data = false;
                        }
                    }
                }
                if(return_data == true)
                {
                    saveForm();
                }
                else{
                }
            }
        }
        else
        {
            main_grid2.save();
            var data = main_grid2.getSelection();
            var return_data = true;
            if(data.length == 0)
            {
                alert('선택된 창고 위치가 없습니다.');
                return false;
            }
            if(confirm('창고 위치를 삭제하시겠습니까?\n※주의 : 삭제 시 복구 되지 않습니다.')) {
                for (var i = 0; i < data.length; i++) {
                    var temp = main_grid2.getRowData(data[i]);
                    if (IsNullorEmpty(temp.idx)) {
                        main_grid2.removeRow(temp.recid);
                        return_data = false;
                    }
                    else {
                        delete_list2.push(temp.idx);
                        main_grid2.removeRow(temp.recid);
                        return_data = true;
                    }
                }
                if(return_data == true)
                {
                    saveForm();
                }
                else{
                }
            }
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

    //창고코드 중복값 체크
    function chkRackCode()
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
                    if(default_list[i].rack_code == default_list1[j].rack_code)
                    {
                        if(IsNullorEmpty(default_list[i].idx))
                        {
                            edit_recid = default_list[i].recid;
                        }
                        else if(IsNullorEmpty(default_list1[j].idx))
                        {
                            edit_recid = default_list1[j].recid;
                        }
                        return_data = false;
                        break;
                    }
                    else if(IsNullorEmpty(default_list[i].rack_code) || IsNullorEmpty(default_list[i].rack_code))
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

    //창고 위치코드 중복값 체크
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
                        if(IsNullorEmpty(default_list[i].idx))
                        {
                            edit_recid = default_list[i].recid;
                        }
                        else if(IsNullorEmpty(default_list1[j].idx))
                        {
                            edit_recid = default_list1[j].recid;
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
                main_grid2.editFocus(edit_recid, 3);
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
        var result = getAjax('/rack/getList', 'post', {search:search}).responseText;
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

    function showDetail(rack_code)
    {
        var search = getSearch();
        var result = getAjax('/rack/showDetail', 'post', {rack_code:rack_code, search:search}).responseText;
        result = JSON.parse(result);
        if(result.result) {
            main_grid2.setAllData(result.data);
        }
        else {
            main_grid2.setAllData(result.data);
        }
    }

    function saveForm()
    {
        if(focus_location == "main")
        {
            main_grid1.save();
            if(delete_list1 != "[]")
            {
                for (var i = 1; i <= main_grid1.getRowData().length; i++) {
                    var rack_code = main_grid1.getRowData()[i-1].rack_code;
                    var rack_name = main_grid1.getRowData()[i-1].rack_name;
                    if (IsNullorEmpty(rack_code)) {
                        alert("창고코드은(는) 필수 값 입니다.");
                        return false;
                    } else if (IsNullorEmpty(rack_name)) {
                        alert("창고명은(는) 필수 값 입니다.");
                        return false;
                    }
                }
            }
            if(chkRackCode() == false)
            {
                alert("창고코드이(가) 중복되었습니다.");
                chkRackCode();
                return false;
            }
            else{
                var result = getAjax('/rack/save', 'post', {data : main_grid1.getRowData(), del_data : delete_list1}).responseText;
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
            var rack_code;
            if(list.length > 0) {
                var data = main_grid1.getRowData(list[0]);
                rack_code = data.rack_code;
            }
            main_grid2.save();
            if(IsNullorEmpty(delete_list2) || delete_list2 == "[]")
            {
                for (var i = 1; i <= main_grid2.getRowData().length; i++) {
                    var slave_code_chk = main_grid2.getRowData()[i-1].slave_code;
                    var slave_name_chk = main_grid2.getRowData()[i-1].slave_name;
                    if (IsNullorEmpty(slave_code_chk)) {
                        alert("창고 위치코드은(는) 필수 값 입니다.");
                        return false;
                    } else if (IsNullorEmpty(slave_name_chk)) {
                        alert("창고 위치명은(는) 필수 값 입니다.");
                        return false;
                    }
                }
            }
            if(chkSlaveCode() == false)
            {
                chkSlaveCode();
                alert("창고 위치코드이(가) 중복되었습니다.");
                return false;
            }
            var result = getAjax('/rack/saveDetail', 'post', {data : main_grid2.getRowData(), rack_code:rack_code, del_data : delete_list2}).responseText;
            result = JSON.parse(result);
            if(result.result == true)
            {
                alert('저장 되었습니다.');
                delete_list2=[];
                showDetail(rack_code);
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
        if(focus_location == "main")
        {
            var ids = main_grid1.getSelection();
            var row_data = main_grid1.getRowData(ids);
            if(row_data.length==0){
                alert("체크된 항목이 없습니다.");
                return;
            }
            var data= [];
            $.each(row_data,function (key,value){
                data.push({0:value.rack_code,1:value.rack_name});
            });
            Print(data,'print_div');
            main_grid1.grid.selectNone();
        }
        else{
            var ids = main_grid2.getSelection();
            var row_data = main_grid2.getRowData(ids);
            if(row_data.length==0){
                alert("체크된 항목이 없습니다.");
                return;
            }
            var data= [];
            $.each(row_data,function (key,value){
                data.push({0:value.slave_code,1:value.slave_name});
            });
            Print(data,'print_div_2');
            main_grid2.grid.selectNone();
        }
    }

    // function makeQR(text, name)
    // {
    //     $('#qrcodeCanvas').html('');
    //
    //     $('#qrcodeCanvas').attr('style','padding: 0px; overflow: auto; width: 90%;');
    //     $('#qrcodeCanvas').barcode(text, 'code128',{barWidth:2, barHeight:30});
    //     $('#qrcodeText').text('');
    //
    // }
    function Print(data=null,id="",onePage=true,useQR=false,nameLabel=false){
        if(id == "print_div")
        {
            var id = id;
            var useQR = useQR;
            var nameLabel = nameLabel;
            var onePage = onePage;
            var data = data;
            if(!IsNullorEmpty(data)){
                $('#'+id).attr('style','display:none;');
                var html ='';
                $('#'+id).html(html);
                for(var i=0; i<data.length; i++){
                    if(onePage){
                        html += `<div id ='`+"barcode_"+i+`' style='page-break-before:always'>`;
                    }else {
                        html += `<div id ='`+"barcode_"+i+`'  style='page: a4sheet;'>`;
                    }
                    html += '<table>';
                    html += '<tr>';
                    html += '<td>';
                    html += '<div class=barcode_canvas>';
                    html += '</div>';
                    html += '</td>';
                    html += '<td>';
                    html += '<div class=barcode_text style="margin-left: 30px">';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                    html += '</table>';
                    html += '</div>';
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
                        if(nameLabel) {
                            $('#barcode_' + i + " .barcode_text").text(data[i][1]);
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
        else {
            var id = id;
            var useQR = useQR;
            var nameLabel = nameLabel;
            var onePage = onePage;
            var data = data;
            if (!IsNullorEmpty(data)) {
                $('#' + id).attr('style', 'display:none;');
                var html = '';
                $('#' + id).html(html);
                for (var i = 0; i < data.length; i++) {
                    if (onePage) {
                        html += `<div id ='` + "barcode_" + i + `' style='page-break-before:always'>`;
                    } else {
                        html += `<div id ='` + "barcode_" + i + `'  style='page: a4sheet;'>`;
                    }
                    html += '<table>';
                    html += '<tr>';
                    html += '<td>';
                    html += '<div class=barcode_canvas>';
                    html += '</div>';
                    html += '</td>';
                    html += '<td>';
                    html += '<div class=barcode_text style="margin-left: 30px">';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                    html += '</table>';
                    html += '</div>';
                }
                $('#' + id).html(html);
                if (useQR) {
                    for (var i = 0; i < data.length; i++) {
                        $('#barcode_' + i + " .barcode_canvas").attr('style', 'padding: 0px; overflow: auto; width: 50px;');
                        $('#barcode_' + i + " .barcode_canvas").qrcode({
                            render: 'table',
                            width: 40,
                            height: 40,
                            fontcolor: '#000',
                            text: data[i][0]
                        });
                        if (nameLabel) {
                            $('#barcode_' + i + " .barcode_text").text(data[i][1]);
                        }
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        $('#barcode_' + i + " .barcode_canvas").attr('style', 'padding: 0px; overflow: auto; width: 90%;');
                        $('#barcode_' + i + " .barcode_canvas").barcode(data[i][0], "code128", {
                            barWidth: 2,
                            barHeight: 30
                        });
                        if (nameLabel) {
                            $('#barcode_' + i + " .barcode_text").text(data[i][1]);
                        }
                    }
                }
                var win = window.open();
                self.focus();
                win.document.open();
                win.document.write('<' + 'html' + '><' + 'head' + '><' + 'style' + '>');
                win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
                win.document.write('<' + '/' + 'style' + '><' + '/' + 'head' + '><' + 'body' + '>');
                win.document.write($('#' + id).html());
                win.document.write('<' + '/' + 'body' + '><' + '/' + 'html' + '>');
                win.document.close();
                win.print();
                win.close();
            }
        }
    }
    function setExcelUpload()
    {
    }
    function getExcelDownload()
    {
    }

</script>