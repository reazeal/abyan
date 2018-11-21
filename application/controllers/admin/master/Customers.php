<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hqeem
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  customer_model $customer_model
 */
class Customers extends Admin_Controller
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
        $this->load->model('customer_model');
    }

    public function index()
    {
        $this->render('admin/master/Customers_view');
    }

    public function get_data_all(){

        $list = $this->customer_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $dt->kode_customer;
            $row[] = $dt->nama_customer;
            $row[] = $dt->jenis;
            $row[] = $dt->alamat_customer;
            $row[] = $dt->no_telp;

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_customers('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_customers('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customer_model->count_all(),
            "recordsFiltered" => $this->customer_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->customer_model->get_by_id($id);
        $data  = array(
            'id' => $data->id,
            'kode_customer' => $data->kode_customer,
            'nama_customer' => $data->nama_customer,
            'alamat_customer' => $data->alamat_customer,
            'jenis' => $data->jenis,
            'no_telp' => $data->no_telp,
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        //$datax  = $this->input->post('dataDetail');
//        $json = json_decode($datax);

        $jumlah_cust = $this->customer_model->total_cust(); 
        
        if($jumlah_cust == 0){
            $jumlah = 1;
            $kode_awal = "00001";
        }else{
            $jumlah = $jumlah_cust + 1;

            if(strlen($jumlah) == 1 ){
                $kode_awal = "000".$jumlah;
            }else if(strlen($jumlah) == 2){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah) == 1){
                   $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $i = rand(1,100);
        $data = array(
            'id' => md5('customer'.date("YmdHis").$this->input->post('kode_customer').$this->input->post('nama_customer').$i),
            'kode_customer' => "C".$kode_awal,
            'nama_customer' => $this->input->post('nama_customer'),
            'alamat_customer' => $this->input->post('alamat_customer'),
            'jenis' => $this->input->post('jenis'),
            'no_telp' => $this->input->post('no_telp')
        );
        $insert = $this->customer_model->save($data);
        $id = $this->db->insert_id();

        // Matikan Kalau tidak ada detail
        /*if($id){
            $i=0;
            foreach ($json as $ax) :
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                        $data_detail = array(
                            'id_barang' => $id,
                            'barang' => $ax[1]
                        );
                        $this->detail_barang_model->insert($data_detail);
                    }
                }
                $i++;
            endforeach;
        }*/

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'nama_customer' => $this->input->post('nama_customer'),
            'alamat_customer' => $this->input->post('alamat_customer'),
            'jenis' => $this->input->post('jenis'),
            'no_telp' => $this->input->post('no_telp')
        );
        $this->customer_model->update_by_id(array('id' => $this->input->post('id')), $data);

        // Matikan kalau tidak ada Detail.

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
                            'barang' => $ax[1]
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
        // Matikan kalau tidak ada detail
        /*$datay = $this->detail_barang_model->getDataByTransaksi($id);
        foreach ($datay as $rw) :
            $this->detail_barang_model->delete($rw['id']);
        endforeach;*/

        $this->customer_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


}