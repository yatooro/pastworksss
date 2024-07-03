<?php
session_start();
require('fpdf/fpdf.php');

require_once 'db_config.php';


$sql = "SELECT * FROM transactions ORDER BY date ASC";
$result = mysqli_query($conn, $sql);

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Transaction Log PDF',0,1,'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage('L', 'A4', 0);
$pdf->SetFont('Arial','',10);


$pdf->Cell(20,10,'DATE',1,0,'C');
  $pdf->Cell(45,10,'DESCRIPTION',1,0,'C');
  $pdf->Cell(55,10,'CATEGORY',1,0,'C');
  $pdf->Cell(22,10,'INCOMING',1,0,'C');
  $pdf->Cell(22,10,'OUTGOING',1,0,'C');
  $pdf->Cell(30,10,'FUND SOURCE',1,0,'C');
  $pdf->Cell(25,10,'BALANCE',1,0,'C');
  $pdf->Cell(28,10,'PETTY CASH',1,0,'C');
  $pdf->Cell(33,10,'REVOLVING FUND',1,0,'C');
  $pdf->Ln();

// Loop through transactions to add them to the PDF
for ($i = 0; $i < count($_SESSION['transactions']); $i++) {
    $entry = $_SESSION['transactions'][$i];
    $pdf->Cell(20,10,$entry['datetime'],1,0,'C');
    $pdf->Cell(45,10,$entry['description'],1,0,'C');
    $pdf->Cell(55,10,$entry['category'],1,0,'C');
    $pdf->Cell(22,10,$entry['incoming'],1,0,'C');
    $pdf->Cell(22,10,$entry['outgoing'],1,0,'C');
    $pdf->Cell(30,10,$entry['fundsource'],1,0,'C');
    $pdf->Cell(25,10,$entry['total_balance'],1,0,'C');
    $pdf->Cell(28,10,$entry['petty_cash'],1,0,'C');
    $pdf->Cell(33,10,$entry['revolving_fund'],1,0,'C');
    
    // Add other fields as needed
    $pdf->Ln();
}

$pdf->Output();


?>