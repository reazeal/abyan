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
class Return_masuk extends Admin_Controller
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
        $this->load->model('return_masuk_model');
        $this->load->model('barang_masuk_model');
        $this->load->model('detail_barang_masuk_model');
        
    }

    public function index()
    {
        //$this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_rak'] = $this->rak_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Return_masuk_view');
    }

    public function get_nobukti()
    {

        $no_bukti = $this->stok_fisik_model->get_nobukti();

        echo json_encode($no_bukti);
    }

    public function get_data_all(){

        $list = $this->return_masuk_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->kode_return_masuk;
            $row[] = $dt->kode_so;
            $row[] = $dt->kode_barang;
            $row[] = $dt->nama_barang;
            $row[] = $dt->qty;
            $row[] = $dt->alasan_return;
            $row[] = '';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->return_masuk_model->count_all(),
            "recordsFiltered" => $this->return_masuk_model->count_filtered(),
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
            'kode_bantu' => $data->kode_bantu,
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add(){

        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));
        
        $data_return = $this->return_masuk_model->total_return_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 

        if($data_return == 0){
            $jumlah = 1;
            $kode_awal = "001";
            
        }else{
            $jumlah = $data_return + 1;
            
            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $kode = $kode_awal."/RM/".$tanggal_asli[1]."/".$tanggal_asli[0];

        $no = rand(1,100);

        $id = md5($kode.$no.'return-so'.$this->input->post('kode_po').$this->input->post('kode_barang').date('YmdHis').$this->input->post('qty'));
        


        $data = array(
            'id' => $id,
            'kode_return_masuk' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'kode_so' => $this->input->post('kode_so'),
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty_return'),
            'alasan_return' => $this->input->post('alasan_return'),
        );
        $insert = $this->return_masuk_model->save($data);

        $jumlah_masuk = $this->barang_masuk_model->total_masuk_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
            
            if($jumlah_masuk == 0){
                $jumlah = 1;
                $kode_awal = "001";
            }else{
                $jumlah = $jumlah_masuk + 1;

                if(strlen($jumlah_masuk) == 1 ){
                    $kode_awal = "00".$jumlah;
                }else if(strlen($jumlah_masuk) == 2){
                    $kode_awal = "0".$jumlah;
                }else {
                    $kode_awal = $jumlah;
                }
            }

            $kode_barang_masuk = $kode_awal."/BM/".$tanggal_asli[1]."/".$tanggal_asli[0];

            $id_barang_masuk = md5(rand(1,100).'barang-masuk'.$this->input->post('kode_so').$this->input->post('kode_barang').$this->input->post('qty').$this->input->post('qty_terima').date('YmdHis'));

            $data_barang_masuk = array(
                'id' => $id_barang_masuk,
                'kode_barang_masuk' => $kode_barang_masuk,
                'jenis_trans' => 'RETURN',
                'nomor_referensi' => $kode,
                'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
            );
            $insert = $this->barang_masuk_model->save($data_barang_masuk);

            $id_detail_masuk = md5($this->input->post('kode_barang').rand(1,100).$id_barang_masuk.$kode_barang_masuk.'detail_po_masuk'.date('YmdHis'));

            $data_detail_barang = array(
                'kode_barang_masuk' => $kode_barang_masuk,
                'id' => $id_detail_masuk,
                'nomor_referensi' => $kode,
                'kode_barang' =>  $this->input->post('kode_barang'),
                'nama_barang' =>  $this->input->post('nama_barang'),
                'qty' =>  $this->input->post('qty_return'),
                'harga_beli' =>  $this->input->post('harga'),
                'bottom_retail' =>  $this->input->post('bottom_retail'),
                'bottom_supplier' =>  $this->input->post('bottom_supplier'),                
                'keluar' => 0
                                        );

            $this->detail_barang_masuk_model->insert($data_detail_barang);

        
        echo json_encode(array("status" => TRUE));

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


}