<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: pudak digital
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
class Penjualan_barang extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('sales_order_model');
        $this->load->model('detail_so_model');
        $this->load->helper('text');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->render('admin/laporan/Laporan_penjualan_view');
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

        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status = $this->input->get('status');
        
        $tanggal_awal_kemaren = date('Y-m',strtotime('-1 months', strtotime($this->tanggaldb($tgl_awal))));

        $tanggal_akhir_kemaren = date('Y-m-t', strtotime($tanggal_awal_kemaren."-01"));
        

        $i=0;

        $this->load->library('fpdf');
        $pdf = new FPDF('P','mm',"A4");
       // $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->SetFont('Times','BU',14);
        $pdf->Cell(0,5,"LAPORAN PENJUALAN Per BARANG ",0,1,'C');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0,5,"            Tanggal : " . $tgl_awal." s/d ".$tgl_akhir,0,1,'C');
        $pdf->SetFont('Times','BI',12);
        $pdf->Ln(2);
        
        $pdf->Ln(5);
        $pdf->setX(5);
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(10,10,"No",1,0,'C');
        $pdf->Cell(25,10,"Kode Barang",1,0,'C');
        $pdf->Cell(100,10,"Nama Barang",1,0,'C');
        $pdf->Cell(25,10,"Satuan",1,0,'C');
        $pdf->Cell(30,10,"Qty",1,1,'C');
        
        $i = 1;
        $data = $this->detail_so_model->get_jumlah_barang_between($this->tanggaldb($tgl_awal), $this->tanggaldb($tgl_akhir));

            foreach($data as $hasil){
                    
                $kode_barang = $hasil['kode_barang'];
                $nama_barang = $hasil['nama_barang'];
                $qty = $hasil['qty'];
                $satuan = $hasil['satuan'];

                    $pdf->setX(5);
                    $pdf->Cell(10,5,$i,1,0,'C');
                    $pdf->Cell(25,5,$kode_barang,1,0,'L');
                    $pdf->Cell(100,5,$nama_barang,1,0,'L');
                    $pdf->Cell(25,5,$satuan,1,0,'L');
                    $pdf->Cell(30,5,$qty,1,1,'R');
                    $i = $i + 1;
            }

        $pdf->SetFont('arial','',10);
        $pdf->Output();
    }
   


    public function cetak_per_faktur()
    {

        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status = $this->input->get('status');
        
        $tanggal_awal_kemaren = date('Y-m',strtotime('-1 months', strtotime($this->tanggaldb($tgl_awal))));

        $tanggal_akhir_kemaren = date('Y-m-t', strtotime($tanggal_awal_kemaren."-01"));
        

        $i=0;

        $this->load->library('fpdf');
        $pdf = new FPDF('P','mm',"A4");
       // $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->SetFont('Times','BU',14);
        $pdf->Cell(0,5,"LAPORAN PENJUALAN Per SO ",0,1,'C');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0,5,"            Tanggal : " . $tgl_awal." s/d ".$tgl_akhir,0,1,'C');
        $pdf->SetFont('Times','BI',12);
        $pdf->Ln(2);
        
        $pdf->Ln(5);
        $pdf->setX(5);
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(10,10,"No",1,0,'C');
        $pdf->Cell(25,10,"Tanggal",1,0,'C');
        $pdf->Cell(25,10,"No. SO",1,0,'C');
        $pdf->Cell(25,10,"Kode Barang",1,0,'C');
        $pdf->Cell(70,10,"Nama Barang",1,0,'C');
        $pdf->Cell(25,10,"Satuan",1,0,'C');
        $pdf->Cell(10,10,"Qty",1,1,'C');
        
        $i = 1;
        $data = $this->sales_order_model->get_so_between($this->tanggaldb($tgl_awal), $this->tanggaldb($tgl_akhir));

            foreach($data as $hasil){
                    
                $kode_barang = $hasil['kode_barang'];
                $nama_barang = $hasil['nama_barang'];
                $qty = $hasil['qty'];
                $satuan = $hasil['satuan'];
                $tanggal = $hasil['tanggal'];
                $kode_so = $hasil['kode_so'];

                    $pdf->setX(5);
                    $pdf->Cell(10,5,$i,1,0,'C');
                    $pdf->Cell(25,5,$tanggal,1,0,'L');
                    $pdf->Cell(25,5,$kode_so,1,0,'L');
                    $pdf->Cell(25,5,$kode_barang,1,0,'L');
                    $pdf->Cell(70,5,$nama_barang,1,0,'L');
                    $pdf->Cell(25,5,$satuan,1,0,'L');
                    $pdf->Cell(10,5,$qty,1,1,'R');
                    $i = $i + 1;
            }

        $pdf->SetFont('arial','',10);
        $pdf->Output();
    }
   


}