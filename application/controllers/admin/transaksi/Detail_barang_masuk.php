<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hqeem
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  detail_barang_masuk_model $detail_barang_masuk_model
 * @property  barang_masuk_model $barang_masuk_model
 */
class detail_barang_masuk extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
       // if (!$this->ion_auth->in_group('admin')) {
       //     redirect('auth/session_not_authorized', 'refresh');
       // }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('barang_model');
        $this->load->model('gudang_model');
        $this->load->model('barang_masuk_model');
        $this->load->model('stok_fisik_model');
        $this->load->model('detail_barang_masuk_model');
    }


     public function get_by_id($id)
    {

        //echo 'sini';
//        $data = $this->detail_barang_masuk_model->get_by_id($id);
$data = $this->detail_barang_masuk_model->get_by_idx($id);       
 $data  = array(            
            'qty_stok' => $data->qty - $data->keluar,
           // 'qty_stok' => $data->qty_stok,
            'bottom_retail' => $data->bottom_retail,
            'bottom_supplier' => $data->bottom_supplier,
            'harga' => $data->harga_beli,
            'id_detail_barang_masuk' => $data->id
        );
        echo json_encode(array($data));
    }




}
