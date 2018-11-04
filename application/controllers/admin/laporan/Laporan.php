<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  ion_auth $ion_auth
 * @property  postal $postal
 * @property  petugas_model $petugas_model
 * @property  laporan_model $laporan_model
 * @property  pemasangan_model $pemasangan_model
 * @property  pendaftaran_model $pendaftaran_model
 */
class Laporanxxx extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
        if(!$this->ion_auth->in_group('admin'))
        {
			if(!$this->ion_auth->in_group('operator')){
				$this->postal->add('You are not allowed to visit the Contents page','error');
				redirect('admin','refresh');
			}
            
        }

		$this->load->model('laporan_model');
		$this->load->model('pemasangan_model');
		$this->load->model('pendaftaran_model');
        $this->load->library('form_validation');
		$this->load->library('databaseLoader');
		//$this->load->library('fpdf');
        $this->load->helper('text');
        $this->load->helper('url','html','form');
	}


    public function generate()
    {
        $message =array();
		$date = date("Ymd");
        $id = $this->input->post('datanya');
        $get_isi = $this->laporan_model->where(array('id'=>$id))->get();
        if(!empty($get_isi)){
            $no_seri = $get_isi->no_seri;
            $tanggal_awal = $get_isi->tanggal_awal;
            $tanggal_akhir = $get_isi->tanggal_akhir;
            $no_pendaftaran = $get_isi->no_pendaftaran;
            $email = $get_isi->email;
			$id_permintaan = md5('11laporan__22'.$no_pendaftaran.'qqperiodeww'.$tanggal_awal.$tanggal_akhir.'aasszzxx'.$no_seri.$date);
            $data = $this->laporan_model->generate($no_seri, $tanggal_awal, $tanggal_akhir, $id_permintaan, $id );

		$berita = "Silakan klik ";		
		$link = "http://localhost/animasi_client/real.php?data_imei=$id_permintaan";
		$berita = $berita ."\n".$link;
	$pesan = str_replace ("\n","<br>","$berita");
	$subjek = "Laporan tracking kendaraan per tanggal $tanggal_awal sampai $tanggal_akhir";	
	$kepada = $email;
            $this->email->from('contoh.santana@gmail.com', 'Laporan');
            $this->email->to($kepada);
            $this->email->subject($subjek);
            $this->email->message($pesan);
            $this->email->send();
	


            $message = array(
                'success' => true,
                'info' => 'Berhasil digenerate'
            );

        }else{
            $message = array(
                'success' => false,
                'info' => 'No Pendaftaran tidak ada'
            );
        }

        echo json_encode($message,JSON_PRETTY_PRINT);
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


    public function cetak_laporan()
    {

        $id = $this->input->get('id');
        $get_isi = $this->laporan_model->where(array('id'=>$id))->get();

        if(!empty($get_isi)) {
            $no_seri = $get_isi->no_seri;
            $tanggal_awal = $get_isi->tanggal_awal;
            $tanggal_akhir = $get_isi->tanggal_akhir;
            $no_pendaftaran = $get_isi->no_pendaftaran;
            $email = $get_isi->email;

            $filex = str_replace('/','_',$no_pendaftaran);
            $File = $filex.".pdf";

            $get_isi_daftar = $this->pendaftaran_model->where(array('no_pendaftaran'=>$no_pendaftaran))->get();

            $kertas=array(210,320);
            $this->load->library('fpdf');
            $pdf = new FPDF('P','mm','A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(0,5,"Laporan Jarak Harian  : ",0,1,'C');
            $pdf->Cell(0,5,"Tgl. Awal: ".$tanggal_awal." s/d Tgl. Akhir : ".$tanggal_akhir,0,1,'C');
            $pdf->Ln(5);
            $pdf->Cell(30,5,"No. Pendaftaran",0,0,'L');
            $pdf->Cell(2,5,":",0,0,'C');
            $pdf->Cell(112,5,$no_pendaftaran,0,1,'L');

            $pdf->Cell(30,5,"Nama Pelanggan",0,0,'L');
            $pdf->Cell(2,5,":",0,0,'C');
            $pdf->Cell(30,5,$get_isi_daftar->nama,0,0,'L');
            $pdf->Cell(50,5,"",0,0,'L');
            $pdf->Cell(30,5," ",0,0,'L');
            $pdf->Cell(2,5,"",0,0,'C');
            $pdf->Cell(30,5,"",0,1,'L');

            $pdf->Ln(5);
            $pdf->Cell(10,5,'No',1,0,'C');
            $pdf->Cell(30,5,'Nopol',1,0,'C');
            $pdf->Cell(30,5,'Tanggal',1,0,'C');
            $pdf->Cell(40,5,'Total Jarak',1,0,'C');
            $pdf->Cell(40,5,'Rata-Rata Jarak',1,1,'C');

            $i = 1;
            $j=0;
            $get_isi_pemasangan = $this->pemasangan_model->where(array('no_seri'=>$no_seri))->get();

            $data = $this->pemasangan_model->getDataByNoSeri($no_seri);

            if (!empty($get_isi_pemasangan)) {

                foreach($data as $hasil){
                    $now = strtotime(date("Y-m-d"));
                    $date = date('Y-m-d', strtotime('+1 day', $now));
                    $x = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
                    $bulantahun = date("m-Y", $x);
                    $bulantahunlaporan = date("Y-m", $x);
                    $nopol = $hasil['nopol'];

                    for($a=1;$a<=31;$a++){
                        $pdf->Cell(10,5,$i,1,0,'C');
                        $pdf->Cell(30,5,$nopol,1,0,'C');
                        $pdf->Cell(30,5,$a.'-'.$bulantahun,1,0,'C');
                        $tanggal = $bulantahunlaporan.'-'.$a;

                        $data_lap = $this->pemasangan_model->getDataLaporan($tanggal,$nopol);
                        if(!empty($data_lap)){
                            foreach ($data_lap as $axx) :
                                $jarak = $axx['jarak'];
                                $pdf->Cell(40,5,$jarak,1,0,'C');
                            endforeach;
                        }else{
                            $pdf->Cell(40,5,'0',1,0,'C');
                        }
                        $pdf->Cell(40,5,'0',1,1,'C');
                        $i = $i + 1;
                    }

                    if($pdf->GetY()>200){
                        //$t->Rect(10,33,157,235);
                        $pdf->AddPage();

                        if  ($pdf->PageNo()>1)
                        {
                            $pdf->SetFont('Times','B',10);
                            $pdf->Cell(0,5,"Laporan Jarak Harian  : ",0,1,'C');
                            $pdf->Cell(0,5,"Tgl. Awal: ".$tanggal_awal." s/d Tgl. Akhir : ".$tanggal_akhir,0,1,'C');
                            $pdf->Ln(5);
                            $pdf->Cell(30,5,"No. Pendaftaran",0,0,'L');
                            $pdf->Cell(2,5,":",0,0,'C');
                            $pdf->Cell(112,5,$no_pendaftaran,0,1,'L');

                            $pdf->Cell(30,5,"Nama Pelanggan",0,0,'L');
                            $pdf->Cell(2,5,":",0,0,'C');
                            $pdf->Cell(30,5,$get_isi_daftar->nama,0,0,'L');
                            $pdf->Cell(50,5,"",0,0,'L');
                            $pdf->Cell(30,5," ",0,0,'L');
                            $pdf->Cell(2,5,"",0,0,'C');
                            $pdf->Cell(30,5,"",0,1,'L');

                            $pdf->Ln(5);
                            $pdf->Cell(10,5,'No',1,0,'C');
                            $pdf->Cell(30,5,'Nopol',1,0,'C');
                            $pdf->Cell(30,5,'Tanggal',1,0,'C');
                            $pdf->Cell(40,5,'Total Jarak',1,0,'C');
                            $pdf->Cell(40,5,'Rata-Rata Jarak',1,1,'C');

                        }
                    }

                    $j++;
                }
            }


            $pdf->SetDisplayMode(100);
            $pdf->Output();

        }else{
            $this->noData();
        }
    }


    public function sendLaporan()
    {
        $message =array();
		$date = date("Ymd");
        $errInfo = "";
        $id = $this->input->post('datanya');

        $datanya = $this->input->post('datanya');
        $data  = array();
        $json = json_decode($datanya);

        foreach ($json as $ax) :
            $get_isi = $this->laporan_model->where(array('id'=>$ax))->get();

            if(!empty($get_isi)) {
                $no_seri = $get_isi->no_seri;
                $tanggal_awal = $get_isi->tanggal_awal;
                $tanggal_akhir = $get_isi->tanggal_akhir;
                $no_pendaftaran = $get_isi->no_pendaftaran;
                $email = $get_isi->email;

                $filex = str_replace('/','_',$no_pendaftaran);
                $File = $filex.".pdf";

                $get_isi_daftar = $this->pendaftaran_model->where(array('no_pendaftaran'=>$no_pendaftaran))->get();

                $kertas=array(210,320);
                $this->load->library('fpdf');
                $pdf = new FPDF('P','mm','A4');
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont('Times','B',10);
                $pdf->Cell(0,5,"Laporan Jarak Harian  : ",0,1,'C');
                $pdf->Cell(0,5,"Tgl. Awal: ".$tanggal_awal." s/d Tgl. Akhir : ".$tanggal_akhir,0,1,'C');
                $pdf->Ln(5);
                $pdf->Cell(30,5,"No. Pendaftaran",0,0,'L');
                $pdf->Cell(2,5,":",0,0,'C');
                $pdf->Cell(112,5,$no_pendaftaran,0,1,'L');

                $pdf->Cell(30,5,"Nama Pelanggan",0,0,'L');
                $pdf->Cell(2,5,":",0,0,'C');
                $pdf->Cell(30,5,$get_isi_daftar->nama,0,0,'L');
                $pdf->Cell(50,5,"",0,0,'L');
                $pdf->Cell(30,5," ",0,0,'L');
                $pdf->Cell(2,5,"",0,0,'C');
                $pdf->Cell(30,5,"",0,1,'L');

                $pdf->Ln(5);
                $pdf->Cell(10,5,'No',1,0,'C');
                $pdf->Cell(30,5,'Nopol',1,0,'C');
                $pdf->Cell(30,5,'Tanggal',1,0,'C');
                $pdf->Cell(40,5,'Total Jarak',1,0,'C');
                $pdf->Cell(40,5,'Rata-Rata Jarak',1,1,'C');

                $i = 1;
                $j=0;
                $get_isi_pemasangan = $this->pemasangan_model->where(array('no_seri'=>$no_seri))->get();

                $data = $this->pemasangan_model->getDataByNoSeri($no_seri);

                if (!empty($get_isi_pemasangan)) {

                    foreach($data as $hasil){
                        $now = strtotime(date("Y-m-d"));
                        $date = date('Y-m-d', strtotime('+1 day', $now));
                        $x = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
                        $bulantahun = date("m-Y", $x);
                        $bulantahunlaporan = date("Y-m", $x);
                        $nopol = $hasil['nopol'];

                      //  for($a=1;$a<=31;$a++){
                            $pdf->Cell(10,5,$i,1,0,'C');
                            $pdf->Cell(30,5,$nopol,1,0,'C');
                            // $pdf->Cell(30,5,$a.'-'.$bulantahun,1,0,'C');
                            $pdf->Cell(30,5,$bulantahun,1,0,'C');
                            $tanggal = $bulantahunlaporan.'-'.$a;

                            $data_lap = $this->pemasangan_model->getDataLaporan($bulantahunlaporan,$nopol);
                            if(!empty($data_lap)){
                                foreach ($data_lap as $axx) :
                                    $jarak = $axx['jarak'];
                                    $pdf->Cell(40,5,$jarak,1,0,'C');
                                endforeach;
                            }else{
                                $pdf->Cell(40,5,'0',1,0,'C');
                            }
                            $pdf->Cell(40,5,'0',1,1,'C');
                         //   $i = $i + 1;
                       // }

                        if($pdf->GetY()>200){
                            //$t->Rect(10,33,157,235);
                            $pdf->AddPage();

                            if  ($pdf->PageNo()>1)
                            {
                                $pdf->SetFont('Times','B',10);
                                $pdf->Cell(0,5,"Laporan Jarak Harian  : ",0,1,'C');
                                $pdf->Cell(0,5,"Tgl. Awal: ".$tanggal_awal." s/d Tgl. Akhir : ".$tanggal_akhir,0,1,'C');
                                $pdf->Ln(5);
                                $pdf->Cell(30,5,"No. Pendaftaran",0,0,'L');
                                $pdf->Cell(2,5,":",0,0,'C');
                                $pdf->Cell(112,5,$no_pendaftaran,0,1,'L');

                                $pdf->Cell(30,5,"Nama Pelanggan",0,0,'L');
                                $pdf->Cell(2,5,":",0,0,'C');
                                $pdf->Cell(30,5,$get_isi_daftar->nama,0,0,'L');
                                $pdf->Cell(50,5,"",0,0,'L');
                                $pdf->Cell(30,5," ",0,0,'L');
                                $pdf->Cell(2,5,"",0,0,'C');
                                $pdf->Cell(30,5,"",0,1,'L');

                                $pdf->Ln(5);
                                $pdf->Cell(10,5,'No',1,0,'C');
                                $pdf->Cell(30,5,'Nopol',1,0,'C');
                                $pdf->Cell(30,5,'Tanggal',1,0,'C');
                                $pdf->Cell(40,5,'Total Jarak',1,0,'C');
                                $pdf->Cell(40,5,'Rata-Rata Jarak',1,1,'C');

                            }
                        }

                        $j++;
                    }
                }

                $filename=FCPATH."uploads/".$File;
                $pdf->Output($filename,'F');


                $berita = "Berikut Attachment Laporan Kendaraan.";
                $berita = $berita . "\n";
                $pesan = str_replace("\n", "<br>", "$berita");
                $subjek = "Laporan tracking kendaraan per tanggal $tanggal_awal sampai $tanggal_akhir";
                $kepada = $email;
				$this->email->from('info@smk.center', 'Laporan');
                $this->email->to($kepada);
                $this->email->subject($subjek);
                $this->email->message($pesan);
                $this->email->attach($filename);
                $this->email->send();

                $errInfo .= "ID: $ax Berhasil digenerate. <br>";

            }else{
                $errInfo .= "ID: $ax No Pendaftaran tidak ada. <br>";
            }

        endforeach;


        $message = array(
            'success' => true,
            'info' => $errInfo
        );

        echo json_encode($message,JSON_PRETTY_PRINT);
    }

	public function get_gen_no_komplain(){
			$no_mut2 = "";
			$bulan=date('m');
			$tahun=substr(date('Y'), -2);

			if($bulan=='01'){$no_mut2="I";}
		    if($bulan=='02'){$no_mut2="II";}
		    if($bulan=='03'){$no_mut2="III";}
		    if($bulan=='04'){$no_mut2="IV";}
		    if($bulan=='05'){$no_mut2="V";}
		    if($bulan=='06'){$no_mut2="VI";}
		    if($bulan=='07'){$no_mut2="VII";}
		    if($bulan=='08'){$no_mut2="VIII";}
		    if($bulan=='09'){$no_mut2="IX";}
		    if($bulan=='10'){$no_mut2="X";}
		    if($bulan=='11'){$no_mut2="XI";}
		    if($bulan=='12'){$no_mut2="XII";}


			$nomor=$no_mut2."/".$tahun;
			$datanya = $this->komplain_model->get_nomor($nomor);
			$no_urut = $datanya+1;
		    $no_bukti=substr("000000",0,6-strlen($no_urut)).$no_urut."/KOMPLAIN/".$no_mut2."/".$tahun;
			
			echo $no_bukti;
	}
	
	public function index()
	{
		$this->data['menu_data'] = array('master'=>false,'transaksi'=>true,'class_master'=>'collapse','class_transaksi'=>'in');
		$this->data['pilihan_nopol'] = $this->laporan_model->get_data_kendaraan();
        $this->render('admin/laporan/index_view');
	}

	public function get_gen_kode(){

			$datanya = $this->petugas_model->get_nomor();
			$no_urut = $datanya+1;
			$no_bukti= "TRX".substr("0000",0,4-strlen($no_urut)).$no_urut;
			
			echo $no_bukti;
	}

	public function get_id(){
		
		$id = $this->input->post('datanya');		
		$datanya = $this->laporan_model->get_id($id);
		

		echo json_encode($datanya,JSON_PRETTY_PRINT);
	}

	

	public function get_data_laporan(){

		 $search = $this->input->get('search');
		 $sort = $this->input->get('sort');
		 $order = $this->input->get('order');
		 $limit = $this->input->get('limit');
		 $offset = $this->input->get('offset');

		 $datanya = $this->laporan_model->get_data_laporan($search, $sort, $order, $limit, $offset);
		 echo json_encode($datanya,JSON_PRETTY_PRINT);
	}

    public function create()
    {
		$message = array();
		
		$tahun=date("Y-m-d h:i:s a");
		
		$tanggal = $this->tanggaldb($this->input->post('tanggal'));
		$tanggal_awal = $this->datetimedb($this->input->post('tanggal_awal'));
		$tanggal_akhir = $this->datetimedb($this->input->post('tanggal_akhir'));
		$no_pendaftaran = $this->input->post('no_pendaftaran');
		$nopol = $this->input->post('nopol');
		$no_seri = $this->input->post('no_seri');
		$email = $this->input->post('email');
		$id = md5('laporan_'.date('Y-m-d H:i:s').$tanggal.$no_pendaftaran.$tanggal_awal.$tanggal_akhir.$tahun);
		//$id = '2';
		
			
		if(!empty($id) ){
			$insert_content = array(
				'id' => $id,
				'tanggal' => $tanggal,
				'no_pendaftaran' => $no_pendaftaran,
				'tanggal_awal' => $tanggal_awal,
				'tanggal_akhir' => $tanggal_akhir,	
				'nopol' => $nopol,	
				'no_seri' => $no_seri,	
				'email' => $email,	
				'status' => 'Belum'	
			);

			$this->laporan_model->insert($insert_content);
			
			$message = array(
			   'success' => true,
			   'info' => 'Berhasil disimpan'
			);
       
		}else{
			$message = array(
			   'success' => false,
			   'info' => 'Gagal disimpan'
			);
		}
		

		echo json_encode($message,JSON_PRETTY_PRINT); 
    }

   
    public function delete()
    {

		$datanya = $this->input->post('datanya');
		$data  = array();
		$json = json_decode($datanya);
		
		foreach ($json as $ax) :
			$deleted_pages = $this->komplain_model->where(array('komplain_id'=>$ax))->delete();
		endforeach;
		
		
		$message = array(
			   'success' => true,
			   'info' => 'Berhasil dihapus'
			);
		echo json_encode($message,JSON_PRETTY_PRINT); 
    }

	public function delete_id()
    {

		$datanya = $this->input->post('datanya');
		$deleted_pages = $this->komplain_model->where(array('komplain_id'=>$datanya))->delete();
		
		$message = array(
			   'success' => true,
			   'info' => 'Berhasil dihapus'
			);

		echo json_encode($message,JSON_PRETTY_PRINT); 
    }

	public function update()
    {
		
		$komplain_id = $this->input->post('komplain_id');
		
		$tanggal = $this->tanggaldb($this->input->post('tanggal'));
		$pemasangan_id = $this->input->post('pemasangan_id');
		$no_pendaftaran = $this->input->post('no_pendaftaran');
		$nama = $this->input->post('nama');
		$problem = $this->input->post('problem');
		$nomor_seri = $this->input->post('nomor_seri');
		
		$message = array();

		
		
		if(!empty($komplain_id) && !empty($tanggal) && !empty($pemasangan_id) && !empty($problem)){
			$update_content = array('tanggal' => $tanggal, 'pemasangan_id' => $pemasangan_id, 'problem' => $problem);
			$this->komplain_model->update($update_content, array('komplain_id'=>$komplain_id));
			//$this->pendaftaran_model->update($update_content, $no_pendaftaran);
			//$this->pendaftaran_model->where(array('no_pendaftaran'=>$no_pendaftaran))->update($update_content,'no_pendaftaran');
			$message = array(
			   'success' => true,
			   'info' => 'Berhasil disimpan'
			);
       
		}else{
			$message = array(
			   'success' => false,
			   'info' => 'Gagal disimpan'
			);
		}
		

		echo json_encode($message,JSON_PRETTY_PRINT); 


    }



}
