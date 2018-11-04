<?php
header('Content-type: application/x-pdf');
require_once "../libs/dbxCore.php";
require('draw.php');
require("barcode.inc.php");
$page=new Libs_EDP('../');
$con=$page->koneksi_mysql();
$bar= new BARCODE();


$arr_village = explode(',', $_POST['no_kik_gbj']);
$count = count($arr_village) - 1;

$dt=array();
for($i=1; $i<=$count; $i++) {
$no++;
$nokik=$arr_village[$i]; 
$tmp=explode("-",$nokik);
$no_kik_baru = $tmp[1]."-".$tmp[0];

$query = "SELECT
  b.kode_brg,
  b.spek_1,
  b.spek_2,
  b.kode_prod,
  CONCAT(spek_1,' ',spek_2,' ',merk_brg) AS brg,
  c.nm_klpwrn,
  SUBSTR(b.kode_brg,4,2) AS JNS
FROM master_kik_gbj a
  INNER JOIN master_barang b
    ON a.id_brg = b.id_brg
  LEFT JOIN master_klpwrn c
    ON c.id_klpwrn = a.id_klpwrn
WHERE a.no_kik_gbj='" . $nokik . "'";

$rs=$page->data($query,$con);
$kode_brg=$rs->Fields('kode_brg');
$spek_1=$rs->Fields('spek_1');
$spek_2=$rs->Fields('spek_2');
$nm_klpwrn=$rs->Fields('nm_klpwrn');
$a1 = $rs->Fields('JNS');
$kode_prod=$rs->Fields('kode_prod');
$nmwrn=$a1."-".$spek_1." ".$nm_klpwrn;
	
	if ($kode_prod=='T-81') { $a1='02'; }
	if ($kode_prod=='T-82') { $a1='01'; }
	if ($kode_prod=='T-83') { $a1='05'; }
	if ($kode_prod=='T-88') { $a1='19'; }
	
	  $dt[$no][1]=$nokik;
      $dt[$no][2]=$no_kik_baru;
      $dt[$no][3]=$nmwrn;
	  $dt[$no][4]=$a1."-".$spek_1." ".$spek_2." ".$nm_klpwrn;
}




$encode='CODE128';
$bar->setSymblogy($encode);
$bar->setHeight(20);
$bar->setFont("arial");
$bar->setScale(5);
$bar->setHexColor('#000000','#FFFFFF');

	
$orientasi='P';
$kertas="A4";
//$kertas=array(54.5,23);

$pdf = new PDF_Draw($orientasi,"mm",$kertas);
$pdf->SetFont('arial', '', 9);




$image_height = 35;
$image_width = 28;
$row_height = 3; // set the default


