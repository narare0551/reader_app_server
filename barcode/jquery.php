<script>
   $(document).ready(function(){
    $("#print").on('click',function(){
        set_barcode();
    });
   });
   

    function set_barcode(){
        var qty = $("#print_qty").val();
        var html = "";
        for(var i = 0; i < qty; i++){
            html+= '<table style="margin:0px;padding:0px;width:362.834px;height:94.488px;">';
            html+= ' <tr>';
            html+= '<td style="text-align:center;width:50%;height:94.488px;">';
            html+= '<br>';
            html+= '<div>';
            html+= '    <div class="barcode"></div><br>';
            html+= '    <span style="font-size:8pt;">8809750000009&nbsp;&nbsp;&nbsp;&nbsp;<br>';
            html+= '    2020.12&nbsp;&nbsp;&nbsp;&nbsp;</span>';
            html+= '</div>';
            html+= '</td>';
            html+= '<td style="text-align:center;width:50%;height:94.488px;">';
            html+= '<br>';
            html+= '<div>';
            html+= '    <div class="barcode"></div><br>';
            html+= '    <span style="font-size:8pt;">8809750000009&nbsp;&nbsp;&nbsp;&nbsp;<br>';
            html+= '    2020.12&nbsp;&nbsp;&nbsp;&nbsp;</span>';
            html+= '</div>';
            html+= '</td>';
            html+= '</tr>';
            html+= '</table>';
            html+= '<table style="margin:0px;padding:0px;width:362.834px;height:94.488px;">';
            html+= '<tr>';
            html+= '    <td style="text-align:center;width:50%;height:94.488px;">';
            html+= '<br><span style="font-size:14pt;font-weight:bold;">밴드형&nbsp;&nbsp;&nbsp;&nbsp;</span>';
            html+= ' </td>';
            html+= '<td style="text-align:center;width:50%;height:94.488px;">';
            html+= '    <br><span style="font-size:14pt;font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;밴드형</span>';
            html+= '</td>';
            html+= '</tr>';
            html+= '</table>';
        }
        $("#print_data").html(html);
        create_barcode();
    }

    function create_barcode(){
        $(".barcode").each(function(i){
            $(".barcode").barcode("8809750000009","ean13",{barWidth:1,barHeight:15,fontSize:0});
        });
    }
</script>
