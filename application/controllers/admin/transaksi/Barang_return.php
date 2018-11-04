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
 * @property  detail_barang_masuk_model $detail_barang_masuk_model
 * @property  barang_masuk_model $barang_masuk_model
 */
class Barang_return extends Admin_Controller
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
        $this->load->model('gudang_model');
        $this->load->model('barang_return_model');
        $this->load->model('stok_fisik_model');
        $this->load->model('detail_barang_masuk_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        $this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Barang_return_view');
    }

    public function get_data_all(){

        $list = $this->barang_return_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->nomor_invoice;
            $row[] = $dt->keterangan;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_barang('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$dt->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_barang_masuk('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->barang_return_model->count_all(),
            "recordsFiltered" => $this->barang_return_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->barang_masuk_model->get($id);
        $data  = array(
            'id' => $data->id,
            'nomor_invoice' => $data->nomor_invoice,
            'keterangan' => $data->keterangan,
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

        $data = array(
            'nomor_invoice' => $this->input->post('nomor_invoice'),
            'keterangan' => $this->input->post('keterangan'),
            'status' => 'Return',
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $insert = $this->barang_return_model->save($data);
        $id = $this->db->insert_id();

        if($id){
            $i=0;
            foreach ($json as $ax) :
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                        $no_bukti = $this->stok_fisik_model->get_nobukti();
                        $data_detail = array(
                            'barang_masuk_id' => $id,
                            'barang_id' => $ax[2],
                            'nama_barang' => $ax[3],
                            'gudang_id' => $ax[4],
                            'nama_gudang' => $ax[5],
                            'qty' => $ax[6],
                            'expired' => $this->tanggaldb($ax[7]),
                            'no_bukti' => $no_bukti,
                            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
                            'nomor_invoice' => $this->input->post('nomor_invoice'),
                        );

                        $this->detail_barang_masuk_model->insert($data_detail);

                        $data_stok = array(
                            'no_bukti' => $no_bukti,
                            'barang_id' => $ax[2],
                            'nama_barang' => $ax[3],
                            'gudang_id' => $ax[4],
                            'nama_gudang' => $ax[5],
                            'qty' => $ax[6],
                            'keterangan' => 'Return',
                            'expired' => $this->tanggaldb($ax[7]),
                            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
                            'nomor_invoice' => $this->input->post('nomor_invoice'),
                        );
                        $this->stok_fisik_model->insert($data_stok);


                        $stok_barang = $this->stok_fisik_model->getJumlahStokBarang($ax[2]);

                        $stok_limit = $this->barang_model->get($ax[2]);
                        $jumlah_stok_limit = $stok_limit->batas_stok;

                        if($stok_barang < $jumlah_stok_limit){
                            $status = 'Stok Limit';
                        }else{
                            $status = 'Stok Baik';
                        }

                        $data_barang = array(
                            'status_stok' => $status
                        );

                        $this->barang_model->update_by_id(array('id' => $ax[2]), $data_barang);

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
            'nomor_invoice' => $this->input->post('nomor_invoice'),
            'keterangan' => $this->input->post('keterangan'),
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $this->barang_masuk_model->update_by_id(array('id' => $this->input->post('id')), $data);

        $datay = $this->detail_barang_masuk_model->getDataByTransaksi($this->input->post('id'));
        foreach ($datay as $rw) :
            //$this->detail_barang_masuk_model->delete($rw['id']);
        
            $data_detail = array(
                            'nomor_invoice' => $this->input->post('nomor_invoice'),
                            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
                        );
                        $this->detail_barang_masuk_model->update_by_id(array('id' => $rw['id']), $data_detail);

        endforeach;

        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $datay = $this->detail_barang_masuk_model->getDataByTransaksi($id);
        foreach ($datay as $rw) :
            $this->detail_barang_masuk_model->delete($rw['id']);
        endforeach;

        $this->barang_masuk_model->delete($id);
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