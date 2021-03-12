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
                        <div class="col-md-4" style="height:65px;">
                            <div class="page-heading m0 p0 pl1">
                                <ol class="breadcrumb" id="menu_sm_title" style="border:0px !important;background-color: #f5f5f5;">
                                </ol>
                                <h1 id="menu_title" style="padding-left:10px;margin-bottom:5px;"></h1>
                            </div>
                        </div>
                        <div class="col-md-8" style="height:65px;padding-top:30px;">
                            <div class="text-right" style="" id="btn_collection">
                            </div>
                        </div>
                        <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'search.php'); ?>
                    </div>
                    <!-- content-->
                    <div class="row">
                        <div class="col-lg-12" id="main_list">
                            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'list.php'); ?>

                        </div>
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
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'detail.php'); ?>
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'rack_popup.php'); ?>
<!-- /Switcher -->
<!-- Load site level scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/load_js.php'); ?>
<!-- End loading page level scripts-->
<!-- Load Custom scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'jquery.php'); ?>

</body>
</html>