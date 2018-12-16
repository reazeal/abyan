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
class Kunjungan_outlet extends Admin_Controller
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
        $this->load->model('kunjungan_outlet_model');
        $this->load->model('pegawai_model');
    }

    public function index()
    {
        $this->data['pilihan_pegawai'] = $this->pegawai_model->get_all();
        $this->render('admin/transaksi/Kunjungan_outlet_view');
    }

    public function get_data_all(){

        $list = $this->kunjungan_outlet_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->nama_outlet;
            $row[] = $dt->kode_pegawai;
            $row[] = $dt->nama_pegawai;
            $row[] = $dt->hasil_kunjungan;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_kunjungan_outlet('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_kunjungan_outlet('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->kunjungan_outlet_model->count_all(),
            "recordsFiltered" => $this->kunjungan_outlet_model->count_filtered(),
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

        $pegawai = explode("-", $this->input->post('kode_pegawai'));
        $data = array(
            'id' => md5(rand(1,100).'Kunjungan_outlet'.$this->input->post('nama_outlet').$this->input->post('tanggal').date('YmdHis')),
            'nama_outlet' => $this->input->post('nama_outlet'),
            'kode_pegawai' => $pegawai[0],            
            'nama_pegawai' => $pegawai[1],
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'hasil_kunjungan' => $this->input->post('hasil_kunjungan'),
            
        );
        $insert = $this->kunjungan_outlet_model->save($data);
        
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
        
        $this->kunjungan_outlet_model->delete_by_id($id);
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