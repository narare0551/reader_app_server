<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        Init();
        getList();

    });

    function Init() {
        // getUserTheme();
        // getMenuInfo();
        // setMenu();
        // // setMainGrid();
        setDatepicker();
        $('#search_start_dttm').addClass('facnroll-datepicker');
        
       
        $('#search_start_dttm').val('<?php echo date("Y-m-d"); ?>');
        // eventDetail();


        // resetDetail();
        // $("#pop_item").on('shown.bs.modal', function (e) {
        //     getPopupItemList();
        // });
        // getCompanyList();
        // getOrderStatus();

    }

    // var menu_info;
   

    // var main_grid;
    

    // var main_grid_width = 0;
    // var delete_list = [];


    // //메인그리드
    // function getMenuInfo() {
    //     menu_info = getAjax('/days_scan/getMenuInfo', 'post', {}).responseText;
    //     menu_info = JSON.parse(menu_info);
    // }
    // function setMenu()
    // {
    //     $('#menu_title').text("기간별 스캔 통계");
    //     var sm_title_html = "<li class=\"\"><a href=\"\">Home</a></li>";
    //     for(var i=menu_info.menu_path.length-1;i>=1;i--)
    //     {
    //         sm_title_html += '<li class=""><a href="">'+menu_info.menu_path[i]+'</a></li>';
    //     }
    //     sm_title_html += '<li class="active"><a href="">'+menu_info.menu_path[0]+'</a></li>';
    //     $('#menu_sm_title').html(sm_title_html);
    //     $('#btn_collection').html(menu_info.btn_html);
    //     // $('#list_title').text("대분류 리스트");
    //     // $('#detail_title').text("소분류 리스트");
    //     $('#search_form').html(menu_info.search_html);
    //     $('#search_start_dttm').addClass('facnroll-datepicker');
    //     $('#search_end_dttm').addClass('facnroll-datepicker');
    //     $('#search_start_dttm').val('<?php echo date("Y-m")."-01"; ?>');
    //     $('#search_end_dttm').val('<?php echo date("Y-m-d"); ?>');
    // }
    var data = [];
    var chart_data = [];
    function getList(){
        var search = getSearch();
        var result = getAjax('/device_battery/getData', 'post', {search: search}).responseText;
        result = JSON.parse(result);
        if(result.length > 0){
            data = [];
            for(var j=0; j<result[0]['label'].length; j++){
                chart_data =[];
                for(var i=0; i<result.length; i++){
                    if(result[0]['label'][j] == result[i]['device_mac_addr']){
                        chart_data.push({y : parseInt(result[i]['battery']), x: parseInt(result[i]['time_data']),device : result[i]['device_mac_addr']});
                    }
                }
                data.push({type:"line",markerSize:0,dataPoints:chart_data,yValueFormatString: "#,##0.##",xValueFormatString: "##시##분",
                toolTipContent: "<b>디바이스MAC:</b> {device}<br/><b>스캔시간:</b>{x}<br/><b>배터리 잔량:</b>{y}%",name: "{device}",
		        showInLegend: true,});
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
                labelFontSize: 10,
                valueFormatString : "##:##",
                interval: 100,
                maximum: 2400,
                minimum: 100
            },
            axisY: {
                minimum: 0,
                maximum:100,
                interval: 10,
                labelFontSize: 10,
                valueFormatString:  "#,##0.##",
                suffix:"%"  
            },
            data: data
        });
        chart5.render();
    }

</script>

