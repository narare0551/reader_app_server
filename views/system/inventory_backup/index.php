<?php
$now_path = '/views/system/inventory/';
?>
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/header.php'); ?>
<body class="infobar-offcanvas">

<!--top menu-->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/top_menu.php'); ?>
<div id="wrapper">
    <div id="layout-static">
        <!--left menu-->
        <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/left_menu.php'); ?>
        <div class="static-content-wrapper pb0">
            <div class="static-content">
                <div class="page-content">
                    <div class="row" style="background-color: #f5f5f5; margin-bottom:2px;">
<!--                        <div class="col-md-4">-->
<!--                            <ol class="breadcrumb" style="border:0px !important;background-color: #f5f5f5;">-->
<!--                                <li class=""><a href="">Home</a></li>-->
<!--                                <li class=""><a href="">Test</a></li>-->
<!--                                <li class="active"><a href="" id="menu_sm_title"></a></li>-->
<!--                            </ol>-->
<!--                            <div class="page-heading mb0" style="padding-bottom: 12px;">-->
<!--                                <h1 id="menu_title"></h1>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-md-4" style="height:65px;">
                            <div class="page-heading m0 p0 pl1">
                                <ol class="breadcrumb" id="menu_sm_title" style="border:0px !important;background-color: #f5f5f5;">
<!--                                    <li class=""><a href="">Home</a></li>-->
<!--                                    <li class=""><a href="">Test</a></li>-->
<!--                                    <li class="active"><a href="" id="menu_sm_title"></a></li>-->
                                </ol>
                                <h1 id="menu_title" style="padding-left:10px;margin-bottom:5px;"></h1>
                            </div>
                        </div>
                        <div class="col-md-8" style="height:65px;padding-top:30px;">
                            <div class="text-right" style="" id="btn_collection">
<!--                                <a href="javascript:getList()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">??????</a><a href="javascript:addRow();" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">??????</a><a href="javascript:saveForm()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">??????</a><a href="javascript:removeRow();" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">??????</a><a href="javascript:location.reload();" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">????????????</a>-->
                            </div>
                        </div>
                        <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'search.php'); ?>
                    </div>
                    <!-- content-->
                    <div class="row">
                        <div class="col-lg-12" id="main_list">
                            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'list.php'); ?>

                        </div>

<!--                        <div class="col-lg-6" id="main_detail" style="display: none">-->
                            <?php //get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'detail.php'); ?>
<!--                        </div>-->

                    </div>
                </div>
            </div>
            <!--footer -->
            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/footer.php'); ?>
        </div>
    </div>
</div>


<!--right menu-->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/right_menu.php'); ?>


<!-- Switcher -->
<?php //get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/option_menu.php'); ?>
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'detail.php'); ?>
<!-- /Switcher -->
<!-- Load site level scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/load_js.php'); ?>
<!-- End loading page level scripts-->
<!-- Load Custom scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'jquery.php'); ?>

</body>
</html>