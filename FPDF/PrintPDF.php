<?php
$env = include '../.env.php';
include '../inc/mysql.php';
require('fpdf.php');
class PDF extends FPDF
{
// Page header
function Header()
{
    $this->Image('../images/logo2.0.png',7,5,35);
    // Arial bold 15
    $this->SetFont('Arial','B',25);
    // Move to the right
    $this->Cell(80);
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-10);
    // Arial italic 8
    $this->SetFont('Arial','I',8,);
    // Page number
    $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
}
}
$db = new DATABASE;
if(isset($_GET['labjournaal_id'])){
    $labjournaal_id = $_GET['labjournaal_id'];
    $output = $db->selectcontentlabjournal($labjournaal_id);
    while ($outputarray = $output->fetch_array(MYSQLI_ASSOC)){
        $title = $outputarray['title'];
        $date = $outputarray['date'];
        $hypothesis = $outputarray['Hypothesis'];
        $var1 = $outputarray['method_materials'];
        $var2 = $outputarray['logboek'];
        $var3 = $outputarray['theory'];
        $safety = $outputarray['safety'];
        $goal = $outputarray['Goal'];
    }
}
if(isset($_GET['preperation_id'])){
    $preperation_id = $_GET['preperation_id'];
    $output = $db->selectcontentpreperation($preperation_id);
    while ($outputarray = $output->fetch_array(MYSLQI_ASSOC)){
        $title = $outputarray['title'];
        $date = $outputarray['date'];
        $hypothesis = $outputarray['hypothesis'];
        $var1 = $outputarray['materials'];
        $var2 = $outputarray['method'];
        $var3 = $outputarray['device settings'];
        $var4 = $outputarray['preperation_questions'];
        $safety = $outputarray['safety'];
        $goal = $outputarray['goal'];
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(0,5,"$title",'B','L');
$pdf->ln(5);
$pdf->MultiCell(0,5,"$date",'B','L');
$pdf->ln(5);
$pdf->SetFont('Arial','',16);
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Hypothesis:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$hypothesis",'0','L');
$pdf->ln(5);
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Var1:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$var1",'0','L');
$pdf->ln(5);
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Var2:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$var2",'0','L');
$pdf->ln(5);
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Var3:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$var3",'0','L');
$pdf->ln(5);
if(isset($var4)){
    $pdf->SetFont('Arial','',18);
    $pdf->Cell(32,5, "Var4:", 0, 2);
    $pdf->SetFont('Arial','',16);
    $pdf->MultiCell(0,5,"$var4",'0','L');
    $pdf->ln(5);
}
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Safety:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$safety",'0','L');
$pdf->ln(5);
$pdf->SetFont('Arial','',18);
$pdf->Cell(32,5, "Goal:", 0, 2);
$pdf->SetFont('Arial','',16);
$pdf->MultiCell(0,5,"$goal",'0','L');
$pdf->Output();
?>