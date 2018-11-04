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
class Mutasi_barang extends Admin_Controller
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
        $this->render('admin/laporan/Laporan_mutasi_view');
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
        //echo $jenis;
        $tanggal_awal_stok = date('Y-m-d',strtotime('-1 days', strtotime($this->tanggaldb($tgl_awal))));
        //$data  = $this->laporan_stok_model->getdata($this->tanggaldb($tgl_awal),$this->tanggaldb($tgl_akhir));
        
        $i=0;

        $this->load->library('fpdf');
        $pdf = new FPDF('L','mm',"A4");
        $pdf->Open();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetMargins(1,1,1);

        $pdf->SetFont('Times','BU',14);
        $pdf->Cell(0,5,"LAPORAN MUTASI BARANG ",0,1,'C');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0,5,"            Periode : " . $tgl_awal ." s/d " .$tgl_akhir  ,0,1,'C');
        $pdf->SetFont('Times','BI',12);
        $pdf->Ln(2);
        
        $pdf->Ln(5);
        $pdf->setX(5);
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(10,10,"No",1,0,'C');
        $pdf->Cell(25,10,"Kode Barang",1,0,'C');
        $pdf->Cell(100,10,"Nama Barang",1,0,'C');
        $pdf->Cell(20,10,"Satuan",1,0,'C');
        $pdf->Cell(20,10,"Stok Awal",1,0,'C');
        $pdf->Cell(20,10,"Masuk",1,0,'C');
        $pdf->Cell(20,10,"Keluar",1,0,'C');
        $pdf->Cell(20,10,"Stok Akhir",1,1,'C');
        $i = 1;
        $grand_total_stok_awal = 0;
        $grand_total_masuk = 0;
        $grand_total_keluar = 0;
        $grand_total_stok_akhir = 0;
        $data_jenis_barang = $this->barang_model->get_jenis_barang();
        foreach ($data_jenis_barang as $key) {
            $kode_jenis = $key['kode'];

            $data_barang = $this->laporan_mutasi_model->get_stok_barang($kode_jenis);
            $sub_total_stok_awal = 0;
            $sub_total_masuk = 0;
            $sub_total_keluar = 0;
            $sub_total_stok_akhir = 0;
            foreach($data_barang as $row){

                $id_barang = $row['id_barang'];
                $kode = $row['kode'];
                $nama = $row['nama'];
                $satuan = $row['satuan'];
                
                $data_stok_awal = $this->laporan_mutasi_model->get_stok_barang_awal($id_barang, $tanggal_awal_stok);
                $data_masuk = $this->laporan_mutasi_model->get_jumlah_barang_masuk($id_barang, $this->tanggaldb($tgl_awal), $this->tanggaldb($tgl_akhir));
                $data_keluar = $this->laporan_mutasi_model->get_jumlah_barang_keluar($id_barang, $this->tanggaldb($tgl_awal), $this->tanggaldb($tgl_akhir));
                $data_stok_akhir = $this->laporan_mutasi_model->get_stok_barang_awal($id_barang, $this->tanggaldb($tgl_akhir));
               // print_r($data_stok);
               // die();
                $pdf->setX(5);
                $pdf->Cell(10,10,$i,1,0,'R');
                $pdf->Cell(25,10,$kode,1,0,'L');
                $pdf->Cell(100,10,$nama,1,0,'L');
                $pdf->Cell(20,10,$satuan,1,0,'L');
                $pdf->Cell(20,10,number_format((($data_stok_awal)?$data_stok_awal:'0'),0,",","."),1,0,'R');
                $pdf->Cell(20,10,number_format((($data_masuk)?$data_masuk:'0'),0,",","."),1,0,'R');
                $pdf->Cell(20,10,number_format((($data_keluar)?$data_keluar:'0'),0,",","."),1,0,'R');
                $pdf->Cell(20,10,number_format((($data_stok_akhir)?$data_stok_akhir:'0'),0,",","."),1,1,'R');
                $sub_total_stok_awal = $sub_total_stok_awal + $data_stok_awal;
                $sub_total_masuk = $sub_total_masuk + $data_masuk;
                $sub_total_keluar = $sub_total_keluar + $data_keluar;
                $sub_total_stok_akhir = $sub_total_stok_akhir + $data_stok_akhir;
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
                $merk = "Pesona Sagara";
            }else if ($kode_jenis == 'F') {
                $merk = "Kotoderm";
            }else{
                $merk = "Lain lain";
            }
            $pdf->setX(5);
            $pdf->Cell(155,10,"Sub Total Merk ".$merk,1,0,'C');
            $pdf->Cell(20,10,number_format((($sub_total_stok_awal)?$sub_total_stok_awal:'0'),0,",","."),1,0,'R');
            $pdf->Cell(20,10,number_format((($sub_total_masuk)?$sub_total_masuk:'0'),0,",","."),1,0,'R');
            $pdf->Cell(20,10,number_format((($sub_total_keluar)?$sub_total_keluar:'0'),0,",","."),1,0,'R');
            $pdf->Cell(20,10,number_format((($sub_total_stok_akhir)?$sub_total_stok_akhir:'0'),0,",","."),1,1,'R');
            $grand_total_stok_awal = $grand_total_stok_awal + $sub_total_stok_awal;
            $grand_total_masuk = $grand_total_masuk + $sub_total_masuk;
            $grand_total_keluar = $grand_total_keluar + $sub_total_keluar;
            $grand_total_stok_akhir = $grand_total_stok_akhir + $sub_total_stok_akhir;
        }
        $pdf->setX(5);
        $pdf->Cell(155,10,"Grand Total ",1,0,'C');
        $pdf->Cell(20,10,number_format((($grand_total_stok_awal)?$grand_total_stok_awal:'0'),0,",","."),1,0,'R');
        $pdf->Cell(20,10,number_format((($grand_total_masuk)?$grand_total_masuk:'0'),0,",","."),1,0,'R');
        $pdf->Cell(20,10,number_format((($grand_total_keluar)?$grand_total_keluar:'0'),0,",","."),1,0,'R');
        $pdf->Cell(20,10,number_format((($grand_total_stok_akhir)?$grand_total_stok_akhir:'0'),0,",","."),1,1,'R');

        
        

        $pdf->SetFont('arial','',10);
        $pdf->Output();
        
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