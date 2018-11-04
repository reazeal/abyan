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

                            <h1><?php echo lang('edit_group_heading');?></h1>
                            <p><?php echo lang('edit_group_subheading');?></p>

                            <div id="infoMessage"><?php echo $message;?></div>

                            <?php echo form_open(current_url());?>

                            <p>
                                <?php echo lang('edit_group_name_label', 'group_name');?> <br />
                                <?php echo form_input($group_name);?>
                            </p>

                            <p>
                                <?php echo lang('edit_group_desc_label', 'description');?> <br />
                                <?php echo form_input($group_description);?>
                            </p>

                            <p><?php echo form_submit('submit', lang('edit_group_submit_btn'));?></p>

                            <?php echo form_close();?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->