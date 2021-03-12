<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        Init();
        getList();

    });

    function Init() {
        getUserTheme();
        getMenuInfo();
        setMenu();
        // setMainGrid();
        setDatepicker();
        // eventDetail();


        // resetDetail();
        // $("#pop_item").on('shown.bs.modal', function (e) {
        //     getPopupItemList();
        // });
        // getCompanyList();
        // getOrderStatus();

    }

    var menu_info;
   

    var main_grid;
    

    var main_grid_width = 0;
    var delete_list = [];


    //메인그리드
    function getMenuInfo() {
        menu_info = getAjax('/device_scan/getMenuInfo', 'post', {}).responseText;
        menu_info = JSON.parse(menu_info);
    }
    function setMenu()
    {
        $('#menu_title').text("기기별 스캔 통계");
        var sm_title_html = "<li class=\"\"><a href=\"\">Home</a></li>";
        for(var i=menu_info.menu_path.length-1;i>=1;i--)
        {
            sm_title_html += '<li class=""><a href="">'+menu_info.menu_path[i]+'</a></li>';
        }
        sm_title_html += '<li class="active"><a href="">'+menu_info.menu_path[0]+'</a></li>';
        $('#menu_sm_title').html(sm_title_html);
        $('#btn_collection').html(menu_info.btn_html);
        // $('#list_title').text("대분류 리스트");
        // $('#detail_title').text("소분류 리스트");
        $('#search_form').html(menu_info.search_html);
        $('#search_end_dttm').css({display:'none'});
        $('label[for="search_end_dttm"').text("");
        $('#search_start_dttm').addClass('facnroll-datepicker');
        $('#search_start_dttm').val('<?php echo date("Y-m-d"); ?>');
    }
    var chart_data = [];
    function getList(){
        var search = getSearch();
        var result = getAjax('/device_scan/getData', 'post', {search: search}).responseText;
        result = JSON.parse(result);
        if(result.length > 0){
            chart_data = [];
            for(var i=0; i<result.length; i++){
                chart_data.push({y:parseInt(result[i]['count']),label:result[i]['device_mac_addr']});
            }
            create_chart();
        }else{
            $("#chartContainer").text("No Data.");
        }
    }
    function create_chart()
    {
        var chart5 = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            colorSet:"chartColor",
            theme: "light",
            axisX:{
                labelFontSize: 15,
            },
            axisY: {
                minimum: 0,
                interval: 5,
                labelFontSize: 15,
                valueFormatString:  "#,##0.##"  
            },
            data: [{
                type: "column",
                color : "#6699FF",
                toolTipContent: "<b>{label}:</b> {y}",
                dataPoints: chart_data,
                }]
        });
        chart5.render();
    }

</script>

