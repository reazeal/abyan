<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hqeem
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 */
class Menu_master extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/logout', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->data['menu_data'] = array('master' =>true,'transaksi'=>false,'dashboard'=>false,'cetakan'=>false,'class_master'=>'collapse','class_transaksi'=>'collapse');
        $this->render('admin/master_menu_view');
    }

}