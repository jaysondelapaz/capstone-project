<?php
session_start();
require_once('config.php');



try{
		$ajaxQryPrint= $mysql->prepare("select service.VserviceID as VserviceID,service.Vdescription as Vdescription,service.Vamount as Vamount,service.Vservicedate as Vservicedate,service.PONumber as PONumber,service.Scompany as Scompany,vehicle.Vname as Vname,vehicle.VplateNo as VplateNo,vehicle.VengineNo from tblvehicleservice as service inner join tblvehicle as vehicle on service.vehicleID = vehicle.vehicleID where service.PONumber like concat('%',:PO,'%') AND vehicle.Vname like concat('%',:model,'%') AND vehicle.VengineNo like concat('%',:engine,'%') AND vehicle.VplateNo like concat('%',:plateno,'%') AND service.Vservicedate between :dFrom and :dTo");
		$ajaxQryPrint->bindParam(':PO',$_GET['po']);
		$ajaxQryPrint->bindParam(':model',$_GET['modelname']);
		$ajaxQryPrint->bindParam(':engine',$_GET['engineno']);
		$ajaxQryPrint->bindParam(':plateno',$_GET['plateno']);
		$ajaxQryPrint->bindParam(':dFrom',$_GET['datefrom']);
		$ajaxQryPrint->bindParam(':dTo',$_GET['dateto']);
		$ajaxQryPrint->execute();

		
	
					
	
	require('../fpdf/fpdf.php');
class PDF extends FPDF{

	function Header(){
$this->SetMargins(10,10,20,20);//Set left,top and margin
//Draw border margin
$this->Line(10, 10, 205, 10); //top border 
//$this->Line(10, 130, 10, 10); //left5border
$this->Line(205, 30, 205, 10); //right border 
//$this->Line(10, 130, 205, 130); //bottom border
//$this->Line(122, 130, 122, 30); //center line
$this->Image('../img/popcom-logop.png',12,11,18,18);
$this->SetFont('Times', 'B',19);
$this->Cell(54,20,'POPCOM',1,0,'R');
$this->SetFont('Times', 'B',20);
$this->Cell(141,9,'Summary Service Vehicle Report',0,0,'C');

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
$this->SetFillColor(209,207,207);
$this->Cell(195,4,'',1,0,'',true); //line break

	}


}

$pdf = new PDF;
$pdf = new PDF('P','mm','letter');

$pdf->AddPage();

$pdf->Ln(4);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,6,'Modelname',1,0,'C');
$pdf->Cell(18,6,'EngineNo',1,0,'C');
$pdf->Cell(18,6,'PlateNo',1,0,'C');
$pdf->Cell(40,6,'Contracted Shop',1,0,'C');
$pdf->Cell(18,6,'PO/JO#',1,0,'C');
$pdf->Cell(19,6,'ServiceDate',1,0,'C');
$pdf->Cell(17,6,'Amount',1,0,'C');
$pdf->Cell(40,6,'Nature of Work',1,0,'C');
$pdf->Ln(6);
$total=0;
while($rw = $ajaxQryPrint->fetch(PDO::FETCH_OBJ))
				{
					$ModelName=$rw->Vname;
					$EnginNo=$rw->VengineNo;
					$PlateNo=$rw->VplateNo;
				    $Particular=$rw->Vdescription;
					$Po=$rw->PONumber;
					$Company=$rw->Scompany;
					$serviceDate=$rw->Vservicedate;
					$Amount=$rw->Vamount;
					$total=$Amount;
					$total+=$total;

					
						//COntent
					// $pdf->Cell(25,5,$ModelName,1,0,'C');
					// $pdf->Cell(18,5,$EnginNo,1,0,'C');
					// $pdf->Cell(18,5,$PlateNo,1,0,'C');
					// $pdf->Cell(40,5,$Company,1,0,'C');
					// $pdf->Cell(18,5,$Po,1,0,'C');
					// $pdf->Cell(18,5,$serviceDate,1,0,'C');
					// $pdf->Cell(18,5,number_format($Amount,2),1,0,'C');
					// $pdf->MultiCell(40,5,$Particular,1,'C',false);

					$pdf->SetFont('Arial','I',9);

					$pdf->MultiCell(25,5,$ModelName,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 25,$pdf->GetY()-5);
					$pdf->MultiCell(18,5,$EnginNo,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 43,$pdf->GetY()-5);
					$pdf->MultiCell(18,5,$PlateNo,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 61,$pdf->GetY()-5);
					$pdf->MultiCell(40,5,$Company,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 101,$pdf->GetY()-5);
					$pdf->MultiCell(18,5,$Po,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 119,$pdf->GetY()-5);
					$pdf->MultiCell(19,5,$serviceDate,1,'C',false);
					$pdf->SetXY($pdf->GetX() + 138,$pdf->GetY()-5);
					$pdf->MultiCell(17,5,number_format($Amount,2),1,'C',false);
					$pdf->SetXY($pdf->GetX() + 155,$pdf->GetY()-5);
					$pdf->MultiCell(40,5,$Particular,1,'C',false);
					
				}
$pdf->Ln(2);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(209,207,207);
$pdf->Cell(119,8,'',0,0,'R');
$pdf->Cell(18,8,'Total',0,0,'C',true);
$pdf->Cell(18,8,number_format($total,2),0,0,'C',true);
$pdf->Cell(40,8,'',0,0,'C',true);

$pdf->Output();

}
catch(Exception $e)
{
		echo"ERROR: ".$e->getMessage();
}	

?>