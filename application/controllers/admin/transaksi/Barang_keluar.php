<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  barang_keluar_model $barang_keluar_model
 */
class Barang_keluar extends Admin_Controller
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
        $this->load->model('barang_model');
        $this->load->model('barang_keluar_model');
        $this->load->model('barang_masuk_model');
        $this->load->model('detail_barang_keluar_model');
        $this->load->model('stok_model');
        $this->load->model('stok_keluar_model');
        
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        $this->render('admin/transaksi/Barang_keluar_view');
    }

    public function get_nobukti()
    {

        $no_bukti = $this->barang_keluar_model->get_nobukti();

        echo json_encode($no_bukti);
    }

    public function get_data_all(){

        $list = $this->barang_keluar_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->kode_barang_keluar;
            $row[] = $dt->nomor_referensi;
            $row[] = $dt->kode_barang;
            $row[] = $dt->nama_barang;
            $row[] = $dt->qty;
            $row[] = $dt->keterangan;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_barang('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_barang_keluar('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->barang_keluar_model->count_all(),
            "recordsFiltered" => $this->barang_keluar_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->barang_keluar_model->get($id);
        $data  = array(
            'id' => $data->id,
            //'barang_id' => $data->barang_id,
            'keterangan' => $data->keterangan,
            'tanggal' => $this->tanggal($data->tanggal),
            'no_bukti' => $data->no_bukti,
            //'nama_barang' => $data->nama_barang,
            //'qty' => $data->qty,
            'ongkir' => $data->ongkir,
            'no_resi' => $data->no_resi,
            //'detailBarang'=> null
            'detailBarangKeluar'=> (array) $this->detail_barang_keluar_model->getDataByTransaksi3($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {


        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        
        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));

        $jumlah_keluar = $this->barang_keluar_model->total_keluar_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
        
        if($jumlah_keluar == 0){
            $jumlah = 1;
            $kode_awal = "00001";
        }else{
            $jumlah = $jumlah_keluar + 1;

            if(strlen($jumlah_keluar) == 1 ){
                $kode_awal = "0000".$jumlah;
            }else if(strlen($jumlah_keluar) == 2){
                $kode_awal = "000".$jumlah;
            }else if(strlen($jumlah_keluar) == 3){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah_keluar) == 4){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $kode = $kode_awal."/BK/".$tanggal_asli[1]."/".$tanggal_asli[0];

        $id = md5('barang-keluar'.$this->input->post('nomor_referensi').date('YmdHis').$kode.$this->input->post('jenis_trans'));

        $data = array(
            'id' => $id,
            'keterangan' => $this->input->post('keterangan'),
            'nomor_referensi' => $this->input->post('nomor_referensi'),
            'jenis_trans' => $this->input->post('jenis_trans'),
            'kode_barang_keluar' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $insert = $this->barang_keluar_model->save($data);
       // $id = $this->db->insert_id();

        if($id){
    
            $i=0;
            
            foreach ($json as $ax) :
              
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                    
                        $stok_barang = $this->stok_model->total_perbarang($ax[0]);
                        
                        $id_detail = md5($id.$ax[0].$ax[1].$stok_barang.date("YmdHis"));

                        $data_detail = array(
                            'id' => $id_detail,
                            'id_barang_keluar' => $id,
                            'kode_barang' => $ax[0],
                            'nama_barang' => $ax[1],
                            'qty' => $ax[2],
                            'nomor_referensi' => $this->input->post('nomor_referensi'),
                            'saldo_awal' => $stok_barang,
                            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
                        );

                        $this->detail_barang_keluar_model->insert($data_detail);
                        
                        $stok_limit = $this->barang_model->total_limit_perbarang($ax[0]);

                        if($stok_barang - $ax[2] < $stok_limit){
                            $status = 'Stok Limit';
                        }else{
                            $status = 'Stok Baik';
                        }
                        
                        $data_stok = array(
                            'status_stok' => $status,
                            'qty' => $stok_barang - $ax[2]
                        );

                        $this->stok_model->update_by_kode($ax[0], $data_stok);

                    }   
                }
                $i++;
            endforeach;
        }
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        if($this->input->post('no_bukti') == ''){
            $no_resi = 'Belum Ada';
        }else{
            $no_resi = $this->input->post('no_resi');
        }

        if($this->input->post('ongkir') == '0' || $this->input->post('ongkir') == ''){
            $ongkir = '0';
        }else{
            $ongkir = $this->input->post('ongkir');
        }

        $data = array(
            //'barang_id' => $this->input->post('barang_id'),
            'keterangan' => $this->input->post('keterangan'),
            'no_bukti' => $this->input->post('no_bukti'),
            //'nama_barang' => $this->input->post('nama_barang'),
            //'qty' => $this->input->post('qty'),
            'no_resi' => $no_resi,
            'ongkir' => $ongkir,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $this->barang_keluar_model->update_by_id(array('id' => $this->input->post('id')), $data);

      
        echo json_encode(array("status" => TRUE));
    }

    public function get_detail($id)
    {
        $data  = array(
            'detailBarang'=> (array) $this->detail_barang_keluar_model->getDataByTransaksi2($id)
        );
        echo json_encode(array($data));
    }

    public function delete($id)
    {
       /* $datay = $this->detail_barang_model->getDataByTransaksi($id);
        foreach ($datay as $rw) :
            $this->detail_barang_model->delete($rw['id']);
        endforeach;*/

        $this->barang_keluar_model->delete($id);
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

    public function stok()
    {
        //$data = $this->barang_masuk_model->get($id);
        $data  = array(
            'detailStok'=> (array) $this->stok_fisik_model->getStokByBarang()
        );
        echo json_encode(array($data));
    }

    public function session_barang()
    {
        $session  = array(
            'barang_id' => $this->input->get('barang_id')
        );

        $this->session->set_userdata($session);
        echo json_encode(array("status" => TRUE,"barang_id" => $this->session->userdata("barang_id")));
    }

    public function cek_stok($barang, $jumlahBeli)
    {
        //echo $jumlahBeli;
        //$jumlah = $this->stok_fisik_model->getJumlahStokBarang($barang);
        $jumlah = $this->stok_model->total_perbarang($barang);
//        $datay = $this->departemen_center->get_data_by_id($lokasi);
        //echo $jumlah.'ha';
        $status = false;
        if($jumlah > 0){
            if($jumlah < $jumlahBeli){
                echo json_encode(array("status" => FALSE,"info"=>"Stok Barang Kurang"));
            }else{
                echo json_encode(array("status" => TRUE));
            }
        }else{
            echo json_encode(array("status" => FALSE,"info"=>"Stok Barang 0"));
        }
        
        // json_encode(array("status" => $status));
    }


}