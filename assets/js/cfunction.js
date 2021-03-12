/*
Detail Form 관련 함수
function

 */
function eventDetail()
{
    $("#detail_arrow_icon").on('click', function () {
        if($('#detail_form').hasClass('active'))
        {
            $('#detail_form').removeClass("active");
            $('#detail_arrow_icon i').removeClass("fa-arrow-right");
            $('#detail_arrow_icon i').addClass("fa-arrow-left");
        }
        else {
            $('#detail_form').addClass("active");
            $('#detail_arrow_icon i').removeClass("fa-arrow-left");
            $('#detail_arrow_icon i').addClass("fa-arrow-right");
        }
    });
}
/*
    테마관련 함수
 */
//상단바고정 함수
function changeFixTop(obj)
{
    if(obj == null) {
        if ($('#fix_header').is(":checked") == true) {
            $('#topnav').removeClass(" navbar-static-top");
            $('#topnav').addClass("navbar-fixed-top");
        }
        else {
            $('#topnav').removeClass("navbar-fixed-top");
            $('#topnav').addClass(" navbar-static-top");
        }
    }
    else
    {
        if(obj == true)
        {
            $('#topnav').removeClass(" navbar-static-top");
            $('#topnav').addClass("navbar-fixed-top");
        }
        else {
            $('#topnav').removeClass("navbar-fixed-top");
            $('#topnav').addClass(" navbar-static-top");
        }
    }
    Utility.rightbarTopPos();
}
//박스형태로보기 함수
function changeBoxLayout(obj)
{
    if(obj == null) {
        if ($('body').hasClass('infobar-active')) $('body').removeClass('infobar-active');
        if ($('#box_layout').is(":checked") == true) {
            $('body').addClass("layout-boxed");
            window.wasOffcanvas = ($('body').hasClass('infobar-offcanvas') || !$('body').hasClass('layout-boxed'));
            $('body').addClass('infobar-offcanvas infobar-overlay');

            $('.infobar-offcanvas .infobar-wrapper').css('transform', '');

            $('.layout-boxed .infobar-wrapper').css('display', '');

            if (($('body').hasClass('infobar-active')) || ($('body').hasClass('infobar-offcanvas'))) {
                $('.infobar-wrapper').show();
            }

            Utility.rightbarRightPos();
            Utility.rightbarTopPos();

            if (!($('body').hasClass('layout-boxed'))) {
                $('.infobar-wrapper').css('display','');
            }

            //switcher option changes
            $('input[name="demo-collapserightbar"]').bootstrapSwitch('state', false, true);
            $('#demo-boxes').addClass('hide');

            //remove bodybg when closed
            $('body:not(.layout-boxed)').css('background','');
        }
        else {
            $('body').removeClass("layout-boxed");
            window.wasOffcanvas = ($('body').hasClass('infobar-offcanvas') || !$('body').hasClass('layout-boxed'));
            $('body').addClass('infobar-offcanvas infobar-overlay');

            $('.infobar-offcanvas .infobar-wrapper').css('transform', '');

            $('.layout-boxed .infobar-wrapper').css('display', '');

            if (($('body').hasClass('infobar-active')) || ($('body').hasClass('infobar-offcanvas'))) {
                $('.infobar-wrapper').show();
            }

            Utility.rightbarRightPos();
            Utility.rightbarTopPos();

            if (!($('body').hasClass('layout-boxed'))) {
                $('.infobar-wrapper').css('display','');
            }

            //switcher option changes
            $('input[name="demo-collapserightbar"]').bootstrapSwitch('state', false, true);
            $('#demo-boxes').removeClass('hide');

            //remove bodybg when closed
            $('body:not(.layout-boxed)').css('background','');
        }
    }
    else
    {
        if ($('body').hasClass('infobar-active')) $('body').removeClass('infobar-active');
        if(obj == true)
        {
            $('body').addClass("layout-boxed");
            window.wasOffcanvas = ($('body').hasClass('infobar-offcanvas') || !$('body').hasClass('layout-boxed'));
            $('body').addClass('infobar-offcanvas infobar-overlay');

            $('.infobar-offcanvas .infobar-wrapper').css('transform', '');

            $('.layout-boxed .infobar-wrapper').css('display', '');

            if (($('body').hasClass('infobar-active')) || ($('body').hasClass('infobar-offcanvas'))) {
                $('.infobar-wrapper').show();
            }

            Utility.rightbarRightPos();
            Utility.rightbarTopPos();

            if (!($('body').hasClass('layout-boxed'))) {
                $('.infobar-wrapper').css('display','');
            }

            //switcher option changes
            $('input[name="demo-collapserightbar"]').bootstrapSwitch('state', false, true);
            $('#demo-boxes').addClass('hide');

            //remove bodybg when closed
            $('body:not(.layout-boxed)').css('background','');

        }
        else {
            $('body').removeClass("layout-boxed");
            window.wasOffcanvas = ($('body').hasClass('infobar-offcanvas') || !$('body').hasClass('layout-boxed'));
            $('body').addClass('infobar-offcanvas infobar-overlay');

            $('.infobar-offcanvas .infobar-wrapper').css('transform', '');

            $('.layout-boxed .infobar-wrapper').css('display', '');

            if (($('body').hasClass('infobar-active')) || ($('body').hasClass('infobar-offcanvas'))) {
                $('.infobar-wrapper').show();
            }

            Utility.rightbarRightPos();
            Utility.rightbarTopPos();

            if (!($('body').hasClass('layout-boxed'))) {
                $('.infobar-wrapper').css('display','');
            }

            //switcher option changes
            $('input[name="demo-collapserightbar"]').bootstrapSwitch('state', false, true);
            $('#demo-boxes').removeClass('hide');

            //remove bodybg when closed
            $('body:not(.layout-boxed)').css('background','');
        }
    }
    Utility.autocollapse();
}
//왼쪽메뉴 보이기
function changeLeftbarShow(obj)
{

    if(obj == null) {
        var menuCollapsed = localStorage.getItem('collapsed_menu');
        if ($('#collapse_leftbar').is(":checked") == true) {
            try {
                vFSLayout.toggle('west');
            } catch (e) {
                $('body').addClass('sidebar-collapsed');
            }
            localStorage.setItem('collapsed_menu', "true");
            setTimeout(function(){                  // wait 500ms before calling resize
                $(window).trigger('resize');        // so toggle happens faster instead of
            }, 500);
        }
        else {
            try {
                vFSLayout.toggle('west');
            } catch (e) {
                $('body').removeClass('sidebar-collapsed');
            }
            localStorage.setItem('collapsed_menu', "false");
            setTimeout(function(){                  // wait 500ms before calling resize
                $(window).trigger('resize');        // so toggle happens faster instead of
            }, 500);
        }
    }
    else
    {
        if(obj == true)
        {
            try {
                vFSLayout.toggle('west');
            } catch (e) {
                $('body').addClass('sidebar-collapsed');
            }
            localStorage.setItem('collapsed_menu', "true");
            setTimeout(function(){                  // wait 500ms before calling resize
                $(window).trigger('resize');        // so toggle happens faster instead of
            }, 500);
        }
        else {
            try {
                vFSLayout.toggle('west');
            } catch (e) {
                $('body').removeClass('sidebar-collapsed');
            }
            localStorage.setItem('collapsed_menu', "false");
            setTimeout(function(){                  // wait 500ms before calling resize
                $(window).trigger('resize');        // so toggle happens faster instead of
            }, 500);
        }
    }
}
//오른쪽메뉴 숨기기
function changeRightHide(obj)
{
    if(obj == null) {
        if ($('#collapse_rightbar').is(":checked") == true) {
            try {
                vFSLayout.toggle('east');
            } catch (e) {
                if ($('body').hasClass('infobar-overlay')) {
                    $('.infobar-wrapper').css('transform','');
                }

                $('body').removeClass('infobar-active');

                //in layout-boxed pages, toggle visibility instead of animation
                if ($('body').hasClass('layout-boxed')) {
                    Utility.rightbarRightPos();
                }
                Utility.rightbarTopPos();
            }
        }
        else {
            try {
                vFSLayout.toggle('east');
            } catch (e) {
                if ($('body').hasClass('infobar-overlay')) {
                    $('.infobar-wrapper').css('transform','');
                }

                $('body').addClass('infobar-active');

                //in layout-boxed pages, toggle visibility instead of animation
                if ($('body').hasClass('layout-boxed')) {
                    Utility.rightbarRightPos();
                }
                Utility.rightbarTopPos();
            }
        }
    }
    else
    {
        if(obj == true)
        {
            try {
                vFSLayout.toggle('east');
            } catch (e) {
                if ($('body').hasClass('infobar-overlay')) {
                    $('.infobar-wrapper').css('transform','');
                }

                $('body').removeClass('infobar-active');

                //in layout-boxed pages, toggle visibility instead of animation
                if ($('body').hasClass('layout-boxed')) {
                    Utility.rightbarRightPos();
                }
                Utility.rightbarTopPos();
            }
        }
        else {
            try {
                vFSLayout.toggle('east');
            } catch (e) {
                if ($('body').hasClass('infobar-overlay')) {
                    $('.infobar-wrapper').css('transform','');
                }

                $('body').addClass('infobar-active');

                //in layout-boxed pages, toggle visibility instead of animation
                if ($('body').hasClass('layout-boxed')) {
                    Utility.rightbarRightPos();
                }
                Utility.rightbarTopPos();
            }
        }
    }
}
//상단바 색상 변경 함수
function changeTopColor(color)
{
    var headerColors = "navbar-default navbar-inverse navbar-primary navbar-violet navbar-alizarin navbar-grape navbar-danger navbar-green navbar-indigo navbar-info navbar-midnightblue";

    if (color == 'default') {
        $('#topnav').removeClass(headerColors).addClass('navbar-default');
        localStorage.setItem('navbar-color', 'navbar-default');
    }
    else if (color == 'black') {
        $('#topnav').removeClass(headerColors).addClass('navbar-inverse');
        localStorage.setItem('navbar-color', 'navbar-inverse');
    }
    else if (color == 'primary') {
        $('#topnav').removeClass(headerColors).addClass('navbar-primary');
        localStorage.setItem('navbar-color', 'navbar-primary');
    }
    else if (color == 'grape') {
        $('#topnav').removeClass(headerColors).addClass('navbar-grape');
        localStorage.setItem('navbar-color', 'navbar-grape');
    }
    else if (color == "green") {
        $('#topnav').removeClass(headerColors).addClass('navbar-green');
        localStorage.setItem('navbar-color', 'navbar-green');
    }
    else if (color =="alizarin") {
        $('#topnav').removeClass(headerColors).addClass('navbar-alizarin');
        localStorage.setItem('navbar-color', 'navbar-alizarin');
    }
    else if (color == "danger") {
        $('#topnav').removeClass(headerColors).addClass('navbar-danger');
        localStorage.setItem('navbar-color', 'navbar-danger');
    }
    else if (color == "indigo") {
        $('#topnav').removeClass(headerColors).addClass('navbar-indigo');
        localStorage.setItem('navbar-color', 'navbar-indigo');
    }
    else if (color == "violet") {
        $('#topnav').removeClass(headerColors).addClass('navbar-violet');
        localStorage.setItem('navbar-color', 'navbar-violet');
    }
    else if (color == "info") {
        $('#topnav').removeClass(headerColors).addClass('navbar-info');
        localStorage.setItem('navbar-color', 'navbar-info');
    }
    else if (color == "midnightblue") {
        $('#topnav').removeClass(headerColors).addClass('navbar-midnightblue');
        localStorage.setItem('navbar-color', 'navbar-midnightblue');
    }
    return color;
}
//왼쪽메뉴 색상 변경 함수
function changeLeftMenuColor(color)
{
    var sidebarColors = "sidebar-default sidebar-inverse sidebar-violet sidebar-green sidebar-info sidebar-midnightblue sidebar-grape sidebar-primary sidebar-alizarin sidebar-indigo navbar-default navbar-inverse navbar-primary navbar-violet navbar-alizarin navbar-grape navbar-danger navbar-green navbar-indigo navbar-info navbar-midnightblue";

    if (color == "white") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-default');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-default');

        localStorage.setItem('sidebar-color',"default");
    }
    else if (color == "black") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-inverse');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-inverse');

        localStorage.setItem('sidebar-color',"inverse");
    }
    else if (color == "midnightblue") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-midnightblue');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-midnightblue');

        localStorage.setItem('sidebar-color',"midnightblue");
    }
    // else if (color == "grape") {
    //     $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-grape');
    //     $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-grape');
    //
    //     localStorage.setItem('sidebar-color',"grape");
    // }
    else if (color == "green") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-green');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-green');

        localStorage.setItem('sidebar-color',"green");
    }
    else if (color == "info") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-info');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-info');

        localStorage.setItem('sidebar-color',"info");
    }
    else if (color == "primary") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-primary');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-primary');

        localStorage.setItem('sidebar-color',"primary");
    }
    else if (color == "alizarin") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-alizarin');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-alizarin');

        localStorage.setItem('sidebar-color',"alizarin");
    }
    else if (color == "indigo") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-indigo');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-indigo');

        localStorage.setItem('sidebar-color',"indigo");
    }
    else if (color == "violet") {
        $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-violet');
        $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-violet');

        localStorage.setItem('sidebar-color',"violet");
    }
    // else if (color == "danger") {
    //     $('.static-sidebar-wrapper, .fixed-sidebar-wrapper').removeClass(sidebarColors).addClass('sidebar-danger');
    //     $('#wrapper>nav.navbar').removeClass(sidebarColors).addClass('navbar-danger');
    //
    //     localStorage.setItem('sidebar-color',"danger");
    // }
    return color;
}
function getUserTheme()
{
    var result = getAjax('/member/getUserInfo', 'post', {}).responseText;
    result = JSON.parse(result);
    result = result[0];
    if(result.fix_header == "true")
    {
        changeFixTop(true);
    }
    else
    {
        changeFixTop(false);
    }
    if(result.box_layout == "true")
    {
        changeBoxLayout(true);
    }
    else
    {
        changeBoxLayout(false);
    }
    if(result.collapse_leftbar == "true")
    {
        changeLeftbarShow(true);
    }
    else
    {
        changeLeftbarShow(false);
    }
    if(result.collapse_rightbar == "true")
    {
        changeRightHide(true);
    }
    else
    {
        changeRightHide(false);
    }
    changeTopColor(result.header_colors);
    changeLeftMenuColor(result.sidebar_colors);
}
/*
테마관련 함수 끝
 */
