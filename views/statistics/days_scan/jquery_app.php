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
        $('#search_end_dttm').addClass('facnroll-datepicker');
        var week = "<?php echo date('Y-m-d',strtotime('-1 week')); ?>";
        var date_arr = week.split('-');
        if(date_arr[0]+date_arr[1] == "<?php echo date("Ym") ?>"){
            $('#search_start_dttm').val('<?php echo date('Y-m-d',strtotime('-1 week')); ?>');
        }else{
            $('#search_start_dttm').val('<?php echo date("Y-m")."-01"; ?>');
        }
        $('#search_end_dttm').val('<?php echo date("Y-m-d"); ?>');
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
    var bar_data = [];
    var aver_data = [];
    function getList(){
        var search = getSearch();
        var result = getAjax('/days_scan/getData', 'post', {search: search}).responseText;
        result = JSON.parse(result);
        bar_data = [];
        aver_data = [];
        if(result.length > 0){
            for(var i=0; i<result.length; i++){
                bar_data.push({x : parseInt(result[i]['scan_date']), y : parseInt(result[i]['count'])});
                aver_data.push({x : parseInt(result[i]['scan_date']), y : parseInt(result[0]['aver'])});
            }
            create_chart();
        }else{
            $("#chartContainer").text("No Data.");
        }
    }
    function create_chart()
    {
        var chart5 = new CanvasJS.Chart("chartContainer", {
            colorSet:"chartColor",
            animationEnabled: true,
            theme: "light",
            // backgroundColor:"#33373c",
            axisY: {
                valueFormatString: "#,##0.##",
                labelFontColor : "#000",
                labelFontSize: 10,
            },
            axisX: {
                labelFontColor : "#000",
                valueFormatString : "##일",
                interval: 1,
                intervalType : 'day',
                labelFontSize: 10,
            },
            dataPointMaxWidth: 20,
            data: [
            {
                type: "column",
                markerSize: 10,
                toolTipContent: "<b>{x}:</b> {y}",
                yValueFormatString: "#,##0.##",
                xValueFormatString: "##일",
                dataPoints: bar_data
            },
            {
                type: "line",
                markerSize: 10,
                toolTipContent: "<b>{x}:</b> {y}",
                yValueFormatString: "#,##0.##",
                xValueFormatString: "##일",
                dataPoints: bar_data
            },
            {
                type: "line",
                markerSize: 0,
                toolTipContent: "<b>평균값:</b> {y}",
                yValueFormatString: "#,##0.##",
                xValueFormatString: "##일",
                dataPoints: aver_data
            }
        ]
        });
        chart5.render();
    }

</script>

