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


                            <h1><?php echo lang('index_heading');?></h1>
                            <p><?php echo lang('index_subheading');?></p>

                            <div id="infoMessage"><?php echo $message;?></div>

                            <table cellpadding=0 cellspacing=10 border="1">
                                <tr>
                                    <th><?php echo lang('index_fname_th');?></th>
                                    <th><?php echo lang('index_lname_th');?></th>
                                    <th><?php echo lang('index_email_th');?></th>
                                    <th><?php echo lang('index_groups_th');?></th>
                                    <th><?php echo lang('index_status_th');?></th>
                                    <th><?php echo lang('index_action_th');?></th>
                                </tr>
                                <?php foreach ($users as $user):?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                                        <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                        <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                                        <td>
                                            <?php foreach ($user->groups as $group):?>
                                                <?php echo anchor("admin/user/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                                            <?php endforeach?>
                                        </td>
                                        <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                                        <td><?php echo anchor("admin/user/edit_user/".$user->id, 'Edit') ;?></td>
                                    </tr>
                                <?php endforeach;?>
                            </table>

                            <p><?php echo anchor('admin/user/create_user', lang('index_create_user_link'))?> | <?php echo anchor('admin/user/create_group', lang('index_create_group_link'))?></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->