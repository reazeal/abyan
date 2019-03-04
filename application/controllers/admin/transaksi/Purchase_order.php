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
class Purchase_order extends Admin_Controller
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
        $this->load->model('supplier_model');
        $this->load->model('purchase_order_model');
        
        $this->load->model('detail_purchase_order_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        $this->data['pilihan_supplier'] = $this->supplier_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Purchase_order_view');
    }

    public function get_data_all(){

        $list = $this->purchase_order_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->kode_po;
            $row[] = $dt->kode_supplier;
            $row[] = $dt->nama_supplier;
            $row[] = $dt->top;
            $row[] = $dt->status;
            
            if($dt->status == 'Selesai'){
                $row[] = ' <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_po('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                 ';
            }else{
                $row[] = ' <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_po('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
                 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_po('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';                
            }


            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->purchase_order_model->count_all(),
            "recordsFiltered" => $this->purchase_order_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_detail($id)
    {
        $data  = array(
            'detailPo'=> (array) $this->detail_purchase_order_model->getByNoPo($id)
        );
        echo json_encode(array($data));
    }
    public function edit($id)
    {
        $data = $this->purchase_order_model->get_by_id_detail($id);
        $data  = array(
            'id' => $data->id,
            'id_po' => $data->id_po,
            'kode_po' => $data->kode_po,
            'nama_supplier' => $data->nama_supplier,
            'nama_barang' => $data->nama_barang,
            'kode_barang' => $data->kode_barang,
            'kode_supplier' => $data->kode_supplier,
            'qty' => $data->qty,
            'harga' => $data->harga,
            'top' => $data->top,
            'bottom_retail' => $data->bottom_retail,
            'bottom_supplier' => $data->bottom_supplier,
            'tanggal' => $this->tanggal($data->tanggal),
           // 'detailBarangMasuk'=> (array) $this->detail_barang_masuk_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        echo $this->input->post('nama_suplier');

        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);
        $id_rand = rand(1,100);
        $id = md5($id_rand.'purchaseorder'.$this->input->post('nama_suplier').date('YmdHis'));
        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));
        
        $jumlah_po = $this->purchase_order_model->total_po_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
        
        if($jumlah_po == 0){
            $jumlah = 1;
            $kode_awal = "001";
        }else{
            $jumlah = $jumlah_po + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        
        $kode = $kode_awal."/PO/".$tanggal_asli[1]."/".$tanggal_asli[0];

        $supplier = $this->supplier_model->get_by_kode($this->input->post('nama_supplier'));
        
        $data = array(
            'id' => $id,
            'kode_po' => $kode,
            'kode_supplier' => $this->input->post('nama_supplier'),
            'top' => $this->input->post('top'), 
            'status' => 'Proses',
            'nama_supplier' => $supplier->nama_supplier,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'created_at' => date("Y-m-d H:i:s"),

        );
        $insert = $this->purchase_order_model->save($data);
        // /$id = $this->db->insert_id();

        if($id){
            $i=0;
            foreach ($json as $ax) :
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                        $id_detail = md5($ax[1].$ax[2].'purchaseorder'.date('YmdHis'));
                        //$no_bukti = $this->stok_fisik_model->get_nobukti();
                        //$kode_barang = substr($ax[3], 0,5);
                       
                        $kode_barang = explode("-", $ax[3]);
                        $data_detail = array(
                            //'id_barang_masuk' => $id,
                            'id' => $id_detail,
                            'kode_po' => $kode,
                            'kode_barang' => $kode_barang[0],
                            'nama_barang' => $kode_barang[1],
                            'qty' => $ax[4],
                            'harga' => $ax[5],
                            'bottom_retail' => $ax[7],
                            'bottom_supplier' => $ax[8],
                            'status' => 'Proses',
                                                    );

                        $this->detail_purchase_order_model->insert($data_detail);
                        
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
            'qty' => $this->input->post('qty')
        );
        $this->detail_purchase_order_model->update_by_id(array('id' => $this->input->post('id')), $data);

        
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        
        $data = $this->purchase_order_model->get_by_id_po($id);
        $this->detail_purchase_order_model->delete_by_no_po($data->kode_po);
        $this->purchase_order_model->delete_by_id($id);
        
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