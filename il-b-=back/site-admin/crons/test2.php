<?php
exit("hi how are you");

//-------------------------------------------------------------------------//
// Author : Rodolphe MOULIN
// Project on : 
// Create : 19/10/2011
// Version 1.0
//
// This file allows you to write in Hebrew on a PDF document generated with FPDF library.
// This file no allows to write hebrew with quamatz, dagesh or other vocalisation.
// This code can work immediately with the font provided. You can generate a different form. Read the read me to understand how.
// File create with notepad++ encoding : utf8 without BOM
// Police take on this website : http://www.freelang.com/polices/index.php
//-------------------------------------------------------------------------//
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// En-tête
function Header()
{
  
	
}
// Pied de page
function Footer()
{
 
}

}
// Instanciation de la classe dérivée
$pdf = new FPDF();
$titre = heb_for_pdf("עברית וזה");
$pdf->SetTitle($titre);
$pdf->SetAuthor('Rodolphe MOULIN');
$pdf->AddFont('IsmarLight','','0f10394e3d986a7522b311a304309b90_ismal___.php'); //Insert font hebrew
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->SetFont('Arial','',0);
function heb_for_pdf($t_h){
	//Goal : To view the Hebrew, find the ASCII code of each letter of the Font
	//$t_h = "בדיקה בדיקה בדיקה"; //exemple Genèse 1:1
	$t_h_t = wordwrap($t_h,1,", ,",false); //To cut word by word
	$t_h_t = wordwrap($t_h_t,2,",",true);	//To cut letter by letter
	$t_h_e = explode(",",$t_h_t);	//Create table befor analyse
	$texte_hebrew="";	//initiate hebrew sentance
	for($i_h=0;$i_h<count($t_h_e);$i_h++)
	{
		if($t_h_e[$i_h]=="א") 
			$t_h_e[$i_h] = 224; 
		if($t_h_e[$i_h]=="ב") 
			$t_h_e[$i_h] = 225; 
		if($t_h_e[$i_h]=="ג") 
			$t_h_e[$i_h] = 226; 
		if($t_h_e[$i_h]=="ד") 
			$t_h_e[$i_h] = 227; 
		if($t_h_e[$i_h]=="ה") 
			$t_h_e[$i_h] = 228; 
		if($t_h_e[$i_h]=="ו") 
			$t_h_e[$i_h] = 229; 
		if($t_h_e[$i_h]=="ז") 
			$t_h_e[$i_h] = 230; 
		if($t_h_e[$i_h]=="ח") 
			$t_h_e[$i_h] = 231; 
		if($t_h_e[$i_h]=="ט") 
			$t_h_e[$i_h] = 232; 
		if($t_h_e[$i_h]=="י") 
			$t_h_e[$i_h] = 233; 
		if($t_h_e[$i_h]=="ך") 
			$t_h_e[$i_h] = 234; 
		if($t_h_e[$i_h]=="כ") 
			$t_h_e[$i_h] = 235; 
		if($t_h_e[$i_h]=="ל") 
			$t_h_e[$i_h] = 236; 
		if($t_h_e[$i_h]=="ם") 
			$t_h_e[$i_h] = 237; 
		if($t_h_e[$i_h]=="מ") 
			$t_h_e[$i_h] = 238; 
		if($t_h_e[$i_h]=="ן") 
			$t_h_e[$i_h] = 239; 
		if($t_h_e[$i_h]=="נ") 
			$t_h_e[$i_h] = 240; 
		if($t_h_e[$i_h]=="ס") 
			$t_h_e[$i_h] = 241; 
		if($t_h_e[$i_h]=="ע") 
			$t_h_e[$i_h] = 242; 
		if($t_h_e[$i_h]=="ף") 
			$t_h_e[$i_h] = 243; 
		if($t_h_e[$i_h]=="פ") 
			$t_h_e[$i_h] = 244; 
		if($t_h_e[$i_h]=="ץ") 
			$t_h_e[$i_h] = 245; 
		if($t_h_e[$i_h]=="צ") 
			$t_h_e[$i_h] = 246; 
		if($t_h_e[$i_h]=="ק") 
			$t_h_e[$i_h] = 247; 
		if($t_h_e[$i_h]=="ר") 
			$t_h_e[$i_h] = 248; 
		if($t_h_e[$i_h]=="ש") 
			$t_h_e[$i_h] = 249; 
		if($t_h_e[$i_h]=="ת") 
			$t_h_e[$i_h] = 250; 
		if($t_h_e[$i_h]==" ") 
			$t_h_e[$i_h] = 160;
		
		
		if (is_int($t_h_e[$i_h]))
			$texte_hebrew = chr($t_h_e[$i_h]).$texte_hebrew;
	}
	return $texte_hebrew;
}

$pdf->SetFont('IsmarLight','',0);
$pdf->MultiCell(180,10,heb_for_pdf("מה המצב אחי"),0,'R');
$pdf->SetFont('Arial','',0);
$pdf->MultiCell(180,10,$t_f,0,'R');
$pdf->Ln(4);


$pdf->Output();
?>