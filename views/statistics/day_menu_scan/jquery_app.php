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
    var menu_arr = [];
    var chart_data = [];
    function getList(){
        var search = getSearch();
        var result = getAjax('/day_menu_scan/getData', 'post', {search: search}).responseText;
        result = JSON.parse(result);
        if(result.length > 0){
            menu_arr = [];
            chart_data = [];
            for(var i=0; i<result[0]['label'].length; i++){
                menu_arr.push(result[0]['label'][i]['menu_name']);
            }
            var date  = $("#search_start_dttm").val();
            var date_a = date.split('-');
            chart_data.push({x : new Date(date_a[0],date_a[1],date_a[2],00,00,01), y :0, markerSize : 1});
            for(var i=0; i<result.length; i++){
                var date_arr = result[i]['date_time'].split(',');
                for(var j=0; j<menu_arr.length; j++){
                    if(menu_arr[j] == result[i]['menu_name']){
                        var y_value = j+1;
                    }
                }
                chart_data.push({x : new Date(date_arr[0],date_arr[1],date_arr[2],date_arr[3],date_arr[4],date_arr[5]), y : y_value, barcode:result[i]['barcode'],device:result[i]['device_mac_addr']});
            }
            chart_data.push({x : new Date(date_a[0],date_a[1],date_a[2],23,59,59), y : 0, markerSize : 1});
            create_chart();
        }else{
            $("#chartContainer").text("No Data.");
        }
    }
    function create_chart()
    {
        var chart5 = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            zoomEnabled: true,
            colorSet:"chartColor",
            axisX: {
                intervalType: "hour" ,
                valueFormatString: "HH:mm" ,
                labelFontSize: 10,
            },
            axisY: {
                interval: 1,
                minimun:0,
                labelFormatter: function(e){
                    var label="";
                    for(var i = 0; i<menu_arr.length; i++){
                        if(e.value == i+1){
                            label = menu_arr[i];
                        }
                    }
                    return label;
                },
                labelFontSize: 10,
            },
            legend: {
                cursor: "pointer",
            },
            data: [{
                type: "scatter",
                markerSize: 15,
                markerColor: "rgba(66,66,66,0.5)",
                toolTipContent: "<b>디바이스MAC:</b> {device}<br/><b>바코드:</b> {barcode}",
                dataPoints: chart_data,
                }]
        });
        chart5.render();
    }

</script>

