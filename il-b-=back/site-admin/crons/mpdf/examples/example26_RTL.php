<?php


$html = '
<style>
body { font-family: \'DejaVu Sans Condensed\'; font-size: 15px;  }
div.mpdf_index_main {
	font-family: xbriyaz;
}
div.mpdf_index_entry {
	font-family: xbriyaz;
}
div.mpdf_index_letter {
	font-family: xbriyaz;
}
</style>
<body dir="rtl">

<h1>mPDF שלום חוזה</h1>

<h1>כותרת גודל 1</h1>

<h2>כותרת גודל 2</h2>

<h3 style="color:red;">כותרת גודל 3</h3>

<p>
שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..שלום שלום שלום..
</p>

</body>




';

//==============================================================
	// Set Header and Footer
	$h = array (
  'odd' => 
  array (
    'R' => 
    array (
      'content' => '{PAGENO}',
      'font-size' => 8,
      'font-style' => 'B',
    ),
    'L' => 
    array (
      'content' => "שמאל ראש",
      'font-size' => 8,
      'font-style' => 'B',
    ),
    'line' => 1,
  ),
  'even' => 
  array (
    'L' => 
    array (
      'content' => '{PAGENO}',
      'font-size' => 8,
      'font-style' => 'B',
    ),
    'R' => 
    array (
      'content' => "ימין ראש",
      'font-size' => 8,
      'font-style' => 'B',
    ),
    'line' => 1,
  ),
);

	$f = array (
  'odd' => 
  array (
    'L' => 
    array (
      'content' => '{DATE Y-m-d}',
      'font-size' => 8,
      'font-style' => 'BI',
    ),
    'C' => 
    array (
      'content' => '- {PAGENO} -',
      'font-size' => 8,
    ),
    'R' => 
    array (
      'content' => "ימין למטה",
      'font-size' => 8,
    ),
    'line' => 1,
  ),
  'even' => 
  array (
    'L' => 
    array (
      'content' => "שמאל למטה",
      'font-size' => 8,
      'font-style' => 'B',
    ),
    'C' => 
    array (
      'content' => '- {PAGENO} -',
      'font-size' => 8,
    ),
    'R' => 
    array (
      'content' => '{DATE Y-m-d}',
      'font-size' => 8,
      'font-style' => 'BI',
    ),
    'line' => 1,
  ),
);

//==============================================================
// Create Index entries from random words in $html
	// Split $html into words

//==============================================================
//==============================================================
include("../mpdf.php");


$mpdf=new mPDF('','A4','','',32,25,27,25,16,13); 

$mpdf->SetDirectionality('rtl');
//$mpdf->mirrorMargins = true;
//$mpdf->SetDisplayMode('fullpage','two');

//$mpdf->autoLangToFont = true;
$mpdf->setHeader($h);
$mpdf->setFooter($f);

//$mpdf->debug = true;

//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);
//$mpdf->AddPage();
$mpdf->Output();
//$mpdf->Output('mtpdf.pdf','F');
//exit("done");
//==============================================================
//==============================================================
//==============================================================


?>