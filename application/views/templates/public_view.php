<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('templates/_parts/public_header_view'); ?>
<?php echo $the_view_content;?>
<?php $this->load->view('templates/_parts/public_footer_view');?>