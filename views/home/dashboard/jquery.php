<script>


    $(document).ready(function() {
        Init();
    });
    function Init()
    {
        getUserTheme();
        getMenuInfo();
        setMenu();
    }
    var menu_info;
    function getMenuInfo()
    {
        menu_info = getAjax('/dashboard/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
        console.log(menu_info);
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
    function getList() {
    }
    function showDetail(idx)
    {
    }
    function clearForm(formid)
    {
    }
    function closeDetail()
    {
    }
    function newDetail()
    {
    }
</script>