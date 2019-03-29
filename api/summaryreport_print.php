<?php
session_start();
include('../pages/session.php');
require_once('config.php');

if(isset($_GET['id']))
{
$ID = base64_decode($_GET['id']);	

			try
			{
			$loadPrintQry = $mysql->prepare("SELECT served.ticketNo as ticketNo, ticket.upassenger as upassenger,ticket.divisioN as divisioN, ticket.udestination as udestination, ticket.udate as udate, ticket.utime as utime,ticket.Status as Status,ticket.Remarks as Remarks,ticket.Purpose as Purpose, ticket.Approvedby as Approvedby, CONCAT(driver.DfirstName,' ',driver.DlastName)as DriverName, vehicle.Vname as VehicleName, vehicle.VplateNo as PlateNo FROM tblserved as served LEFT JOIN tblemployee as driver ON served.EmployeeID = driver.EmployeeID LEFT JOIN tblvehicle as vehicle ON served.vehicleID = vehicle.vehicleID LEFT JOIN tblticket as ticket ON served.ticketNo = ticket.ticketNo WHERE served.ticketNo ='$ID' AND ticket.Status IN('Posted')");
				$loadPrintQry->execute();
				if($loadPrintQry->rowCount()>0)
				{
					while($row=$loadPrintQry->fetch(PDO::FETCH_OBJ))
					{
						$ticketNumber = $row->ticketNo;
						$_date = $row->udate;
						$DriverName = $row->DriverName;
						$PlateNo = $row->PlateNo;
						$VehicleName = $row->VehicleName;
						$division = $row->divisioN;
						$dateNeed = $row->udate;
						$DestionatioN = $row->udestination;
						$PurposeT = $row->Purpose;
						$passenger = $row->upassenger;
						$Remarkss = $row->Remarks;
						$ApprovedBY = $row->Approvedby;
						$sTatus =$row->Status;
						if($Remarkss == 'Conduction Only'):
						$remarksConduction1='/';
						else:  
							$remarksConduction1=' ';
						endif;

						if($Remarkss == 'Conduction To and From'):
						$remarksConduction2='/';
						else:  
							$remarksConduction2=' ';
						endif;

					}
				}
				else
				{
					echo"<h1 style='color:red'>This ticket has been cancelled!</h1>";

				}
			
			}catch(Exception $p){
				echo"ERROR: ".$p->getMessage();
			} //end of try cathc select print query
				require('../fpdf/fpdf.php');
				$pdf = new FPDF('P','mm','letter');
				$pdf->AddPage();
				$pdf->SetMargins(10,20,20,20);//Set left,top and margin
				//Draw border margin
				$pdf->Line(10, 10, 205, 10); //top border 
				$pdf->Line(10, 257, 10, 10); //left border
				$pdf->Line(205, 257, 205, 10); //right border 
				$pdf->Line(10, 257, 205, 257); 
				$pdf->Line(122, 175, 122, 30); //center line
				$pdf->Image('../img/popcom-logop.png',12,11,18,18);
				$pdf->SetFont('Times', 'B',19);
				$pdf->Cell(54,20,'POPCOM',1,0,'R');
				$pdf->SetFont('Times', 'B',20);
				$pdf->Cell(141,9,'TRIP TICKET',0,0,'C');

				$pdf->Ln(12);
				$pdf->SetFont('Arial', '',6);
				//total of 185 width size
				$pdf->Cell(24,7,''); //blank cell
				$pdf->Cell(30,7,'Empowering Filipino Families',0,0,''); //blank cell
				$pdf->SetFont('Arial', '',10);
				$pdf->Cell(58,8,'Form No. IT - AD - FMO27',1,0,'C'); // 62 vertical line
				$pdf->Cell(37,8,'Version No. 1',1,0,'C');
				$pdf->Cell(46,8,'Effective March 01, 2018',1,0,'C');
				//line break or next line
				$pdf->Ln(8);
				$pdf->Cell(112,5,'',1);
				$pdf->Cell(83,5,'',1);

				$pdf->Ln(5);
				$pdf->SetFont('Arial', '',10);
				$pdf->Cell(35,6,'Trip ticket Number:',0,0,'C');
				$pdf->SetFont('Arial', 'B',13);
				$pdf->Cell(38,6,$ticketNumber,0,0,'C');
				$pdf->SetFont('Arial', '',10);
				$pdf->Cell(70,6,'',0); //blank cell
				$pdf->Cell(15,6,'Date:');
				$pdf->Cell(40,6,$Today);
				$pdf->Line(205,40,167,40);//date underline
				$pdf->SetFont('Arial', '',10);
				$pdf->Line(50,41,78,41); // ticket underline


				$pdf->Ln(10);
				$pdf->SetFont('Arial', '',10);
				$pdf->Cell(30,6,'Name of Driver:');
				$pdf->Cell(82,6,$DriverName,0,0,'C');
				$pdf->Line(205,45,122,45);
				$pdf->Cell(40,5,'Service Vehicle:',0);
				$pdf->Cell(30,6,$VehicleName,0,0,'C');
				$pdf->Line(160, 56, 160, 45); //vertical line 
				$pdf->Line(45,50,205,50); //underline (left-margin,marginTop,length,marginTop)




				$pdf->Ln(5);
				$pdf->setFont('Arial','B',9);
				$pdf->Cell(50,5,'',0,0);
				$pdf->Cell(40,5,'Administrative Aide III',0,0,'C');
				$pdf->Cell(10,5,'',0,0); // blank cell
				$pdf->SetFont('Arial', '',10);
				$pdf->Cell(12,5,'',0);
				$pdf->Cell(50,5,'Plate No:',0);
				$pdf->Cell(12,7,$PlateNo,0);

				//REQUESTING DIVISION
				$pdf->Ln(6);

				$pdf->SetFont('Arial','',10);
				$pdf->Line(10,56,205,56);
				$pdf->Cell(56,6,'Requesting Division/s:',1,0,'L');
				$pdf->Cell(56,6,$division,1,0,'C');
				$pdf->Cell(20,5,'Destination:',0,0,'L');

				$pdf->Ln(6);
				$pdf->Cell(112,6,'',1,0,'C');
				$pdf->Cell(4,6,'',0,0,'C');
				$pdf->Cell(75,5,$DestionatioN,0,0,'C');

				$pdf->Ln(6);
				$pdf->Cell(35,6,'Date Needed:',1,0,'L');
				$pdf->Cell(77,6,$dateNeed,1,0,'C 	');
				$pdf->Cell(38,6,'Time Departure:',1,0,'L');
				$pdf->Cell(45,6,'',1,0,'C');


				$pdf->Ln(6);
				$pdf->Cell(112,6,'Purpose of Travel:',0,0,'L');
				$pdf->Cell(83,6,'',1,0,'C');

				$pdf->Ln(6);
				$pdf->Cell(112,4,'',0); //blanck cell
				$pdf->Cell(20,6,'REMARKS:',0,0,'L');

				$pdf->Ln(2);
				$pdf->Cell(8,6,'',0);
				$pdf->MultiCell(100,4,$PurposeT,0,'C','');
				$pdf->Line(10,90,122,90); //underline

				$pdf->Ln(4);
				$pdf->Cell(112,6,'Approved By:');
				$pdf->Cell(43,6,'Conduction Only:');
				$pdf->Cell(43,6,'    [       ]');
				$pdf->SetFont('Arial','B',10);
				$pdf->Ln(10);
				$pdf->Cell(112,5,$ApprovedBY,0,0,'C');
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(43,6,'Conduction to and  From:',0,0,'L');
				$pdf->Cell(43,6,'    [       ]');

				$pdf->Line(10,105,122,105);

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(112,6,'Head of Agency',0,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(112,5,'or Duly Authorized Representative',0,0,'C');
				$pdf->Cell(15,5,'Status: ',0,0);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(30,5,$sTatus,0,0);
				$pdf->Ln(5);
				$pdf->SetFont('Times','B',10);
				$pdf->SetFillColor(209,207,207);
				$pdf->Cell(195,5,'REPORT OF ACTUAL TRIP',1,0,'C',true);

				$pdf->Ln(10);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(112,5,'Time Departure:       ________________________________________',0,0,'L');
				//$pdf->SetFont('Arial','U',10);
				//$pdf->Cell(60,5,'8:00 AM',1,0,'L');
				//$pdf->Line(50,132,100,132);
				$pdf->Cell(83,5,'Time Arrival:   ______________________________',0,0,'L');


				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(112,5,'Destination (Office/Address):     _______________________________',0,0,'L');
				$pdf->Cell(83,5,'Level of Gas Issued, Purchased, and Balance:',0,0,'L');

				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(112,5,'Approximate distance (to-from working station):                  _____km',0,0,'');
				$pdf->Cell(54,5,'a. Balance in Tank');
				$pdf->Cell(30,5,'_________liters');

				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(92,5,'Actual Distance Travelled:',0,0,'L');
				$pdf->Cell(20,5,'_____km');
				$pdf->Cell(54,5,'b. Additional Purchase');
				$pdf->Cell(30,5,'_________liters');



				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(38,5,'Kilometer Reading:',0,0,'L');
				$pdf->Cell(74,5,'Start:___________________',0,0,'L');
				$pdf->Cell(54,5,'c. Deducted/Issued during the trip',0,0,'L');
				$pdf->Cell(20,5,'_________liters');

				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(38,5,'',0,0,'L');
				$pdf->Cell(74,5,'Finish:__________________',0,0,'L');
				$pdf->Cell(54,5,'d. Balance in the tank after the trip',0,0,'L');
				$pdf->Cell(20,5,'_________liters');


				$pdf->Ln(12);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(42,5,'Tools Complete[  ]',0,0,'C');
				$pdf->Cell(35,5,'Wrench[  ]',0,0,'C');
				$pdf->Cell(35,5,'Spare Tire[  ]',0,0,'C');


				$pdf->Line(10,175,205,175); // i certify underline

				$pdf->Ln(8);
				$pdf->SetFont('Arial','BI',10);

				$pdf->Cell(195,5,'I certify the correctness of the above information',0,0,'C');

				$pdf->Ln(12);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(45,5,'Name of Driver:',0,0,'L');
				$pdf->Line(120,191,55,191);//date underline
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(57,5,$DriverName,0,0,'C');

				$pdf->SetFont('Arial','',10);
				$pdf->Cell(10,5,'',0);
				$pdf->Cell(20,5,'Signature:',0,0,'C');
				$pdf->Cell(5,5,'',0,0,'C');
				$pdf->Cell(50,5,'   ________________________________',0,0,'C');

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(60,5,'');
				$pdf->Cell(30,5,'Administrative Aide lll',0,0,'C');

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(195,5,'',1,0,'C');

				$pdf->Ln(5);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(72,5,'NAME OF PASSENGER/S',1,0,'C');
				//$pdf->Line(122, 250, 122, 202); //vertical line 
				$pdf->Cell(35,5,'DIVISION',1,0,'C');
				$pdf->Cell(40,5,'REMARKS',1,0,'C');
				$pdf->Cell(48,5,'SIGNATURE',1,0,'C');

				$get = $mysql->prepare("SELECT DISTINCT tblserved.ticketNo as ticketNo,tblserved.Status as Status,ticket.upassenger as passnger, ticket.Remarks as iRemarks FROM tblserved inner join tblticket as ticket on tblserved.ticketNo = ticket.ticketNo WHERE ticket.Status IN('Posted') AND tblserved.ticketNo='$ID' ");
				$get->execute();
				$numCount = 0;
				while($rowName	 = $get->fetch(PDO::FETCH_OBJ))
					{
						$numCount++;
						$pdf->Ln(5);
						$pdf->SetFont('Arial','',10);
						$pdf->Cell(72,5,$numCount.'. '.' '.' '.$rowName->passnger ,1,0,'L');
						$pdf->Cell(35,5,$division,1,0,'C');
						$pdf->Cell(40,5,$rowName->iRemarks,1,0,'C');
						$pdf->Cell(48,5,'',1,0,'C');
					}
				
				$pdf->Output();


	
}else{
	echo"Illegal Transaction";
} //end of isset condition
?>