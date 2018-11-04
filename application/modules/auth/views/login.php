<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - <?php echo $site_title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo site_url('assets/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo site_url('assets/vendors/animate.css/animate.min.css');?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url('assets/build/css/custom.min.css');?>" rel="stylesheet">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php echo form_open("auth/login");?>
                    <h1>Login Form</h1>
                    <div>
                        <input type="text" id="identity" name="identity" value="" required=""  placeholder="Username" class="form-control" />
                    </div>
                    <div>
                        <input type="password" id="password" name="password" value="" placeholder="Password" class="form-control"/>
                    </div>
                    <div>
                        <div id="infoMessage"><?php echo $message;?>
						<?php echo $this->session->flashdata("message"); ?>
						</div>
                    </div>
                    <div>
                        <span class="login-checkbox">
					    <input id="remember" name="remember" type="checkbox" class="field login-checkbox" value="1"  tabindex="4" />
					        <label class="choice" for="Field">Keep me signed in</label>
				        </span>
                        <input type="submit" name="submit" value="&nbsp;Sign In &nbsp;"  class="to_register" style="color: black !important;font-family: Trebuchet MS, sans-serif; font-size: small"/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><?php echo $site_title; ?></h1>
                            <p><?php echo $copyright; ?></p>
                        </div>
                    </div>
                <?php echo form_close();?>
            </section>
        </div>

    </div>
</div>
</body>
</html>