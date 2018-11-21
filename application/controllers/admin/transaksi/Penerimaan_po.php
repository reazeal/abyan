<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Pudak Digital
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_modeal $barang_model
 * @property  datatables $datatables
 * @property  detail_barang_masuk_model $detail_barang_masuk_model
 * @property  barang_masuk_model $barang_masuk_model
 */
class Penerimaan_po extends Admin_Controller
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
        $this->load->model('penerimaan_po_model');
        $this->load->model('stok_model');
        $this->load->model('detail_penerimaan_po_model');
        $this->load->model('barang_masuk_model');
        $this->load->model('detail_barang_masuk_model');
        $this->load->model('purchase_order_model');
        $this->load->model('hutang_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Penerimaan_po_view');
    }

    public function get_data_all(){

        $list = $this->penerimaan_po_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->kode_penerimaan_po;
            $row[] = $dt->kode_po;
            $row[] = $dt->nama_supplier;
            $row[] = $dt->kode_barang;
            $row[] = $dt->nama_barang;
            $row[] = $dt->qty_terima;
            /*
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_penerimaan('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            */
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->penerimaan_po_model->count_all(),
            "recordsFiltered" => $this->penerimaan_po_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->penerimaan_po_model->get_by_id_detail($id);
       // print_r($data);
       // die();
        $data  = array(
            'id' => $data->id,
            'kode_penerimaan_po' => $data->kode_penerimaan_po,
            'kode_po' => $data->kode_po,
            'nama_supplier' => $data->nama_supplier,
            'nama_barang' => $data->nama_barang,
            'kode_barang' => $data->kode_barang,
            'qty_terima' => $data->qty_terima,
            'qty_return' => $data->qty_return,
            'tanggal' => $this->tanggal($data->tanggal),
           // 'detailBarangMasuk'=> (array) $this->detail_barang_masuk_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }


    public function get_detail($id)
    {
        $data  = array(
            'detailBarang'=> (array) $this->detail_barang_masuk_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));
        
        $jumlah_penerimaan = $this->penerimaan_po_model->total_terima_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
        
        if($jumlah_penerimaan == 0){
            $jumlah = 1;
            $kode_awal = "001";
        }else{
            $jumlah = $jumlah_penerimaan + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }


        $kode_terima_pox = $this->penerimaan_po_model->get_kode_by_kode_terima($this->input->post('kode_po'),$this->tanggaldb($this->input->post('tanggal')));

        if($kode_terima_pox == null){

            
            $kode = $kode_awal."/PP/".$tanggal_asli[1]."/".$tanggal_asli[0];

            $no = rand(1,100);

            $id = md5($kode.$no.'penerimaan-po'.$this->input->post('kode_po').$this->input->post('kode_barang').date('YmdHis').$this->input->post('qty'));
            


            $data = array(
                'id' => $id,
                'kode_penerimaan_po' => $kode,
                'kode_po' => $this->input->post('kode_po'),
                'kode_supplier' => $this->input->post('kode_supplier'),
                'nama_supplier' => $this->input->post('nama_supplier'),
                
                'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
            );
            $insert = $this->penerimaan_po_model->save($data);


            $id_detail = md5($id.'detail_penerimaan-po'.$this->input->post('kode_po').$this->input->post('kode_barang').$this->input->post('qty').$this->input->post('qty_terima').date('YmdHis'));



            $data_detail = array(
                'id' => $id_detail,
                'kode_penerimaan_po' => $kode,
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'qty_terima' => $this->input->post('qty_terima'),
            );
            $insert = $this->detail_penerimaan_po_model->save($data_detail);
            
            $kode_terima_po = $kode;

        }else{

            $kode_terima_po = $kode_terima_pox;

            $id_detail = md5($kode_terima_po.'detail_penerimaan-po'.$this->input->post('kode_po').$this->input->post('kode_barang').$this->input->post('qty').$this->input->post('qty_terima').date('YmdHis'));

            $data_detail = array(
                'id' => $id_detail,
                'kode_penerimaan_po' => $kode_terima_po,
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'qty_terima' => $this->input->post('qty_terima'),
            );
            $insert = $this->detail_penerimaan_po_model->save($data_detail);
                
        }

        // barang masuk

        $kode_masuk = $this->barang_masuk_model->get_kode_by_kode_terima($kode_terima_po,$this->tanggaldb($this->input->post('tanggal')));

        if($kode_masuk == null){

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

            $id_barang_masuk = md5(rand(1,100).'barang-masuk'.$this->input->post('kode_po').$this->input->post('kode_barang').$this->input->post('qty').$this->input->post('qty_terima').date('YmdHis'));

            $data_barang_masuk = array(
                'id' => $id_barang_masuk,
                'kode_barang_masuk' => $kode_barang_masuk,
                'jenis_trans' => 'PEMBELIAN',
                'nomor_referensi' => $kode_terima_po,
                'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
            );
            $insert = $this->barang_masuk_model->save($data_barang_masuk);

            $id_detail_masuk = md5($this->input->post('kode_barang').rand(1,100).$id_barang_masuk.$kode_barang_masuk.'detail_po_masuk'.date('YmdHis'));

            $data_detail_barang = array(
                'kode_barang_masuk' => $kode_barang_masuk,
                'id' => $id_detail_masuk,
                'nomor_referensi' => $kode_terima_po,
                'kode_barang' =>  $this->input->post('kode_barang'),
                'nama_barang' =>  $this->input->post('nama_barang'),
                'qty' =>  $this->input->post('qty_terima'),
                'harga_beli' =>  $this->input->post('harga'),
                'bottom_retail' =>  $this->input->post('bottom_retail'),
                'bottom_supplier' =>  $this->input->post('bottom_supplier'),                
                'keluar' => 0
                                        );

            $this->detail_barang_masuk_model->insert($data_detail_barang);

        }else{

            $id_detail_masuk = md5($this->input->post('kode_barang').$kode_masuk.rand(1,100).'detail_po_masuk'.date('YmdHis'));

            $data_detail_barang = array(
                'kode_barang_masuk' => $kode_masuk,
                'id' => $id_detail_masuk,
                'nomor_referensi' => $kode_terima_po,
                'kode_barang' =>  $this->input->post('kode_barang'),
                'nama_barang' =>  $this->input->post('nama_barang'),
                'qty' =>  $this->input->post('qty_terima'),
                'harga_beli' =>  $this->input->post('harga'),
                'bottom_retail' =>  $this->input->post('bottom_retail'),
                'bottom_supplier' =>  $this->input->post('bottom_supplier'),
                
              //  'kode_penerimaan_po' => $kode,
                'keluar' => 0
                                        );

            $this->detail_barang_masuk_model->insert($data_detail_barang);

        }

        
        $jumlah_order = $this->input->post('qty');
        $jumlah_terima = $this->penerimaan_po_model->total_kode_po($this->input->post('kode_po'));
       // print_r($jumlah_terima);
       // echo $jumlah_terima;
       // die();
        if($jumlah_terima >=  $jumlah_order){
            $status_po = 'Selesai';
        }else{
            $status_po = 'Proses';
        }

        $data_po = array(
            'status' => $status_po
        );

        $this->purchase_order_model->update_by_kode_po($this->input->post('kode_po'), $data_po);

        // hutang 

        $data_kode_hutang = $this->hutang_model->get_kode_hutang_by_kode_terima_po($kode_terima_po, $this->tanggaldb($this->input->post('tanggal')));

        if($data_kode_hutang == null ){

            $data_hutang = array();
            
            $jumlah_hutang = $this->hutang_model->total_hutang_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
            
            if($jumlah_hutang == 0){
                $jumlah = 1;
                $kode_awal_hutang = "001";
            }else{
                $jumlah = $jumlah_hutang + 1;

                if(strlen($jumlah_hutang) == 1 ){
                    $kode_awal_hutang = "00".$jumlah;
                }else if(strlen($jumlah_hutang) == 2){
                    $kode_awal_hutang = "0".$jumlah;
                }else {
                    $kode_awal_hutang = $jumlah;
                }
            }

            $kode_hutang = $kode_awal_hutang."/HT/".$tanggal_asli[1]."/".$tanggal_asli[0];
            $i_hutang = rand(1,100);
            $id_hutang = md5($kode_hutang.$i_hutang.date('YmdHis').$this->input->post('kode_supplier'));
            
            $jatuh_tempo = $this->penerimaan_po_model->get_by_jatuh_tempo($this->tanggaldb($this->input->post('tanggal')),$this->input->post('top'));

            $data_hutang = array(
                'id' => $id_hutang,
                'kode_hutang' => $kode_hutang,
                'kode_relasi' => $this->input->post('kode_supplier'),
                'nama_relasi' => $this->input->post('nama_supplier'),
                'nomor_referensi' => $kode_terima_po,
                'kode_bantu' => $this->input->post('kode_po'),
                'jenis' => 'PEMBELIAN' ,
                'nominal' => $this->input->post('qty_terima') * $this->input->post('harga'),
                'tanggal' => $this->tanggaldb($this->input->post('tanggal')) ,
                'tanggal_jatuh_tempo' => $jatuh_tempo,
                'status' => 'Belum Lunas' ,

            );

            $this->hutang_model->insert($data_hutang);


        }else{

            $nominal = ( $this->input->post('qty_terima') * $this->input->post('harga') ) + $data_kode_hutang->nominal;
            
            $data_hutang_baru = array(
                'nominal' => $nominal
            );

            $this->hutang_model->update_by_kode($data_kode_hutang->kode_hutang, $data_hutang_baru);

        }

        // tutup hutang

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'qty_terima' => $this->input->post('qty_terima_baru'),
            'qty_return' => $this->input->post('qty_return_baru')
        );
        $this->detail_penerimaan_po_model->update_by_id(array('id' => $this->input->post('id')), $data);

        $data_masuk = array(
            'qty' => $this->input->post('qty_terima_baru')
        );

        $this->detail_barang_masuk_model->update_by_id(array('kode_penerimaan_po' => $this->input->post('kode_penerimaan_po')), $data_masuk);

        $stok_barang = $this->stok_model->total_perbarang($this->input->post('kode_barang'));

        $stok_limit = $this->barang_model->total_limit_perbarang($this->input->post('kode_barang'));

        if($stok_barang + $this->input->post('qty_terima') < $stok_limit){
            $status = 'Stok Limit';
        }else{
            $status = 'Stok Baik';
        }
        
        $jumlah_stok = $stok_barang + $this->input->post('qty_terima_baru') - $this->input->post('qty_terima');
        $data_stok = array(
            'status_stok' => $status,
            'qty' => $jumlah_stok
        );

        $this->stok_model->update_by_kode($this->input->post('kode_barang'), $data_stok);

        $jumlah_barang_masuk = $this->detail_barang_masuk_model->total_perbarang_kode_po($this->input->post('kode_barang'), $this->input->post('kode_po'));
        if($jumlah_barang_masuk >=  $jumlah_stok){
            $status_po = 'Finish';
        }else{
            $status_po = 'Pengiriman';
        }

        $data_po = array(
            'status' => $status_po
        );

        $this->purchase_order_model->update_by_kode_barang($this->input->post('kode_po'), $this->input->post('kode_barang'), $data_po);

        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $this->detail_barang_masuk_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

 

}