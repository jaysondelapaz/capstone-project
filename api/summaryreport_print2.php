<?php
session_start();
require_once('../pages/session.php');
require_once('config.php');


try{

	$PrintQry = $mysql->prepare("SELECT served.serveID as serveID,served.ticketNo as ticketNo,served.Status as Status,ticket.udestination as udestination,ticket.upassenger as upassenger,ticket.udate as udate,CONCAT(driver.DfirstName,' ',driver.DlastName)as DriverName,vehicle.Vname as Vname FROM tblserved as served INNER JOIN tblticket as ticket ON served.Tid = ticket.Tid INNER JOIN tblemployee as driver ON served.EmployeeID = driver.EmployeeID INNER JOIN tblvehicle as vehicle on served.vehicleID = vehicle.vehicleID WHERE served.ticketNo like concat('%',:tickettxt,'%') and ticket.upassenger like concat('%',:passngr,'%') and served.EmployeeID like concat('%',:driver_ID,'%') and vehicle.vehicleID like concat('%',:vid,'%')");
		$PrintQry->bindParam(':tickettxt',$_GET['ticketNumber']);
		$PrintQry->bindParam(':passngr',$_GET['passengerName']);
		$PrintQry->bindParam(':driver_ID',$_GET['DriverID']);
		$PrintQry->bindParam(':vid',$_GET['VehicleID']);
		$PrintQry->execute();

		




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
	$this->Cell(141,9,'Summary Posted Ticket Report',0,0,'C');

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
$pdf->SetFont('Arial','B',10);
$pdf->Cell(24,6,'TicketNo',1,0,'C');
$pdf->Cell(42,6,'Passenger',1,0,'C');
$pdf->Cell(19,6,'Date',1,0,'C');
$pdf->Cell(30,6,'Driver',1,0,'C');
$pdf->Cell(30,6,'Vehicle',1,0,'C');
$pdf->Cell(30,6,'Destination',1,0,'C');
$pdf->Cell(20,6,'Status',1,0,'C');

$pdf->Ln(6);

if($PrintQry->rowCount()>0){
			while($r=$PrintQry->fetch(PDO::FETCH_ASSOC))
				{
					$ticketnumber =$r['ticketNo'];
					$passenGer = $r['upassenger'];
					$udate=$r['udate'];
					$driver=$r['DriverName'];
					$vehicle=$r['Vname'];
					$dest=$r['udestination'];
					$stat=$r['Status'];


					$pdf->SetFont('Arial','I',9);
					$pdf->Cell(24,6,$ticketnumber,1,0,'C');
					$pdf->Cell(42,6,$passenGer,1,0,'C');
					$pdf->Cell(19,6,$udate,1,0,'C');
					$pdf->Cell(30,6,$driver,1,0,'C');
					$pdf->Cell(30,6,$vehicle,1,0,'C');
					$pdf->Cell(30,6,$dest,1,0,'C');
					$pdf->Cell(20,6,$stat,1,0,'C');
					$pdf->Ln(6);
				}
		}else{
			echo"No data found...";
		}				


 $pdf->Output();

}catch(Exception $l){
	echo"Printing Error ".$l->getMessage();
}
?>