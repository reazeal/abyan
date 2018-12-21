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
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('laporan_mutasi_model');
        $this->load->model('detail_barang_keluar_model');
        $this->load->model('detail_barang_masuk_model');
        $this->load->model('laporan_penjualan_model');
    }

    public function index()
    {   
        $this->load->model('piutang_model');
        $this->load->model('sales_order_model');
        $this->data['nominal_piutang']= $this->piutang_model->get_piutang_sekarang();
        $this->data['jml_qty']= $this->sales_order_model->get_penjualan_bulan_sekarang();
        $this->data['top_customer']= $this->sales_order_model->get_top_customer();
        
        $this->data['menu_data'] = array('master' =>false,'transaksi'=>false,'dashboard'=>true,'cetakan'=>false,'class_master'=>'collapse','class_transaksi'=>'collapse');

        $this->render('admin/Dashboard_view');
    }

}