function getAjax(url, method, obj)
{
    return $.ajax({
        method: method,
        async: false,
        url: url,
        data :  obj,
        success: function (result) {
            //console.log("getAjax : " , result);
        },
        error: function (result) {
            console.log('Error:', result);
        }
    });
}

function getExcelAjax(url, method, obj)
{
    $.ajax({
        method: method,
        async: false,
        url: url,
        data :  obj,
        success: function (result) {
            var f = document.createElement('form');
            f.action=url;
            f.method='POST';
            f.target='_blank';
            $.each(obj.search[0], function(key, value)
            {
                var i = document.createElement('input');
                i.type = 'hidden';
                i.name = key;
                i.value = value;
                f.appendChild(i);
            });
            document.body.appendChild(f);
            f.submit();
        },
        error: function (result) {
            console.log('Error:', result);
        }
    });
}
// jquery extend function

function getFileAjax(url, method, obj)
{
    return $.ajax({
        async: false,
        url: url,
        data :  obj,
        type: method,
        processData:false,
        contentType:false,
        success: function (result) {
        },
        error: function (result) {
            console.log('Error:', result);
        }
    });
}
function setPostAjax(url, ids)
{
    var formData = new FormData();
    for(var i=0;i<ids.length;i++)
    {
        if($('#' + ids[i].id)[0].localName == 'input') {
            if ($('#' + ids[i].id).attr('type') == 'hidden') {
                formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).val());
            }
            else if ($('#' + ids[i].id).attr('type') == 'text') {
                formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).val());
            }
            else if ($('#' + ids[i].id).attr('type') == 'password') {
                formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).val());
            }
            else if ($('#' + ids[i].id).attr('type') == 'checkbox') {
                formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).is(":checked").toString());
            }
            else if ($('#' + ids[i].id).attr('type') == 'radio') {
                formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).is(":checked").toString());
            }
            else if ($('#' + ids[i].id).attr('type') == 'file') {
                if($('input[id="' + ids[i].id + '"]').val() != '') {
                    formData.append(ids[i].id.replaceAll('detail_form_', ''), $('input[id="' + ids[i].id + '"]')[0].files[0]);
                }
            }
        }
        else if($('#' + ids[i].id)[0].localName == 'select') {
            formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id + ' option:selected').val());
        }
        else if($('#' + ids[i].id)[0].localName == 'textarea') {
            formData.append(ids[i].id.replaceAll('detail_form_', ''), $('#' + ids[i].id).val());
        }

    }
    return $.ajax({
        async: false,
        url: url,
        data :  formData,
        type: 'post',
        processData:false,
        contentType:false,
        success: function (result) {
        },
        error: function (result) {
            console.log('Error:', result);
        }
    });
}
function getSearch(search_form_id)
{
    if(search_form_id == null) {
        var ids = $("#search_form [id^='search_']");
        var search = "{";
        for (var i = 0; i < ids.length; i++) {
            search += '"' + ids[i].id.substring(7) + '":"' + $('#' + ids[i].id).val() + '"';
            if (i < ids.length - 1) {
                search += ",";
            }
        }
        search += "}";
        search = JSON.parse(search);
        return search;
    }
    else
    {
        var ids = $("#" + search_form_id + " [id^='search_']");
        var search = "{";
        for (var i = 0; i < ids.length; i++) {
            search += '"' + ids[i].id.substring(7) + '":"' + $('#' + ids[i].id).val() + '"';
            if (i < ids.length - 1) {
                search += ",";
            }
        }
        search += "}";
        search = JSON.parse(search);
        return search;
    }
}

