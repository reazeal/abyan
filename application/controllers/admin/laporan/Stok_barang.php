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
class Stok_barang extends Admin_Controller
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
        $this->render('admin/laporan/Laporan_stok_view');
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
        $jenis = $this->input->get('jenis');
        $gudang = $this->input->get('gudang');
//$tgl_akhir = $this->input->get('tgl_awal');
        //echo $jenis;
        //$data  = $this->laporan_stok_model->getdata($this->tanggaldb($tgl_awal),$this->tanggaldb($tgl_akhir));
        $data_jenis_barang = $this->barang_model->get_jenis_barang();
       
        $i=0;

        $this->load->library('fpdf');
        $pdf = new FPDF('P','mm',"A4");
        $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->SetFont('Times','BU',14);
        $pdf->Cell(0,5,"LAPORAN STOK BARANG ".$jenis,0,1,'C');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0,5,"            Tanggal : " . $tgl_awal ,0,1,'C');
        $pdf->SetFont('Times','BI',12);
        $pdf->Ln(2);
        
        $pdf->Ln(5);
        $pdf->setX(5);
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(10,10,"No",1,0,'C');
        $pdf->Cell(25,10,"Kode Barang",1,0,'C');
        $pdf->Cell(100,10,"Nama Barang",1,0,'C');
        $pdf->Cell(20,10,"Satuan",1,0,'C');
        $pdf->Cell(20,10,"Gudang",1,0,'C');
        $pdf->Cell(20,10,"Stok",1,1,'C');
        /*
        $pdf->SetWidths(array(10,50,25));
        $pdf->SetAligns(array('C','L','R'));
        $pdf->SetBorders(array('LR','LR','LR'));
        */
        $i = 1;
        $grand_total = 0;
        $pdf->SetFont('Times','',10);
        foreach ($data_jenis_barang as $jenis) {
            $kode_jenis = $jenis['kode'];
            $data_barang = $this->barang_model->get_all_barangxx($jenis, $kode_jenis, $gudang);
            $sub_total = 0;
            
            foreach($data_barang as $row){

                $kode = $row['kode'];
                $nama = $row['nama'];
                $satuan = $row['satuan'];
                $qty = $row['qty'];
                $nama_gudang = $row['nama_gudang'];
                $sub_total = $sub_total + $qty;
                $pdf->setX(5);
                $pdf->Cell(10,10,$i,1,0,'R');
                $pdf->Cell(25,10,$kode,1,0,'L');
                $pdf->Cell(100,10,$nama,1,0,'L');
                $pdf->Cell(20,10,$satuan,1,0,'L');
                $pdf->Cell(20,10,$nama_gudang,1,0,'L');
                $pdf->Cell(20,10,number_format((($qty)?$qty:'0'),0,",","."),1,1,'R');
                $i++;
            }

            if($kode_jenis == 'A'){
                $merk = "Theraskin";
            }else if($kode_jenis == 'B'){
                $merk = "Hi-Derm";
            }else if($kode_jenis == 'C'){
                $merk = "Immortal";
            }else if($kode_jenis == 'D'){
                $merk = "Primadera";
            }else if($kode_jenis == 'E'){
                $merk = "Pesona  Sagara";
            }else if ($kode_jenis == 'F') {
                $merk = "Kotoderm";
            }else{
                $merk = "Lain lain";
            }

            $pdf->setX(5);
            $pdf->Cell(175,10,"Sub Total ".$merk,1,0,'L');
            $pdf->Cell(20,10,number_format((($sub_total)?$sub_total:'0'),0,",","."),1,1,'R');
            $grand_total = $grand_total + $sub_total;
        }

        $pdf->setX(5);
        $pdf->Cell(175,10,"Grand Total ",1,0,'L');
        $pdf->Cell(20,10,number_format((($grand_total)?$grand_total:'0'),0,",","."),1,1,'R');
            
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