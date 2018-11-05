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
class Barang_masuk extends Admin_Controller
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
        $this->load->model('barang_masuk_model');
        $this->load->model('stok_model');
        $this->load->model('detail_barang_masuk_model');
    }

    public function index()
    {
        $this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->render('admin/transaksi/Barang_masuk_view');
    }

    public function get_data_all(){

        $list = $this->barang_masuk_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->nomor_referensi;
            $row[] = $dt->jenis_trans;
            /*
            $row[] = $dt->kode_barang;
            $row[] = $dt->nama_barang;
            $row[] = $dt->qty;
            */
            $row[] = $dt->keterangan;

                $row[] = '
                  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="detail_barang_masuk('."'".$dt->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            
           
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->barang_masuk_model->count_all(),
            "recordsFiltered" => $this->barang_masuk_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->barang_masuk_model->get_by_id($id);
       // print_r($data);
       // die();
        $data  = array(
            'id' => $data->id,
            'nomor_referensi' => $data->nomor_referensi,
            'jenis_trans' => $data->jenis_trans,
            'kode_barang' => $data->nama_barang,
            'qty' => $data->qty,
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
        $id = md5('barang-masuk'.$this->input->post('nomor_referensi').date('YmdHis'));
        $tanggal_asli = explode("-",$this->tanggaldb($this->input->post('tanggal')));
        
        $jumlah_masuk = $this->barang_masuk_model->total_masuk_perbulan_tahun($tanggal_asli[1],$tanggal_asli[0]); 
        
        if($jumlah_masuk == 0){
            $jumlah = 1;
            $kode_awal = "00001";
        }else{
            $jumlah = $jumlah_masuk + 1;

            if(strlen($jumlah_masuk) == 1 ){
                $kode_awal = "0000".$jumlah;
            }else if(strlen($jumlah_masuk) == 2){
                $kode_awal = "000".$jumlah;
            }else if(strlen($jumlah_masuk) == 3){
                $kode_awal = "00".$jumlah;
            }else if(strlen($jumlah_masuk) == 4){
                $kode_awal = "0".$jumlah;
            }else {
                $kode_awal = $jumlah;
            }
        }

        $kode = $kode_awal."/BM/".$tanggal_asli[1]."/".$tanggal_asli[0];

        $data = array(
            'id' => $id,
            'kode_barang_masuk' => $kode,
            'nomor_referensi' => $this->input->post('nomor_referensi'),
            'keterangan' => $this->input->post('keterangan'),
            'jenis_trans' => $this->input->post('jenis_trans'),
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $insert = $this->barang_masuk_model->save($data);
        // /$id = $this->db->insert_id();

        if($id){
            $i=0;
            foreach ($json as $ax) :
                if(!is_object($ax)){
                    if(is_string($ax[0])){
                        $id_detail = md5($ax[2].$ax[4].'detail_masuk'.date('YmdHis'));
                        //$no_bukti = $this->stok_fisik_model->get_nobukti();
                        //$kode_barang = substr($ax[3], 0,5);
                        $kode_barang = explode("-", $ax[3]);
                        $data_detail = array(
                            'id_barang_masuk' => $id,
                            'id' => $id_detail,
                            'nomor_referensi' => $this->input->post('nomor_referensi'),
                            'kode_barang' => $kode_barang[0],
                            'nama_barang' => $kode_barang[1],
                            'qty' => $ax[4],
                            'keluar' => 0,
                            'expired' => $this->tanggaldb($ax[5])
                                                    );

                        $this->detail_barang_masuk_model->insert($data_detail);

                        $stok_barang = $this->stok_model->total_perbarang($kode_barang[0]);

                        $stok_limit = $this->barang_model->total_limit_perbarang($kode_barang[0]);

                        if($stok_barang + $ax[4] < $stok_limit){
                            $status = 'Stok Limit';
                        }else{
                            $status = 'Stok Baik';
                        }
                        
                        $data_stok = array(
                            'status_stok' => $status,
                            'qty' => $stok_barang + $ax[4]
                        );

                        $this->stok_model->update_by_kode($kode_barang[0], $data_stok);
                        
                        
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

    public function cetak()
    {

        $id = $this->input->get('id');
//$tgl_akhir = $this->input->get('tgl_awal');
        //echo $jenis;
        //$data  = $this->laporan_stok_model->getdata($this->tanggaldb($tgl_awal),$this->tanggaldb($tgl_akhir));
        $data_barang_masuk = $this->detail_barang_masuk_model->cetak_detail_barang_masuk($id);
       
        $this->load->library('fpdf');
        $pdf = new FPDF('P','mm',"A4");
        $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->Ln(10);
        $pdf->setX(5);
        $pdf->SetFont('Times','B',10);
        


        foreach($data_barang_masuk as $row){
            $pdf->setX(5);
            $pdf->Cell(30,10,"No. Bukti",1,0,'C');
            $pdf->Cell(100,10,"Nama Barang",1,0,'C');
            $pdf->Cell(20,10,"Satuan",1,0,'C');
            $pdf->Cell(20,10,"QTY",1,0,'C');
            $pdf->Cell(20,10,"EXPIRED",1,1,'C');

            $no_bukti = $row['no_bukti'];
            $nama_barang = $row['nama_barang'];
            $satuan = $row['satuan'];
            $kode = $row['kode'];
            $qty = $row['qty'];
            $expired = $row['expired'];

            $pdf->setX(5);
            $pdf->Cell(30,10,$no_bukti,1,0,'L');
            $pdf->Cell(100,10,$kode.'-'.$nama_barang,1,0,'L');
            $pdf->Cell(20,10,$satuan,1,0,'L');
            $pdf->Cell(20,10,$qty,1,0,'R');
            $pdf->Cell(20,10,$expired,1,1,'C');

            $pdf->Ln(3);

        }
        /*
        $pdf->SetWidths(array(10,50,25));
        $pdf->SetAligns(array('C','L','R'));
        $pdf->SetBorders(array('LR','LR','LR'));
        */
        $i = 1;
        $grand_total = 0;
        $pdf->SetFont('Times','',10);
            
        /*
        if(count($data)<10){
            for($j=$i;$j<11;$j++){
                $pdf->RowBorder(array('','','','','','','',''));
            }
        }
        */

        

        $pdf->SetFont('arial','',10);
        $pdf->Output();
    }


}