function startSearch(key)
{
    if(key.keyCode == 13)
    {
        getList();
    }
}

function commapoint_format(data, type, data_type) {
    var str = '';
    var str1 = '';
    var str2 = '';
    var minus = '';
    var point = '';
    //데이터 타입에 따라 데이터 스트링으로 변환
    if (jQuery.type(data) == 'object') {
        str = (data.value).toString();
    }
    else if (jQuery.type(data) == 'string') {
        str = data;
    }
    else if (jQuery.type(data) == 'text') {
        str = data.value.toString();
    }

    while (true) {
        if (str.indexOf(' ') > -1) {
            str = str.replace(' ', "");
        }
        else {
            if (str.substring(0, 1) == '-') {
                minus = '-';
                str = str.substring(1, str.length);
            }
            else {
                if (str.length >= 2) {
                    if (str.substring(0, 2) == '00') {
                        str = '0' + str.substring(2, str.length);
                    }
                    else if (str.substring(0, 2) != '0.' && str.substring(0, 1) == '0') {
                        str = str.substring(1, str.length);
                        str1 = str;
                    }
                    else if (str.indexOf('.') > -1) {
                        point = '.';
                        str1 = str.substring(0, str.indexOf('.'));
                        str2 = str.substring(str.indexOf('.'), str.length);
                        str2 = str2.replace(/[^0-9]/gi, "");
                        break;
                    }
                    else {
                        str1 = str.replace(/[^0-9]/gi, "");
                        break;
                    }
                }
                else {
                    str1 = str.replace(/[^0-9.]/gi, "");
                    str = str.replace(/[^0-9.]/gi, "");
                    break;
                }
            }
        }
    }
    if (type == 0) {
        str1 = str1.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (data_type == "int") {
            str = str1;
        }
        else if (data_type == 'float') {
            str1 = str1 ? str1 : '0';
            str = str1 + point + str2;
        }
        else if (data_type.indexOf('float') >= 0) {
            var cut_number = parseInt(data_type.substring(5, 6));
            str1 = str1 ? str1 : '0';
            if (str2.length > cut_number) {
                str2 = str2.substring(0, cut_number);
            }
            str = str1 + point + str2;
        }
    }
    else if (type == 1) {
        str1 = str1.replace(/[^0-9]/gi, "");
        if (data_type == "int") {
            str = str1;
        }
        else if (data_type == 'float') {
            str1 = str1 ? str1 : '0';
            str = str1 + point + str2;
        }

    }
    if (str == '') {
        str = 0;
    }
    if (jQuery.type(data) == 'object') {
        data.value = minus + str;
    }
    else {
        return minus + str;
    }
}

