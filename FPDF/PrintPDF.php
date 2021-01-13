<?php
session_start();
if(!isset($_SESSION['user_id'])){
    unset($_SESSION['role']);
    die(header("location: ../login.php"));
}
$env = include '../.env.php';
include '../inc/select.php';
include '../inc/mysql.php';
$db = new DATABASE;
$user = $_SESSION['user_id'];
$labid = $_GET['labjournal_id'];
$labusers = $db->GetAllLabUsers($labid);
while($users = $labusers->fetch_array(MYSQLI_ASSOC)){
    $labuser = $users['user_id'];
    if($user == $labuser){  
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
        if(isset($_GET['labjournal_id'])){
            $labjournal_id = $_GET['labjournal_id'];
            $output = $db->selectcontentlabjournal($labjournal_id);
            while ($outputarray = $output->fetch_array(MYSQLI_ASSOC)){
                $title = $outputarray['title'];
                $date = $outputarray['date'];
                $hypothesis = $outputarray['Hypothesis'];
                $var1 = $outputarray['method_materials'];
                $var2 = $outputarray['log'];
                $var3 = $outputarray['theory'];
                $safety = $outputarray['safety'];
                $goal = $outputarray['Goal'];
                $var1n = $lang['METHOD_MATERIALS'];
                $var2n = $lang['LOG'];
                $var3n = $lang['THEORY'];
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
                $var3 = $outputarray['devicesettings'];
                $var4 = $outputarray['preperation_questions'];
                $safety = $outputarray['safety'];
                $goal = $outputarray['goal'];
                $var1n = $lang['MATERIALS'];
                $var2n = $lang['METHOD'];
                $var3n = $lang['DEVICE_SETTINGS'];
                $var4n = $lang['PREPARATION_QUESTIONS'];
            }
        }
        $hypothesislang = $lang['HYPOTHESIS'];
        $safetylang = $lang['SAFETY'];
        $goallang = $lang['GOAL']; 
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->MultiCell(0,5,$title,'B','L');
        $pdf->ln(5);
        $pdf->MultiCell(0,5,$date,'B','L');
        $pdf->ln(5);
        $pdf->SetFont('Arial','',16);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$hypothesislang:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$hypothesis,'0','L');
        $pdf->ln(5);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$var1n:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$var1,'0','L');
        $pdf->ln(5);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$var2n:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$var2,'0','L');
        $pdf->ln(5);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$var3n:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$var3,'0','L');
        $pdf->ln(5);
        if(isset($var4)){
            $pdf->SetFont('Arial','',18);
            $pdf->Cell(32,5, "$var4n:", 0, 2);
            $pdf->SetFont('Arial','',16);
            $pdf->MultiCell(0,5,$var4,'0','L');
            $pdf->ln(5);
        }
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$safetylang:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$safety,'0','L');
        $pdf->ln(5);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(32,5, "$goallang:", 0, 2);
        $pdf->SetFont('Arial','',16);
        $pdf->MultiCell(0,5,$goal,'0','L');
        $pdf->Output();
    }
}
echo "<script>window.close();</script>";
?>