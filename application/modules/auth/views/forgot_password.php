<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap.min.css');?>" />
    <link href="<?php echo site_url('assets/css/bootstrap-responsive.min.css');?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo site_url('assets/css/font-awesome.css');?>" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="<?php echo site_url('assets/css/style.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo site_url('assets/css/pages/signin.css');?>" rel="stylesheet" type="text/css">

</head>

<body>

<div class="navbar navbar-fixed-top">

    <div class="navbar-inner">

        <div class="container">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="">
                Framework Template
            </a>

            <div class="nav-collapse">
                <ul class="nav pull-right">

                    <!-- <li class="">
                         <a href="signup.html" class="">
                             Don't have an account?
                         </a>

                     </li>

                     <li class="">
                         <a href="index.html" class="">
                             <i class="icon-chevron-left"></i>
                             Back to Homepage
                         </a>

                     </li>-->
                </ul>

            </div><!--/.nav-collapse -->

        </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

</div> <!-- /navbar -->



<div class="account-container">

    <div class="content clearfix">

        <?php echo form_open("auth/forgot_password");?>

        <h1><?php echo lang('forgot_password_heading');?></h1>
        <div><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></div>
        <div class="login-fields">
            <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
            <?php echo form_input($identity);?>
        </div>

        <div>
            <div id="infoMessage"><?php echo $message;?></div>
        </div>

        <div class="login-actions">
				<span class="login-checkbox">
					<input id="remember" name="remember" type="checkbox" class="field login-checkbox" value="1"  tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
            <input type="submit" name="submit" value="Submit"  class="button btn btn-success btn-large"/>
        </div> <!-- .actions -->

        <?php echo form_close();?>

    </div> <!-- /content -->

</div> <!-- /account-container -->



<div class="login-extra">

    <a href="<?php echo site_url('auth/login');?>">Login</a> &nbsp; &nbsp; | &nbsp; &nbsp;
    <a href="<?php echo site_url('auth/forgot_password');?>"><?php echo lang('login_forgot_password');?></a>
</div> <!-- /login-extra -->


<script src="<?php echo site_url('assets/js/jquery-1.7.2.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/bootstrap.js');?>"></script>
<script src="<?php echo site_url('assets/js/signin.js');?>"></script>

</body>
</html>
