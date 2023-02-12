<?php

include("../mpdf.php");
//$mpdf=new mPDF('utf-8-s'); 

//$mpdf->autoScriptToLang();
//require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new mPDF('utf-8');

$mpdf->SetDirectionality('rtl');
$mpdf->WriteHTML('<h1 lang="he">sssשדגשדגשדג</h1>');
$mpdf->Output();