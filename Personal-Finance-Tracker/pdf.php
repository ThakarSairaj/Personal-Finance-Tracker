<?php
require('FPDF/fpdf.php');
$obj = new FPDF();
$obj -> AddPage();
$obj -> setFont('Arial','B',16);
$obj -> cell (60,10,'Hello PHP',1);
$obj -> output();

?>