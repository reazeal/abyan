<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Pudak Digital
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  barang_keluar_model $barang_keluar_model
 * @property  barang_masuk_model $barang_masuk_model
 * @property  rak_model $rak_model
 * @property  stok_fisik_model $stok_fisik_model
 */
class Pegawai extends Admin_Controller
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
        $this->load->model('pegawai_model');
        
    }

    public function index()
    {
        //$this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_rak'] = $this->rak_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/master/Pegawai_view');
    }

    public function get_data_all(){

        $list = $this->pegawai_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $dt->kode_pegawai;
            $row[] = $dt->nama_pegawai;
            $row[] = $dt->jabatan;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_pegawai('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pegawai('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->pegawai_model->count_all(),
            "recordsFiltered" => $this->pegawai_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get($id)
    {
       // echo $id;
       // die();
        $data = $this->hutang_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'kode_hutang' => $data->kode_hutang,
            'nomor_referensi' => $data->nomor_referensi,
            'kode_relasi' => $data->kode_relasi,
            'nama_relasi' => $data->nama_relasi,
            'nominal' => $data->nominal,
            
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function edit($id)
    {
        $data = $this->pegawai_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'nama_pegawai' => $data->nama_pegawai,
            'jabatan' => $data->jabatan,
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $jumlah_pegawai = $this->pegawai_model->total_pegawai(); 
        
        if($jumlah_pegawai == 0){
            $jumlah = 1;
            $kode_awal = "001";
        }else{
            $jumlah = $jumlah_pegawai + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $rand = rand(1,100);
        $id_pegawai = md5($rand.'master-pegawai'.$this->input->post('kode_pegawai').$this->input->post('nama_pegawai'));
        $data = array(
            'id' => $id_pegawai,
            'kode_pegawai' => "P".$kode_awal,
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'jabatan' => $this->input->post('jabatan'),
            
        );
        $insert = $this->pegawai_model->save($data);
        $id = $this->db->insert_id();

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {

     
        $data = array(
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'jabatan' => $this->input->post('jabatan')
            
        );
        $this->pegawai_model->update_by_id(array('id' => $this->input->post('id')), $data);


        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
     
        $this->pegawai_model->delete_by_id($id);


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

    public function stok($barang)
    {
        //$data = $this->barang_masuk_model->get($id);
        $data  = array(
            'detailStok'=> (array) $this->stok_fisik_model->getStokByBarangId($barang)
        );
        echo json_encode(array($data));
    }


}