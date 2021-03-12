<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
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
    }
    var menu_info;

    function getMenuInfo()
    {
        menu_info = getAjax('/monitoring/getMenuInfo', 'post', {}).responseText;
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
        $('#list_title').text(menu_info.title + "");
    }
//까지 기본설정
    function getList()
    {
        var result = getAjax('/monitoring/getList', 'post', {}).responseText;
        result = JSON.parse(result);
        console.log(result);
        $('#img1').html('<img src="/' + result[0][0].result_path + result[0][0].result_save_name + '" width="50%">');
        $('#img2').html('<img src="/' + result[1][0].result_path + result[1][0].result_save_name + '" width="50%">');
        $('#result1').text(result[0][0].result_data);
        $('#result2').text(result[1][0].result_data);
        $('#reg_dttm1').text(result[0][0].reg_dttm);
        $('#reg_dttm2').text(result[1][0].reg_dttm);
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: false,

            title:{
                text:"분류 인식통계"
            },
            axisX:{
                interval: 1
            },
            axisY2:{
                interlacedColor: "rgba(1,77,101,.2)",
                gridColor: "rgba(1,77,101,.1)",
                // title: "Number of Companies"
            },
            data: [{
                type: "bar",
                // name: "companies",
                axisYType: "secondary",
                // color: "#014D65",
                dataPoints: [
                    { y: parseInt(result[4][0].cnt), label: "Total" },
                    { y: parseInt(result[4][0].cnt-result[2][0].cnt), label: "OK" },
                    { y: parseInt(result[2][0].cnt), label: "Miss" },
                ]
            }]
        });
        chart1.render();
        var chart2 = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: false,

            title:{
                text:"OCR 인식통계"
            },
            axisX:{
                interval: 1
            },
            axisY2:{
                interlacedColor: "rgba(1,77,101,.2)",
                gridColor: "rgba(1,77,101,.1)",
                // title: "Number of Companies"
            },
            data: [{
                type: "bar",
                // name: "companies",
                axisYType: "secondary",
                // color: "#014D65",
                dataPoints: [
                    { y: parseInt(result[5][0].cnt), label: "Total" },
                    { y: parseInt(result[5][0].cnt-result[3][0].cnt), label: "OK" },
                    { y: parseInt(result[3][0].cnt), label: "Miss" },
                ]
            }]
        });
        chart2.render();
        setTimeout(function(){
            getList();
        }, 1000);
    }
</script>
