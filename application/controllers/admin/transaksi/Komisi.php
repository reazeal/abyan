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
class Komisi extends Admin_Controller
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
        $this->load->model('laba_rugi_model');
        $this->load->model('detail_laba_rugi_model');
        $this->load->model('pembayaran_piutang_model');
        $this->load->model('pembayaran_hutang_model');
        $this->load->model('transaksi_biaya_model');
        $this->load->model('komisi_model');
        
    }

    public function index()
    {
        //$this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_rak'] = $this->rak_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Komisi_view');
    }
    

    public function get_data_all(){

        $list = $this->komisi_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $dt->periode;
            $row[] = $dt->jenis_komisi;
            $row[] = $dt->nama_pegawai;
            $row[] = number_format((($dt->nominal)?$dt->nominal:'0'),0,",",".");
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_ll('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Cetak" onclick="cetak_ll('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Cetak</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->komisi_model->count_all(),
            "recordsFiltered" => $this->komisi_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->stok_fisik_model->get($id);
        $data  = array(
            'id' => $data->id,
            'barang_id' => $data->barang_id,
            'keterangan' => $data->keterangan,
            'nama_barang' => $data->nama_barang,
            'qty' => $data->qty,
            'gudang_id' => $data->gudang_id,
            'detailBarang'=> null
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);
        $gudang = $this->gudang_model->get($this->input->post('gudang_id'));
        $data = array(
            'barang_id' => $this->input->post('barang_id'),
            'keterangan' => $this->input->post('keterangan'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty'),
            //'no_rak' => $this->input->post('no_rak'),
            //'rak_id' => $this->input->post('rak_id'),
            'nama_gudang' => $gudang->kode.'-'.$gudang->nama,
            'gudang_id' => $this->input->post('gudang_id')
            
        );
        $insert = $this->stok_model->save($data);
        $id = $this->db->insert_id();


        echo json_encode(array("status" => TRUE));
    }

    public function get($id)
    {
       // echo $id;
       // die();
        $data = $this->piutang_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'kode_piutang' => $data->kode_piutang,
            'nomor_referensi' => $data->kode_referensi,
            'kode_relasi' => $data->kode_relasi,
            'nama_relasi' => $data->nama_relasi,
            'nominal' => $data->nominal,
            'kode_bantu' => $data->kode_bantu,
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $gudang = $this->gudang_model->get($this->input->post('gudang_id'));

        $data = array(
            'barang_id' => $this->input->post('barang_id'),
            'keterangan' => $this->input->post('keterangan'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty'),
            'gudang_id' => $this->input->post('gudang_id'),
            'nama_gudang' => $gudang->kode.'-'.$gudang->nama
            
        );
        $this->stok_model->update_by_id(array('id' => $this->input->post('id')), $data);


        /*$datay = $this->detail_barang_model->getDataByTransaksi($this->input->post('id'));

        foreach ($datay as $rw) :
            $this->detail_barang_model->delete($rw['id']);
        endforeach;

        $i=0;
        foreach ($json as $ax) :
            if(!is_object($ax)){
                if(is_string($ax[0])){
                        $data_detail = array(
                            'id_barang' => $this->input->post('id'),
                            'jenis_barang' => $ax[1],
                            'barang' => $ax[2]
                        );
                        $this->detail_barang_model->insert($data_detail);
                }
            }
            $i++;
        endforeach;*/

        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
       /* $datay = $this->detail_barang_model->getDataByTransaksi($id);
        foreach ($datay as $rw) :
            $this->detail_barang_model->delete($rw['id']);
        endforeach;*/

        //$this->stok_fisik_model->delete($id);
        
        $data = $this->stok_fisik_model->get($id);

        print_r($data);
        die();
        $stok_barang = $this->stok_fisik_model->getJumlahStokBarang($data->barang_id);
        
        $stok_limit = $this->barang_model->get($data->barang_id);
        $jumlah_stok_limit = $stok_limit->batas_stok;

        if($stok_barang < $jumlah_stok_limit){
            $status = 'Stok Limit';
        }else{
            $status = 'Stok Baik';
        }

        $data_barang = array(
            'status_stok' => $status
        );

        $this->barang_model->update_by_id(array('id' => $data->barang_id), $data_barang);


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

    public function get_detail($id_ll)
    {
        $data  = array(
            'detailSo'=> (array) $this->detail_laba_rugi_model->getDataByIDLabaRugi($id_ll)
        );
        echo json_encode(array($data));
    }
    
    
    public function cetak_detail_ll($id_ll){

        //echo $_GET['id'];
     //   $id = $this->input->get('id');

        $datax = $this->detail_laba_rugi_model->getDataByIDLabaRugi($id_ll);
        //print_r($datax);
       // $datax = $this->detail_so_model->get_by_id();
        $data['datanya'] = $datax;
        $this->load->view('admin/transaksi/cetak_detail_ll',$data);

    }
}