foreach($dt as $value => $yoyo){

$barnumber=trim($dt[$value][1]);

$q_cek_cetak = "SELECT status_cetak FROM master_kik_gbj WHERE no_kik_gbj='" . $barnumber . "' ";
$rsxx=$page->data($q_cek_cetak,$con);
$status_cetak=$rsxx->Fields('status_cetak');


$barnumber=trim($dt[$value][1]);
$text1=$dt[$value][3];
$kik_anyar = $dt[$value][2];
$text1 = $dt[$value][4];
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



 $pdf->Cell(0, 0, '', 0, 1);
 
$return = $bar->genBarCode($barnumber,'jpg',"$barnumber");
$start_x = $pdf->GetX();
$start_y = $pdf->GetY();

   // place image and move cursor to proper place. "+ 5" added for buffer
$pdf->Image("$barnumber.jpg",$pdf->GetX(),$pdf->GetY(), $image_height, $image_width); 
$pdf->SetXY($start_x,$start_y+$image_height+5);
$aa=$pdf->GetX();
$pdf->Text($pdf->GetX(), $pdf->GetY()+2, $aa);


//$pdf->Image("$barnumber.jpg",5,0.1,52,40);
/**
$pdf->RotatedImage("$barnumber.jpg",4,0.2,51,40,5);
$pdf->Rect(0.1, 0.1, 54, 18, '', '', array(220, 220, 200));
$pdf->Line(4, 0.2, 9, 18, '');
$pdf->Circle(4,9.2,1.4);
//$pdf->Image('logo.jpg',10,1.3,10,16);
$pdf->SetFont('arial', '', 9);
$pdf->Text(9, 17, $kik_anyar);
$pdf->SetFont('arial', '', 6);
$pdf->RotatedText(28,14,$text1,5);
//$pdf->Text(30, 16, $text1);
$pdf->RotatedImage('logo.jpg',53,13,5,8,270);
**/
/**
 $pisahin=explode("-",$barnumber);
	  $kikasli= $pisahin[0];
	  $cek_kar=strlen($kikasli);
	  
	    if ($cek_kar=='6'){
		    $al=substr($kikasli,2,1);
			if($al=='A' or $al=='M'){$mo_ang="01";}
      		if($al=='B' or $al=='N'){$mo_ang="02";}
      		if($al=='C' or $al=='O'){$mo_ang="03";}
      		if($al=='D' or $al=='P'){$mo_ang="04";}
      		if($al=='E' or $al=='Q'){$mo_ang="05";}
      		if($al=='F' or $al=='R'){$mo_ang="06";}
      		if($al=='G' or $al=='S'){$mo_ang="07";}
      		if($al=='H' or $al=='T'){$mo_ang="08";}
      		if($al=='I' or $al=='U'){$mo_ang="09";}
      		if($al=='J' or $al=='V'){$mo_ang="10";}
      		if($al=='K' or $al=='W'){$mo_ang="11";}
      		if($al=='L' or $al=='X'){$mo_ang="12";}
			
			if($al=='Y'){$mo_ang="PA";}
      		if($al=='Z'){$mo_ang="PB";}
		} elseif ($cek_kar=='4') {
			$mo_ang = "";
		}
		
if ( ($mo_ang=="PA") or ($mo_ang=="PB")  ){
	$text1=$dt[$value][4];
} else {
	$text1=$dt[$value][3];
}
**/
/**
$pdf->Image("$barnumber.jpg",20,0.2,35,25);
$pdf->Rect(0.2, 0.2, 54, 18, '', '', array(220, 220, 200));
$pdf->Line(9, 0.2, 9, 18, '');
$pdf->Circle(5,9.2,1.4);
$pdf->Image('logo.jpg',10,1.3,10,16);
$pdf->SetFont('arial', '', 9);
$pdf->Text(30, 12, $kik_anyar);
$pdf->SetFont('arial', '', 6);
$pdf->Text(22, 16, $text1);
**/
/**
$pdf->Image("$barnumber.jpg",20,0.2,35,28);
$pdf->Rect(0.2, 0.2, 54, 18, '', '', array(220, 220, 200));
$pdf->Line(9, 0.2, 9, 18, '');
$pdf->Circle(5,9.2,1.4);
$pdf->Image('logo.jpg',10,1.3,10,16);
$pdf->SetFont('arial', 'B', 9);
$pdf->Text(30, 13, $dt[$value][2]);
$pdf->SetFont('arial', 'B', 6);
$pdf->Text(22, 16, $text1);
$pdf->SetFont('arial', 'BI', 7);
//$pdf->Text(50, 17.5,  $mo_ang);
$pdf->Image("potong-disini.JPG",0.2,20.5,54,3);
**/
/**
$pdf->RotatedImage("$barnumber.jpg",4,0.2,51,40,5);
$pdf->Rect(0.1, 0.1, 54, 18, '', '', array(220, 220, 200));
$pdf->Line(5, 0.2, 9, 18, '');
$pdf->Circle(5,9.2,1.4);
$pdf->Image('logo.jpg',10,1.3,10,16);
$pdf->SetFont('arial', '', 9);
$pdf->Text(9, 17, $kik_anyar);
$pdf->SetFont('arial', '', 6);
$pdf->RotatedText(28,14,$text1,5);
//$pdf->RotatedImage('logo.jpg',53,13,5,8,270);
//$pdf->RotatedImage('bunder2.jpg',30,14,15,4,'');
//$pdf->RotatedImage('sas.jpg',40,13,5,5,'');
//$pdf->RotatedImage('mbul.jpg',2,12,5,5,'');
**/
//}


}
$pdf->SetDisplayMode(100);
$pdf->Output();
  
?>
