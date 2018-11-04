<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Profile Page</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <h1><?php echo lang('create_user_heading');?></h1>
                            <p><?php echo lang('create_user_subheading');?></p>

                            <div id="infoMessage"><?php echo $message;?></div>

                            <?php echo form_open("admin/user/create_user");?>

                            <p>
                                <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                                <?php echo form_input($first_name);?>
                            </p>

                            <p>
                                <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                                <?php echo form_input($last_name);?>
                            </p>

                            <?php
                            if($identity_column!=='email') {
                                echo '<p>';
                                echo lang('create_user_identity_label', 'identity');
                                echo '<br />';
                                echo form_error('identity');
                                echo form_input($identity);
                                echo '</p>';
                            }
                            ?>

                            <p>
                                <?php echo lang('create_user_company_label', 'company');?> <br />
                                <?php echo form_input($company);?>
                            </p>

                            <p>
                                <?php echo lang('create_user_email_label', 'email');?> <br />
                                <?php echo form_input($email);?>
                            </p>

                            <p>
                                <?php echo lang('create_user_phone_label', 'phone');?> <br />
                                <?php echo form_input($phone);?>
                            </p>

                            <p>
                                <?php echo lang('create_user_password_label', 'password');?> <br />
                                <?php echo form_input($password);?>
                            </p>

                            <p>
                                <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                                <?php echo form_input($password_confirm);?>
                            </p>


                            <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

                            <?php echo form_close();?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->