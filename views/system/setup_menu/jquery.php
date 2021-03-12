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
    var main_grid_width = 0;
    var delete_list=[];

    function getMenuInfo()
    {
        menu_info = getAjax('/setup_menu/getMenuInfo', 'post', {}).responseText;
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
        $('#search_form').html(menu_info.search_html);
    }
    function setMainGrid()
    {
        main_grid = new FNRGrid();
        main_grid.setGrid('grid', 28, '', false,false,true,true,false,false);
        main_grid_width = main_grid.setColumns(menu_info.list_columns);
        main_grid.eventGrid('change', changefunction);
    }
    var changefunction = function(event){
        if(event.column == 7) {
            var change_data = main_grid.getRowData(event.recid);
            console.log(change_data);
            change_data.menu_icon = event.value_new;
            change_data.menu_icon_view = '<i class="fa ' + event.value_new + '"></i>';
            main_grid.setRowData(event.recid, change_data);
        }
    }
    function addRow()
    {
        var default_data = {
            menu_code: "",
            menu_description: "",
            menu_icon: "fa-glass",
            menu_icon_view: '<i class="fa fa-glass"></i>',
            menu_lv: "9",
            menu_name: "",
            menu_url: "",
            mod_dttm: getNowDateTime(true,true),
            mod_user_id: "",
            parent_menu_code: "",
            reg_dttm: getNowDateTime(true,true),
            reg_user_id: "",
            seq: "",
            use_yn: true,
            recid:'',
            idx:''
        };
        main_grid.addRow(default_data);
    }
    function removeRow()
    {
        var delete_data = main_grid.removeRow();
        for(var i=0;i<delete_data.length;i++)
        {
            if(!IsNullorEmpty(delete_data[i].idx))
            {
                delete_list.push(delete_data[i]);
            }
        }
    }
    function getList()
    {
        main_grid.lock(true, 'Loading...');
        var search = getSearch();
        var result = getAjax('/setup_menu/getList', 'post', {search:search}).responseText;
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
    }
    function openDetail()
    {

    }
    function saveForm()
    {
        main_grid.save();
        var result = getAjax('/setup_menu/save', 'post', {data : main_grid.getRowData(), del_data : delete_list}).responseText;
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

    }
    function newDetail()
    {
        addRow();
    }
</script>