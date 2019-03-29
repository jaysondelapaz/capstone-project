<?php
session_start();
require_once('config.php');

try
{


$ID = base64_decode($_GET['id']);

	$loadPrintQry = $mysql->prepare("SELECT service.VserviceID as serviceID ,service.vehicleID as vehicleID,service.Vdescription as Vdescription, service.Vamount as Vamount, service.Vservicedate as serviceDate,service.PONumber as PONumber, service.Scompany as Scompany ,tblvehicle.Vname as Vname,tblvehicle.VengineNo as VengineNo ,tblvehicle.VchassisNo as VchassisNo,tblvehicle.VplateNo as PlateNumber FROM tblvehicleservice as service LEFT JOIN tblvehicle ON service.vehicleID = tblvehicle.vehicleID WHERE VserviceID=:vID");
		$loadPrintQry->execute([':vID'=>$ID]);
	while($row=$loadPrintQry->fetch(PDO::FETCH_ASSOC))
		{
			$vehicleName = $row['Vname'];
			$EngineNo = $row['VengineNo'];
			$PlateNumber = $row['PlateNumber'];
			$ChassisNo = $row['VchassisNo'];
			$Amount = $row['Vamount'];

			
			$sDate= $row['serviceDate'];
			$Particular = $row["Vdescription"];
			$Company = $row['Scompany'];
			$PONumber = $row['PONumber'];

		}
}catch(Exception $p){
	echo"ERROR: ".$p->getMessage();
}


require('../fpdf/fpdf.php');
class PDF extends FPDF{

	function Header(){
$this->SetMargins(10,10,20,20);//Set left,top and margin
//Draw border margin
$this->Line(10, 10, 205, 10); //top border 
$this->Line(10, 130, 10, 10); //left5border
$this->Line(205, 130, 205, 10); //right border 
$this->Line(10, 130, 205, 130); //bottom border
//$this->Line(122, 130, 122, 30); //center line
$this->Image('../img/popcom-logop.png',12,11,18,18);
$this->SetFont('Times', 'B',19);
$this->Cell(54,20,'POPCOM',1,0,'R');
$this->SetFont('Times', 'B',20);
$this->Cell(141,9,'Vehicle Service Report',0,0,'C');

$this->Ln(12);
$this->SetFont('Arial', '',6);
//total of 185 width size
$this->Cell(24,7,''); //blank cell
$this->Cell(30,7,'Empowering Filipino Families',0,0,''); //blank cell
$this->SetFont('Arial', '',10);

$this->Cell(58,8,'Form No. IT - AD - FMO27',1,0,'C');
$this->Cell(37,8,'Version No. 1 ',1,0,'C');
$this->Cell(46,8,'Date:  '.date('F j,Y'),1,0,'C');
$this->Ln(8);

$this->Cell(195,6,'',0); //line break
//line break or next line
// $this->Ln(8);
// $this->Cell(112,5,'',1);
// $this->Cell(83,5,'',1);

	}
}

$pdf = new PDF;
$pdf = new PDF('P','mm','letter');
//$pdf = new PDF('P','mm',array(216,216));
$pdf->AddPage();
//$pdf->Header(); no need to call na

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(54,8,'Name of Vehicle:');
$pdf->SetFont('Arial','UB',12);
$pdf->Cell(54,8,$vehicleName,0,0,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(54,8,'Engine No / Model:');
$pdf->SetFont('Arial','UB',12);
$pdf->Cell(54,8,$EngineNo,0,0,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(54,8,'Chassis No:');
$pdf->SetFont('Arial','UB',12);
$pdf->Cell(54,8,$ChassisNo,0,0,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(54,8,'Plate No:');
$pdf->SetFont('Arial','UB',12);
$pdf->Cell(54,8,$PlateNumber,0,0,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(54,8,'Service Cost:');
$pdf->SetFont('Arial','UB',12);
$pdf->Cell(54,8,'Php ' . number_format($Amount,2),0,0,'C');
$pdf->Line(64, 80, 64, 30); //center line

$pdf->Ln(9);
$pdf->SetFillColor(209,207,207);
$pdf->Cell(195,4,'',1,0,'',true);

$pdf->Ln(4);
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,8,'Service Date',1,0,'C');
$pdf->Cell(55,8,'Contracted Shop',1,0,'C');
$pdf->Cell(25,8,'PO/JO No',1,0,'C');
$pdf->Cell(80,8,'Nature of Works Done',1,0,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,15,$sDate,0,0,'C');
$pdf->Cell(55,15,$Company,0,0,'C');
$pdf->Cell(25,15,$PONumber,0,0,'C');

$pdf->Ln(6);
$pdf->Cell(115,8,'',0,0,'C'); // blank cell
$pdf->MultiCell(80,6,$Particular,0,'C',false);
$pdf->Line(45, 130, 45, 83);
$pdf->Line(100, 130, 100, 83);
$pdf->Line(125, 130, 125, 83);
$pdf->Output();
?>