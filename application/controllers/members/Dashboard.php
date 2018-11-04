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
class Dashboard extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('members')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->data['menu_data'] = array('master' =>false,'transaksi'=>false,'dashboard'=>true,'cetakan'=>false,'class_master'=>'collapse','class_transaksi'=>'collapse');
        $this->render('members/dashboard_view');
    }

}