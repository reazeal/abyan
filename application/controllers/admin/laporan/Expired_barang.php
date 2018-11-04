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
 * @property  barang_keluar_model $barang_keluar_model
 * @property  barang_masuk_model $barang_masuk_model
 * @property  rak_model $rak_model
 * @property  stok_fisik_model $stok_fisik_model
 * @property  laporan_model $laporan_model
 */
class Expired_barang extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('laporan_model');
        $this->load->model('laporan_stok_model');
        $this->load->model('laporan_mutasi_model');
        $this->load->model('barang_model');
        $this->load->model('barang_keluar_model');
        $this->load->model('barang_masuk_model');
        $this->load->model('stok_fisik_model');
        $this->load->model('rak_model');
        $this->load->helper('text');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->render('admin/laporan/Laporan_expired_view');
    }

    function noData(){
        $this->load->library('fpdf');
        $pdf = new FPDF('P','cm',"Legal");
        $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->Ln(4);
        $pdf->SetFont('arial','B',11);
        $pdf->Cell(19.2,0.5,"MOHON MAAF DATA TIDAK TERSEDIA",'',0,'C');
        $pdf->Output();
    }

    public function cetak()
    {

        
        
        $i=1;

        $this->load->library('fpdf');
        $pdf = new FPDF('P','mm',"A4");
        $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->SetFont('Times','BU',14);
        
        $data_expired = $this->stok_fisik_model->getStokExpired();

        if($data_expired == null ){
            $this->noData();
        }else{

        
            

            $pdf->Cell(0,5,"LAPORAN EXPIRED BARANG ",0,1,'C');
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(0,5,"            Per Tanggal : " . date("d-m-Y"),0,1,'C');
            $pdf->SetFont('Times','BI',12);
            $pdf->Ln(2);
            
            $pdf->Ln(5);
            $pdf->setX(5);
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(10,10,"No",1,0,'C');
            $pdf->Cell(100,10,"Nama Barang",1,0,'C');
            $pdf->Cell(40,10,"Nama Gudang",1,0,'C');
            $pdf->Cell(20,10,"Expired",1,0,'C');
            $pdf->Cell(20,10,"Qty",1,1,'C');
            
            $pdf->SetFont('Times','',10);

            foreach ($data_expired as $key) {
                
                $nama_barang = $key['nama_barang'];
                $nama_gudang = $key['nama_gudang'];
                $qty = $key['qty'];
                $expired = $key['expired'];
                $pdf->setX(5);
                $pdf->Cell(10,10,$i++,1,0,'C');
                $pdf->Cell(100,10,$nama_barang,1,0,'L');
                $pdf->Cell(40,10,$nama_gudang,1,0,'L');
                $pdf->Cell(20,10,$expired,1,0,'L');
                $pdf->Cell(20,10,$qty,1,1,'R');
            

            }

            $pdf->SetFont('arial','',10);
            $pdf->Output();
            
        }
        /*
        $berita = "Berikut Attachment Laporan Kendaraan.";
        $berita = $berita . "\n";
        $pesan = str_replace("\n", "<br>", "$berita");
        $subjek = "Laporan tracking kendaraan per tanggal ";
        $kepada = 'awaluddin.rizal@gmail.com';
        $this->email->from('info@smk.center', 'Laporan');
        $this->email->to($kepada);
        $this->email->subject($subjek);
        $this->email->message($pesan);
        //$this->email->attach($filename);
        $this->email->send();
        */
    }
   


}