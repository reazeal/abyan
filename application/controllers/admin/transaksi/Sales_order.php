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
 * @property  detail_barang_masuk_model $detail_barang_masuk_model
 * @property  barang_masuk_model $barang_masuk_model
 */
class Sales_order extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        //if (!$this->ion_auth->in_group('admin')) {
        //    redirect('auth/session_not_authorized', 'refresh');
       // }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('barang_model');
        $this->load->model('stok_model');
        $this->load->model('sales_order_model');
        $this->load->model('customer_model');
        $this->load->model('detail_so_model');
        $this->load->model('piutang_model');
        $this->load->model('pegawai_model');
        $this->load->model('detail_so_model');
        $this->load->model('transaksi_biaya_model');
        $this->load->model('pengiriman_so_model');
        $this->load->model('detail_barang_masuk_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        $this->data['pilihan_customer'] = $this->customer_model->get_all();
        $this->data['pilihan_pegawai'] = $this->pegawai_model->get_all();
        //$this->data['pilihan_barang_masuk'] = $this->detail_barang_masuk_model->get_by_penerimaan();
        $this->data['pilihan_barang_masuk'] = $this->detail_barang_masuk_model->get_by_penerimaanx();
      // /  print_r($this->data['pilihan_barang_masuk']);
     //   print_r($this->data['pilihan_barang']);
        $this->render('admin/transaksi/Sales_order_view');
    }

    public function get_data_all(){

        $list = $this->sales_order_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);

            $row[] = $dt->kode_so;
            $row[] = $dt->nama_customer;
           // $row[] = $dt->kode_customer;
            /*
            $row[] = $dt->kode_barang;
            $row[] = $dt->nama_barang;
            $row[] = $dt->qty;
            $row[] = $dt->harga;
            $row[] = $dt->satuan;
            */
            $row[] = $this->tanggal($dt->tanggal_kirim);
            $row[] = $dt->kode_sales;
            $row[] = $dt->status;

            if($dt->status == 'Proses'){
                $row[] = '
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Cetak" onclick="cetak_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Cetak</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                ';
            }else{
                        $row[] = '
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Cetak" onclick="cetak_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Cetak</a>
                  
                ';
            }

             
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->sales_order_model->count_all(),
            "recordsFiltered" => $this->sales_order_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function get_detail($id_so)
    {
        $data  = array(
            'detailSo'=> (array) $this->detail_so_model->getDataByNoSOx($id_so)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);
        $i = rand(1,100);
        
        $id = md5($i.'sales-order'.$this->input->post('nama_customer').date('YmdHis'));

        $customer = explode("-",$this->input->post('nama_customer'));
/*
        $detail_customer = $this->customer_model->get_by_kode($customer);

        print_r($detail_customer);
        die();
*/
        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));
        
        $jumlah_so = $this->sales_order_model->total_so_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
        
        if($jumlah_so == 0){
            $jumlah = 1;
            $kode_awal = "001";
        }else{
            $jumlah = $jumlah_so + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $kode = $kode_awal."/SO/".$tanggal_asli[1]."/".$tanggal_asli[0];

        $data = array(
            'id' => $id,
            'kode_so' => $kode,
            'kode_customer' => $customer[0],
            'nama_customer' => $customer[1],
            'status' => 'Proses',
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'kode_sales' => $this->input->post('kode_pegawai'),
            'tanggal_kirim' => $this->tanggaldb($this->input->post('tanggal_kirim')),
            'top' => $this->input->post('top'),
            'created_at' => date("Y-m-d H:i:s"),
        );
        $insert = $this->sales_order_model->save($data);

        // get jenis customer

        $data_customer = $this->customer_model->get_by_kode($customer[0]);
        $jenis_cust = $data_customer->jenis;

        // /$id = $this->db->insert_id();
        $nominal_sales = 0;
        $nominal_cold_st = 0;
        $berat_cold_st = 0;
        if($id){
            $i=0;
            foreach ($json as $ax) :
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                        $id_detail = md5($ax[2].$ax[4].'detail_so'.date('YmdHis').$kode.$id);
                        //$no_bukti = $this->stok_fisik_model->get_nobukti();
                        //$kode_barang = substr($ax[3], 0,5);
                        $kode_barang = explode("-", $ax[3]);
                        $id_barang_masuk = $ax[2];
                        
                        $harga = $this->detail_barang_masuk_model->get_by_id($id_barang_masuk);

                        $data_detail = array(
                            'kode_so' => $kode,
                            'id' => $id_detail,
                            'kode_barang' => $kode_barang[0],
                            'nama_barang' => $kode_barang[1],
                            'qty' => $ax[4],
                            'status' => 'Proses',
                            'id_detail_barang_masuk' => $id_barang_masuk,
                            'harga' => $ax[5],
                            'harga_beli' => $harga->harga_beli
                        );
                        //echo $ax[2] .'--'. $ax[3].'--'.$ax[5].'ok';
                        if($jenis_cust == 'Customer Retail'){
                            // echo $ax[2] .'--'. $ax[5].'sini';
                            if($ax[7] < $ax[5]){
                                //bottom_retail
                                $nominal_sales = $nominal_sales + ($ax[4] * $ax[5]);
                            }
                        }else{
                            // echo $ax[2] .'--'. $ax[5].'sana';
                            if($ax[8] < $ax[5]){
                                //bottom_retail
                                $nominal_sales = $nominal_sales + ($ax[4] * $ax[5]);
                            }
                        }
                        //$nominal_sales = $nominal_sales + ($ax[4] * $ax[5]);

                        $this->detail_so_model->insert($data_detail);

                        $berat_cold_st = $berat_cold_st + $ax[4];
                        
                    }
                }
                $i++;
            endforeach;
        }

        //die();

        $data_komisi_sales = array(
            'id' => md5(rand(1, 100) . '69ea49d4740ef0b03d818f055de99b1f' . $this->input->post('tanggal') . $kode . date("YmdHis")),
            'kode_referensi' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'nominal' => $nominal_sales * 1.5 / 100,
            'id_jenis_biaya' => '69ea49d4740ef0b03d818f055de99b1f',
            'status' => 'Pending',
        );
        $this->transaksi_biaya_model->insert($data_komisi_sales);

        $data_cold_st = array(
            'id' => md5(rand(1, 100) . 'aa083acc31d09e74122a742aae63e4b1' . $this->input->post('tanggal') . $kode . date("YmdHis")),
            'kode_referensi' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'nominal' => $berat_cold_st * 900,
            'id_jenis_biaya' => 'aa083acc31d09e74122a742aae63e4b1',
            'status' => 'Pending',
        );
        $this->transaksi_biaya_model->insert($data_cold_st);

        
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'qty' => $this->input->post('qty'),
            'keterangan' => $this->input->post('keterangan')
        );
        $this->detail_barang_masuk_model->update_by_id(array('id' => $this->input->post('id')), $data);

        
        echo json_encode(array("status" => TRUE));
    }

    public function hapus_so($id)
    {   
        $data = $this->sales_order_model->get_by_idSO($id);
        $this->detail_so_model->delete_by_no_so($data->kode_so);
        $this->sales_order_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->detail_so_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'id_so' => $data->id_so,
            'kode_so' => $data->kode_so,
            'kode_barang' => $data->kode_barang,
            'nama_barang' => $data->nama_barang,
            'qty' => $data->qty,
            'harga' => $data->harga,
            'harga_beli' => $data->harga_beli,
            'bottom_retail' => $data->bottom_retail,
            'bottom_supplier' => $data->bottom_supplier,
            'id_detail_barang_masuk' => $data->id_detail_barang_masuk,
        );
        echo json_encode(array($data));
    }

    public function kirim($id)
    {
        $data = $this->detail_so_model->get_by_id_pengirimanx($id);
       // echo $data->kode_so;
        $data_kirim = $this->pengiriman_so_model->getPengirimanBySoBarang($data->kode_so, $data->kode_barang);

        $data_kirim_id = $this->pengiriman_so_model->getPengirimanByIdDetailSO($data->id);
     //   print_r($data_kirim_id);
       $jumlah_kirim = 0;
        if($data_kirim_id->kirim != 0){
                        
            $jumlah_kirim = $data_kirim_id->kirim;
        }else{
            $jumlah_kirim = $data_kirim->kirim;
        }

        $data  = array(
            'id' => $data->id,
            'id_so' => $data->id_so,
            'kode_so' => $data->kode_so,
            'kode_barang' => $data->kode_barang,
            'nama_barang' => $data->nama_barang,
            'qty' => $data->qty,
            'kirim' => $jumlah_kirim,
            'harga' => $data->harga,
            'harga_beli' => $data->harga_beli,
            'bottom_retail' => $data->bottom_retail,
            'bottom_supplier' => $data->bottom_supplier,
            'id_detail_barang_masuk' => $data->id_detail_barang_masuk,
        );
        echo json_encode(array($data));
    }
    
    public function editby_noSO($noSO)
    {
        $data = $this->detail_so_model->get_by_id($noSO);
        $data  = array(
            'id' => $data->id,
            'id_so' => $data->id_so,
            'kode_so' => $data->kode_so,
            'kode_barang' => $data->kode_barang,
            'nama_barang' => $data->nama_barang,
            'qty' => $data->qty,
            'harga' => $data->harga,
            'harga_beli' => $data->harga_beli,
            'bottom_retail' => $data->bottom_retail,
            'bottom_supplier' => $data->bottom_supplier,
            'id_detail_barang_masuk' => $data->id_detail_barang_masuk,
        );
        echo json_encode(array($data));
    }

    public function cetak_so($idx)

    {
        //echo $idx;
      //  echo $this->input->get('id');

        //echo $_GET['id'];
        $datax = $this->detail_so_model->getDataByNoSoCetak($idx);
        $so = $this->sales_order_model->get_by_idSo($idx);
        $pegawai = $this->pegawai_model->get_by_kode($so->kode_sales);
        //print_r($so);
        $so->tanggal = $this->tanggal($so->tanggal);
        $tes = 'halo';
        $data['datanya'] = $datax;
        $data['so'] = $so;
        $data['pegawai'] = $pegawai;
        $this->load->view('admin/transaksi/cetak_so',$data);

    }
    
}