function getCodeList(master_code,option)
{
    if(IsNullorEmpty(option))
    {
        option = 'html';
    }
    var data_list = getAjax('/code/get_code', 'post', {master_code : master_code,option : option}).responseText;
    if(option == 'JSON')
    {
        data_list = JSON.parse(data_list);
    }
    else if(option == 'html_default')
    {
        data_list = '<option value="" selected>[전체]</option>' + data_list;
    }
    else if(option == 'html')
    {
        data_list = data_list;
    }
    return data_list;
}

function IsNullorEmpty(value) {
    return (!value || value == undefined || value == "" || value.length == 0 || value == "null" || value == null);
}

function getNowDateTime(date, time, milli)
{
    var today = new Date();

    var year = today.getFullYear(); // 년도
    var month = today.getMonth() + 1;  // 월
    month = month<10?'0' + month : month;
    var date = today.getDate();  // 날짜
    date = date<10?'0' + date : date;
    var day = today.getDay();  // 요일
    day = day<10?'0' + day : day;

    var hours = today.getHours(); // 시
    hours = hours<10?'0' + hours : hours;
    var minutes = today.getMinutes();  // 분
    minutes = minutes<10?'0' + minutes : minutes;
    var seconds = today.getSeconds();  // 초
    seconds = seconds<10?'0' + seconds : seconds;
    var milliseconds = today.getMilliseconds(); // 밀리초
    var return_date = '';
    if(date)
    {
        return_date += year;
        return_date += '-' + month;
        return_date += '-' + date;
    }
    if(time)
    {
        if(return_date != '')
        {
            return_date += ' ';
        }
        return_date += hours;
        return_date += ':' + minutes;
        return_date += ':' + seconds;
    }
    if(milli)
    {
        if(return_date != '')
        {
            return_date += '.';
        }
        return_date += milliseconds;
    }
    return return_date;
}

function showZipCode(zipcode_id, main_addr_id)
{
    new daum.Postcode({
        oncomplete: function(data) {

            console.log(data);
            $('#' + main_addr_id).val(data.address);
            $('#' + zipcode_id).val(data.zonecode);
        }
    }).open();
}

function checkDuplicate(url, main_form_id){
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
            alert($('#' + label_id).text() + '이(가) 중복되었습니다.');
            $('#' + id).focus();
            return_data = false;
            break;
        }
    }
    return return_data;
}
function checkRequired(main_form_id)
{
    var ids = $('#' + main_form_id + ' .required');
    var return_data=true;
    for(var i=0;i<ids.length;i++)
    {
        var id = ids[i].id;
        var label_id = id.replace('detail_form_','label_');
        if(IsNullorEmpty($('#' + id).val()))
        {
            alert($('#' + label_id).text() + '은(는) 필수 값 입니다.');
            $('#' + id).focus();
            return_data = false;
            break;
        }
    }
    return return_data;

}
function setDatepicker()
{
    $('.facnroll-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
}