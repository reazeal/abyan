<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hqeem
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  detail_barang_model $detail_barang_model
 */
class Supplier extends Admin_Controller
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
        $this->load->model('supplier_model');
    }

    public function index()
    {
        $this->render('admin/master/Supplier_view');
    }

    public function get_data_all(){

        $list = $this->supplier_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            //$row[] = $this->tanggal($dt->tgl);
            $row[] = $dt->kode_supplier;
            $row[] = $dt->nama_supplier;
            $row[] = $dt->alamat_supplier;
            $row[] = $dt->nomor_telp;
            $row[] = $dt->keterangan;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_supplier('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_supplier('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->supplier_model->count_all(),
            "recordsFiltered" => $this->supplier_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->supplier_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'kode_supplier' => $data->kode_supplier,
            'nama_supplier' => $data->nama_supplier,
            'alamat_supplier' => $data->alamat_supplier,
            'nomor_telp' => $data->nomor_telp,
            'keterangan' => $data->keterangan,
            
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $jumlah_sup = $this->supplier_model->total_sup(); 
        
        if($jumlah_sup == 0){
            $jumlah = 1;
            $kode_awal = "001";
        }else{
            $jumlah = $jumlah_sup + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }



        $data = array(
            'id' => md5('supplier'.$this->input->post('nama').$this->input->post('kode').date('YmdHis')),
            'nama_supplier' => $this->input->post('nama'),
            'kode_supplier' => "S".$kode_awal,            
            'alamat_supplier' => $this->input->post('alamat'),
            'nomor_telp' => $this->input->post('nomor_telp'),
            'keterangan' => $this->input->post('keterangan'),
            //'tgl' => $this->tanggaldb($this->input->post('tgl'))
        );
        $insert = $this->supplier_model->save($data);       

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $data = array(
            'nama_supplier' => $this->input->post('nama'),
            'alamat_supplier' => $this->input->post('alamat'),
            'nomor_telp' => $this->input->post('nomor_telp'),
            'keterangan' => $this->input->post('keterangan'),
        );
        $this->supplier_model->update_by_id(array('id' => $this->input->post('id')), $data);


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

        $this->supplier_model->delete_by_id($id);
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