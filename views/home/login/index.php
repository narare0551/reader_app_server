<?php
    $now_path = '/views/home/login/';
?>
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/header.php'); ?>

<body class="focused-form">


<div class="container" id="login-form">
    <a href="index.html" class="login-logo"><img src="/assets/img/login-logo.png"></a>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Login</h2></div>
                <div class="panel-body">

                    <div action="" class="form-horizontal" id="validate-form" onkeypress="keypress(event);">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
                                    <input type="text" class="form-control" placeholder="UserID" data-parsley-minlength="6" placeholder="At least 6 characters" id="user_id">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
                                    <input type="password" class="form-control" id="user_pw" placeholder="Password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
<!--                                <a href="extras-forgotpassword.html" class="pull-left">Forgot password?</a>-->
                                <div class="checkbox-inline icheck pull-right pt0">
                                    <label for="">
                                        <input type="checkbox"></input>
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="panel-footer">
                            <div class="clearfix">
<!--                                <a href="extras-registration.html" class="btn btn-default pull-left">Register</a>-->
                                <a href="javascript:checkLogin()" class="btn btn-primary pull-right">Sign In</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="text-center">
<!--                <a href="#" class="btn btn-label btn-social btn-facebook mb20"><i class="fa fa-fw fa-facebook"></i>Connect with Facebook</a>-->
<!--                <a href="#" class="btn btn-label btn-social btn-twitter mb20"><i class="fa fa-fw fa-twitter"></i>Connect with Twitter</a>-->
            </div>
        </div>
    </div>
</div>

<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].'/views/includes/load_js.php'); ?>
<!-- End loading page level scripts-->
<!-- Load Custom scripts -->
<?php get_include_constents($_SERVER["DOCUMENT_ROOT"].$now_path.'jquery.php'); ?>
</body>
</html>