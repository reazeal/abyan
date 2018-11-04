<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $site_title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo site_url('assets/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo site_url('assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo site_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/jqueryui/jquery-ui.min.css');?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo site_url('assets/build/css/custom.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-table/bootstrap-table.css');?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/chosen/chosen.min.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/daterangepicker/daterangepicker-bs3.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datepicker/css/datepicker.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/timepicker/css/bootstrap-timepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datetimepicker/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/validation-engine/css/validationEngine.jquery.css');?>" type="text/css"/>



    <link href="<?php echo site_url('assets/bootstrap-select/bootstrap-select.css');?>" rel="stylesheet"/>

    <!-- Datatables -->
    <link href="<?php echo site_url('assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/ajax.combobox/dist/css/jquery.ajax-combobox.min.css');?>" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo site_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <!-- Jquery UI -->
    <script src="<?php echo site_url('assets/jqueryui/jquery-ui.min.js');?>"></script>
    <!--Validation Engine-->
    <script src="<?php echo site_url('assets/validation-engine/js/languages/jquery.validationEngine-id.js');?>"></script>
    <script src="<?php echo site_url('assets/validation-engine/js/jquery.validationEngine.js');?>"></script>
    <!--Ajax ComboBox-->
    <script src="<?php echo site_url('assets/ajax.combobox/dist/js/jquery.ajax-combobox.min.js');?>"></script>
    <script src="<?php echo site_url('assets/bootstrap-select/bootstrap-select.js');?>"></script>



    <script type="application/javascript">
        var COPYRIGHT           = '<?php echo $copyright; ?>';
        var WEB_TITLE           = '<?php echo $site_title; ?>';
        var CREDIT              = '<?php echo $credit; ?>';
    </script>

    <style>
        td.details-control {
            background: url('<?php echo site_url('assets/images/details_open.png');?>') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('<?php echo site_url('assets/images/details_close.png');?>') no-repeat center center;
        }
    </style>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?php echo site_url();?>" class="site_title"><span><?php echo $site_title; ?></span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="<?php echo site_url('assets/images/img.jpg');?>" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo $firstname_auth." ".$lastname_auth; ?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <?php
                if($this->ion_auth->in_group('admin'))
                {
                    $this->load->view('templates/_parts/admin_menu_view');
                }elseif($this->ion_auth->in_group('members')){
                    $this->load->view('templates/_parts/members_menu_view');
                }else{
					redirect('auth/logout', 'refresh');
				}
                ?>
