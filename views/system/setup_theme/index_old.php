<?php
$now_path = '/views/sample/setup_theme/';
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
                    <div class="row" style="background-color: #f5f5f5;">
                        <div class="col-md-2">
                            <ol class="breadcrumb" style="border:0px !important;background-color: #f5f5f5;">
                                <li class=""><a href="">Home</a></li>
                                <li class=""><a href="">Sample CRUD</a></li>
                                <li class="active"><a href="" id="menu_sm_title"></a></li>
                            </ol>
                            <div class="page-heading mb0" style="padding-bottom: 12px;">
                                <h1 id="menu_title"></h1>
                            </div>
                        </div>
                        <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'search.php'); ?>
                    </div>
                    <!-- content-->
                    <div class="row">
                        <div class="col-lg-7" id="main_list">
                            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'list.php'); ?>
                        </div>
                        <div class="col-lg-5" id="main_detail">
                            <?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'detail.php'); ?>
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
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/option_menu.php'); ?>
<!-- /Switcher -->
<!-- Load site level scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/load_js.php'); ?>
<!-- End loading page level scripts-->
<!-- Load Custom scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'jquery.php'); ?>

</body>
</html>