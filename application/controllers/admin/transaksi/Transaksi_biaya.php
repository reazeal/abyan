<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: pudak digital
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  detail_barang_model $detail_barang_model
 */
class Transaksi_biaya extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
//        if (!$this->ion_auth->in_group('admin')) {
  //          redirect('auth/session_not_authorized', 'refresh');
    //    }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('transaksi_biaya_model');
        $this->load->model('jenis_biaya_model');
        $this->load->model('detail_barang_model');
    }

    public function index()
    {
        $this->data['pilihan_biaya'] = $this->jenis_biaya_model->get_all();
        $this->render('admin/transaksi/Transaksi_biaya_view');
    }

    public function get_data_all(){

        $list = $this->transaksi_biaya_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->nama_biaya;
            $row[] = $dt->kode_referensi;
            $row[] = $dt->nominal;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_transaksi_biaya('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_transaksi_biaya('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->transaksi_biaya_model->count_all(),
            "recordsFiltered" => $this->transaksi_biaya_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->transaksi_biaya_model->get($id);
        $data  = array(
            'id' => $data->id,
            'id_jenis_biaya' => 'Gaji',
            'tanggal' => $data->tanggal,
            'nominal' => $data->nominal,
            
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {


        $data = array(
            'id' => md5(rand(1,100).'transaksi_biaya'.$this->input->post('nama_biaya').$this->input->post('nominal').date('YmdHis')),
            'id_jenis_biaya' => $this->input->post('nama_biaya'),
            'nominal' => $this->input->post('nominal'),            
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'status' => 'Lunas',
            
        );
        $insert = $this->transaksi_biaya_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'nama' => $this->input->post('nama'),
            'keterangan' => $this->input->post('keterangan'),
            'kode' => $this->input->post('kode'),
            'batas_stok' => $this->input->post('batas_stok'),
            'satuan' => $this->input->post('satuan')
        );
        $this->barang_model->update_by_id(array('id' => $this->input->post('id')), $data);



        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        
        $this->transaksi_biaya_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function combo_jenis_barang(){
        $and_or = $this->input->get('and_or');
        $order_by = $this->input->get('order_by');
        $page_num= $this->input->get('page_num');
        $per_page= $this->input->get('per_page');
        $q_word= $this->input->get('q_word');
        $search_field= $this->input->get('search_field');

        $datanya = $this->barang_model->combo_jenis_barang($and_or,$order_by,$page_num,$per_page,$q_word,$search_field);
        echo json_encode($datanya);
    }


}