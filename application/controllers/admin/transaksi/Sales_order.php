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
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
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
         $this->load->model('detail_barang_masuk_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        $this->data['pilihan_customer'] = $this->customer_model->get_all();
        $this->data['pilihan_pegawai'] = $this->pegawai_model->get_all();
        $this->data['pilihan_barang_masuk'] = $this->detail_barang_masuk_model->get_by_penerimaan();
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
            $row[] = $dt->status;
            /*
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_so('."'".$dt->id_detail."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                  <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit" onclick="kirim_so('."'".$dt->id_detail."'".')"><i class="glyphicon glyphicon-check"></i> Kirim</a>';
           */
                     $row[] = '
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_so('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                ';
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
            'detailSo'=> (array) $this->detail_so_model->getDataByNoSO($id_so)
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

            if(strlen($jumlah_so) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah_so) == 2){
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
            'tanggal_kirim' => $this->tanggaldb($this->input->post('tanggal_kirim')),
            'top' => $this->input->post('top')
        );
        $insert = $this->sales_order_model->save($data);
        // /$id = $this->db->insert_id();
        $nominal_piutang = 0;
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

                        $nominal_piutang = $nominal_piutang + ($ax[4] * $ax[5]);

                        $this->detail_so_model->insert($data_detail);

                        
                        
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

        $data = array(
            'qty' => $this->input->post('qty'),
            'keterangan' => $this->input->post('keterangan')
        );
        $this->detail_barang_masuk_model->update_by_id(array('id' => $this->input->post('id')), $data);

        
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $this->detail_barang_masuk_model->delete_by_id($id);
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
        );
        echo json_encode(array($data));
    }


}