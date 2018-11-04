<?php
session_start();
require_once("../libs/dbxCore.php");
require('draw.php');
require("barcode.inc.php");
$page=new Libs_EDP('../');
$con=$page->koneksi_mysql();


$page=new Libs_EDP('../');
$bar= new BARCODE();

$dt=$_SESSION["cetak_barcode"];
$jumlah = count($dt);
$encode='CODE128';
$bar->setSymblogy($encode);
$bar->setHeight(20);
$bar->setFont("arial");
$bar->setScale(5);
$bar->setHexColor('#000000','#FFFFFF');

	
$orientasi='P';
//$kertas="A4";
//$kertas=array(240.0,450.0);
$kertas=array(225.0,279.0);
$pdf = new PDF_Draw($orientasi,"mm",$kertas);
$pdf->SetFont('arial', '', 9);



$ibarnum =0;
$X0bar = 8;
$Y0bar = 0.2;
$X0rec  = 0.2;
$Y0rec  = 0.2;
$X0Text1 = 17;
$Y0Text1 = 8;
$X0logo = 1;
$Y0logo = 0.5;
$X0Text2 = 10;
$Y0Text2 = 12;


$X=$X0bar;
$Y=$Y0bar;

$Xrec=$X0rec;
$Yrec=$Y0rec;

$Xtext1=$X0Text1;
$Ytext1=$Y0Text1;

$Xlogo=$X0logo;
$Ylogo=$Y0logo;

$Xtext2=$X0Text2;
$Ytext2=$Y0Text2;

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AcceptPageBreak();
foreach($dt as $value => $k){

$ibarnum++;
$cek_mod=$ibarnum%5;
$cek_mod_hal = $ibarnum%55;

$barnumber=$dt[$value][1];
$return = $bar->genBarCode($barnumber,'jpg',"$barnumber");


if ($cek_mod=='0'){
$X=$X0bar;
$Y=$Y+20;

$Xrec=$X0rec;
$Yrec=$Yrec+20;

$Xtext1=$X0Text1;
$Ytext1=$Ytext1+20;

$Xlogo=$X0logo;
$Ylogo=$Ylogo+20;

$Xtext2=$X0Text2;
$Ytext2=$Ytext2+20;

$pdf->Image("$barnumber.jpg",$X,$Y,35,15);
$pdf->Rect($Xrec, $Yrec, 42, 13, '', '', array(220, 220, 200));	
$pdf->SetFont('arial', 'B', 9);
$pdf->Text($Xtext1, $Ytext1, $dt[$value][2]); 
$pdf->Image('logo.jpg',$Xlogo,$Ylogo,8,12);
$pdf->SetFont('arial', 'B', 6);
$pdf->Text($Xtext2, $Ytext2, $dt[$value][4]); 

} else {

$X = $X+45;
$Xrec = $Xrec+45;
$Xtext1 = $Xtext1+45;
$Xlogo = $Xlogo+45;
$Xtext2 = $Xtext2+45;

$pdf->Image("$barnumber.jpg",$X,$Y,35,15);
$pdf->Rect($Xrec, $Yrec, 42, 13, '', '', array(220, 220, 200));	
$pdf->SetFont('arial', 'B', 9);	
$pdf->Text($Xtext1, $Ytext1, $dt[$value][2]); 
$pdf->Image('logo.jpg',$Xlogo,$Ylogo,8,12);
$pdf->SetFont('arial', 'B', 6);
$pdf->Text($Xtext2, $Ytext2, $dt[$value][4]); 
	
}

if ($cek_mod_hal=='0'){
$pdf->AddPage();	
}

$q_cek_cetak = "SELECT status_cetak FROM master_kik_gbj WHERE no_kik_gbj='" . $barnumber . "' ";
$rsxx=$page->data($q_cek_cetak,$con);
$status_cetak=$rsxx->Fields('status_cetak');

if ($barnumber){
$jml_cetak = $status_cetak+1;
$q_cek_cetak_insert = "UPDATE master_kik_gbj SET status_cetak='".$jml_cetak."' WHERE no_kik_gbj='" . $barnumber . "' ";
$page->insert($q_cek_cetak_insert,$con);	


$q_get_motif="
		 SELECT CONCAT(b.spek_1,' ',b.spek_2) AS motif, c.nm_klpwrn
		 FROM master_kik_gbj a
		  INNER JOIN master_barang b
		  ON a.id_brg=b.id_brg
		  INNER JOIN master_klpwrn c
  		  ON a.id_klpwrn=c.id_klpwrn
		WHERE no_kik_gbj='" . $barnumber . "'
		";
		 $rsy=$page->data($q_get_motif,$con);
		 $motif=$rsy->Fields('motif');
		 $nama_warna=$rsy->Fields('nm_klpwrn');
		 

		 $tgl_log_kik = DATE('Y-m-d');
		 $q_insert_log = "INSERT INTO log_kik_gbj (no_kik_gbj,tgl_log_kik_gbj,motif_asal,motif_baru,warna_asal,warna_baru,tgl_cetak) 
		 VALUES('" . $barnumber . "','" . $tgl_log_kik . "','" . $motif . "','" . $motif . "','" . $nama_warna . "','" . $nama_warna . "','" . $tgl_log_kik . "')";
		 $page->insert($q_insert_log,$con);		

}

   
}

$pdf->SetDisplayMode(100);
$pdf->Output();
//unset($_SESSION['cetak_barcode']);
?>
