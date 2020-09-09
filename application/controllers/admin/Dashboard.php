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
      //  if (!$this->ion_auth->in_group('admin')) {
      //      redirect('auth/session_not_authorized', 'refresh');
      //  }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('laporan_mutasi_model');
        $this->load->model('detail_barang_keluar_model');
        $this->load->model('detail_barang_masuk_model');
        $this->load->model('laporan_penjualan_model');
        $this->load->model('pembayaran_piutang_model');
    }

    public function index()
    {   
        $this->load->model('piutang_model');
        $this->load->model('sales_order_model');
        $this->data['nominal_piutang']= $this->piutang_model->get_piutang_sekarang();

        $this->data['jml_qty']= round($this->sales_order_model->get_penjualan_bulan_sekarang(),2);
        $this->data['top_customer']= $this->sales_order_model->get_top_customer();
        $qty_bulan= $this->sales_order_model->get_qty_per_bulan();
        
        $this->data['nominal_uang_masuk']= $this->pembayaran_piutang_model->total_uang_masuk();

        $this->data['a_qty_bulan']=array();
        foreach ($qty_bulan as $row){
            $this->data['a_qty_bulan'][$row->bulan]=$row->jmlqty;
        }
        
        $this->data['menu_data'] = array('master' =>false,'transaksi'=>false,'dashboard'=>true,'cetakan'=>false,'class_master'=>'collapse','class_transaksi'=>'collapse');

        $this->render('admin/Dashboard_view');
    }

}
