<?php
$now_path = '/views/statistics/day_menu_scan/';
?>
<style>
    .canvasjs-chart-credit{display:none;}
</style>
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/header.php'); ?>
<body class="infobar-offcanvas">
<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper pb0">
            <div class="static-content">
                <div class="page-content">
                    <div class="row" style="background-color: #f5f5f5;margin-bottom:2px;">
                        <div class="col-md-12">
                            <div class="panel panel-midnightblue mb0" style="border-color:#cccccc;">
                                <div class="panel-body p0" style="inline-height:42px;margin:0px;">
                                    <div action="" class="form-horizontal row-border" style="margin-top:3px" id="search_form" onkeydown="return startSearch(event);">     
                                        <label for="search_start_dttm"  style="float: left; line-height:25px; margin-right:5px" >일자</label>               
                                        <input type="text" class=" facnroll-datepicker" style="margin-right:5px" id="search_start_dttm" placeholder="일자">    
                                        
                                        <!-- <label for="search_end_dttm"  style="float: left; line-height:25px; margin-right:5px">종료일자</label>        
                                        <input type="text" class=" facnroll-datepicker" id="search_end_dttm" placeholder="종료일자">     -->
                                        
                                        <a href="javascript:getList()" id="btn_search" class="btn-sm" style="background-color: #37474f;color:#ffffff;">검색</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-->
                    <div class="row">
                        <div class="col-lg-12" id="main_list">
                            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'list_app.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--footer -->
            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/footer.php'); ?>
        </div>
    </div>
</div>

<!-- Load site level scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/load_js.php'); ?>
<!-- End loading page level scripts-->
<!-- Load Custom scripts -->

<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'jquery_app.php'); ?>

</body>
</html>