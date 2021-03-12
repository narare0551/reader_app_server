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
        setMainGrid();

    }
    var menu_info;
    var main_grid;
    var delete_list=[];
    function getMenuInfo()
    {
        menu_info = getAjax('/setup_theme/getMenuInfo', 'post', {}).responseText;
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
        $('#list_title').text(menu_info.title + " List");
        $('#detail_title').text(menu_info.title + " 상세정보");
        $('#search_form').html(menu_info.search_html);
    }
    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,false,false,false);
        main_grid.setColumns(menu_info.list_columns);
        main_grid.eventGrid('click', on_click);
    }
    var on_click = function(event){
        var list = main_grid.getSelection();
        if(list.length > 0) {
            var data = main_grid.getRowData(list[0]);
            showDetail(data.idx);
        }
        else
        {
            newDetail();
        }
    }
    function getList()
    {
        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/setup_theme/getList', 'post', {search:search}).responseText;
        if(result != '[]') {
            result = JSON.parse(result);
            main_grid.setAllData(result);
            main_grid.lock(false);
        }
        else
        {
            main_grid.lock(false);
        }
    }
    function showDetail(idx)
    {
        newDetail();
        openDetail();
        var result = getAjax('/setup_theme/showDetail', 'post', {idx:idx}).responseText;
        if(result != '[]')
        {
            result = JSON.parse(result);
            $.each(result[0], function(key,value)
            {
                if(key == 'fix_header' || key == 'box_layout' || key == 'collapse_leftbar' || key == 'collapse_rightbar')
                {
                    if(value == 'true')
                    {
                        $('#detail_form #' + key).prop('checked', true);
                        $($('#detail_form #' + key)[0].parentNode.parentNode).removeClass('bootstrap-switch-off');
                        $($('#detail_form #' + key)[0].parentNode.parentNode).addClass('bootstrap-switch-on');

                    }
                    else
                    {
                        $('#detail_form #' + key).prop('checked', false);
                        $($('#detail_form #' + key)[0].parentNode.parentNode).removeClass('bootstrap-switch-on');
                        $($('#detail_form #' + key)[0].parentNode.parentNode).addClass('bootstrap-switch-off');
                    }
                }
                else if(key == 'header_colors' || key == 'sidebar_colors' )
                {
                    var objs = $('#detail_form #' + key + ' span');
                    for(var i=0;i<objs.length;i++)
                    {
                        if(objs[i].attributes[0].value == 'panel-' + value)
                        {
                            select_color(objs[i]);
                            break;
                        }
                    }
                }
                else {
                    $('#detail_form #' + key).val(value);
                }
            });
        }
    }
    function select_color(obj)
    {
        $('#' + obj.parentNode.parentNode.id + ' span').attr('style', 'border:0px;');
        $(obj).attr('style', 'border:2px #ff0000 solid;');
    }
    function openDetail()
    {
        $('#main_detail').show();
        $('#main_list').removeClass('col-lg-12');
        $('#main_list').addClass('col-lg-7');
    }
    function saveForm()
    {
        main_grid.save();
        var result = getAjax('/setup_theme/save', 'post', {data : main_grid.getRowData(), del_data : delete_list}).responseText;
        result = JSON.parse(result);
        if(result.result == true)
        {
            alert('저장 되었습니다.');
            delete_list=[];
            getList();
        }
        else
        {
            alert('저장에 실패 하였습니다.\n시스템 관리자에게 문의하여 주세요');
        }
    }
    function closeDetail()
    {
        $('#main_detail').hide();
        $('#main_list').removeClass('col-lg-7');
        $('#main_list').addClass('col-lg-12');
    }
    function newDetail()
    {
        $('#detail_form #idx').val('');
        $('#detail_form #user_id').val('');
        $('#detail_form #fix_header').prop('checked', true);
        $($('#detail_form #fix_header')[0].parentNode.parentNode).removeClass('bootstrap-switch-off');
        $($('#detail_form #fix_header')[0].parentNode.parentNode).addClass('bootstrap-switch-on');
        $('#detail_form #box_layout').prop('checked', false);
        $($('#detail_form #box_layout')[0].parentNode.parentNode).removeClass('bootstrap-switch-on');
        $($('#detail_form #box_layout')[0].parentNode.parentNode).addClass('bootstrap-switch-off');
        $('#detail_form #collapse_leftbar').prop('checked', false);
        $($('#detail_form #collapse_leftbar')[0].parentNode.parentNode).removeClass('bootstrap-switch-on');
        $($('#detail_form #collapse_leftbar')[0].parentNode.parentNode).addClass('bootstrap-switch-off');
        $('#detail_form #collapse_rightbar').prop('checked', true);
        $($('#detail_form #collapse_rightbar')[0].parentNode.parentNode).removeClass('bootstrap-switch-off');
        $($('#detail_form #collapse_rightbar')[0].parentNode.parentNode).addClass('bootstrap-switch-on');
        $('#detail_form #header_colors').val('');
        $('#detail_form #sidebar_colors').val('');
        $('#detail_form #header_colors span')[11].click();
        $('#detail_form #sidebar_colors span')[9].click();
    }
</script>