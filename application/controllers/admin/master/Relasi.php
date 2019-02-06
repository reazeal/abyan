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
class Relasi extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        //if (!$this->ion_auth->in_group('admin')) {
        //    redirect('auth/session_not_authorized', 'refresh');
        //}
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('relasi_model');
    }

    public function index()
    {
        $this->render('admin/master/Relasi_view');
    }

    public function get_data_all(){

        $list = $this->relasi_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            //$row[] = $this->tanggal($dt->tgl);
            $row[] = $dt->id;
            $row[] = $dt->nama_relasi;
            $row[] = $dt->jenis;
            $row[] = $dt->alamat_relasi;
            $row[] = $dt->nomor_telp;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_relasi('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_relasi('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->relasi_model->count_all(),
            "recordsFiltered" => $this->relasi_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->relasi_model->get($id);
        $data  = array(
            'id' => $data->id,
            'kode_relasi' => $data->kode_relasi,
            'nama_relasi' => $data->nama_relasi,
            'alamat_relasi' => $data->alamat_relasi,
            'nomor_telp' => $data->nomor_telp,
            'jenis' => $data->jenis,
            
          //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add()
    {

        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'id' => md5('relasi'.$this->input->post('nama').$this->input->post('kode').date('YmdHis')),
            'nama_relasi' => $this->input->post('nama'),
            'kode_relasi' => $this->input->post('kode'),            
            'alamat_relasi' => $this->input->post('alamat'),
            'nomor_telp' => $this->input->post('nomor_telp'),
            'jenis' => $this->input->post('jenis'),
            //'tgl' => $this->tanggaldb($this->input->post('tgl'))
        );
        $insert = $this->relasi_model->save($data);       

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $datax  = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $data = array(
            'nama_relasi' => $this->input->post('nama'),
            'kode_relasi' => $this->input->post('kode'),            
            'alamat_relasi' => $this->input->post('alamat'),
            'nomor_telp' => $this->input->post('nomor_telp'),
            'jenis' => $this->input->post('jenis'),
            //'tgl' => $this->tanggaldb($this->input->post('tgl'))
        );
        $this->relasi_model->update_by_id(array('id' => $this->input->post('id')), $data);


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

        $this->relasi_model->delete_by_id($id);
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