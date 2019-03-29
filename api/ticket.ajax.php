<?php

session_start();
include('../pages/session.php');
require_once('config.php');
require_once('../api/function.php');
$action = isset($_POST['action']) ? $_POST['action']:'';
// autocomplete
if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'TicketNO'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT ticketNo FROM  tblticket where ticketNo like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['ticketNo'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 
    
    if($_POST['SearchBy'] == 'PassengeR'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT upassenger FROM  tblticket where upassenger like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['upassenger'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif;            
}//end of autocomplete action


?>


<?php
if($action == 'createticket')
{

	

	try{
			function generatedNo(){
				$characters = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890";
				$characters = str_shuffle($characters);
				$Tnum = substr($characters,0,4);
				$date = date('Y'); //get current year
				$key =$date.'-'.$Tnum;
				return $key;
			}
			$randomGenerated = generatedNo();
			
		
		$checkTicketNo = $mysql->prepare("SELECT ticketNo FROM tblticket WHERE ticketNo=?");
		$checkTicketNo->bindParam(1,$randomGenerated);
		$checkTicketNo->execute();
		if($checkTicketNo->rowCount()>0):
			echo"Ticket Number already exist!";
			return generatedNo();
		else:	
				$passengerN = json_decode(strtoupper($_POST['Fullname']));
				$approvebY =strtoupper($_POST['ApproveBy']);
				$status="Pending";

				foreach ($passengerN as $key => $passengerName) {
								
					$stmt = $mysql->prepare("INSERT INTO tblticket VALUES(NULL,:tnum,:pname,:division,:destination,:date,:time,:driver,:vehicle,:status,:remarks,:purpose,:approveby,:stamp)");
					$stmt->bindParam(':tnum',$randomGenerated);
					$stmt->bindParam(':pname',$passengerName);
					$stmt->bindParam(':division',$_POST['Division']);
					$stmt->bindParam(':destination',$_POST['destination']);
					$stmt->bindParam(':date',$_POST['Date']);
					$stmt->bindParam(':time',$_POST['time']);
					$stmt->bindParam(':driver',$_POST['Driver']);
					$stmt->bindParam(':vehicle',$_POST['Vehicle']);
					$stmt->bindParam(':status',$status);
					$stmt->bindParam(':remarks',$_POST['Remarks']);
					$stmt->bindParam(':purpose',$_POST['Purpose']);
					$stmt->bindParam(':approveby',$approvebY);
					$stmt->bindParam(':stamp',$Today);
					$stmt->execute();
				}
				echo"success";
		endif;	
		

	}
	catch(Exception $g)
	{
		echo"Query failed! ".$g->getMessage();
	}
}



if($action == 'SetAction')
{ 
	//CONFIRM
	if($_POST['status'] == 'Confirmed')
	{ 
		 try
		 {
		 	$confirmQuery = $mysql->prepare("UPDATE tblticket SET Status =? WHERE Tid=? AND ticketNo=?");
		 	$confirmQuery->bindParam(1,$_POST['status']);
		 	$confirmQuery->bindParam(2,$_POST['id']);
		 	$confirmQuery->bindParam(3,$_POST['ticket_number']);
		 	$confirmQuery->execute();
		 	echo"success";

		 }
		catch(Exception $n)
		{
			echo"Query failed! ".$n->getMessage();
		}
	}


if($_POST['status'] == 'Posted')
	{ 

		try{
					$c = $mysql->prepare("select Tid,Status from tblticket where Status='Cancelled' and Tid =:tid");
					$c->bindParam(':tid',$_POST['id']);
					$c->execute();

					if($c->rowCount()>0){
						echo "sorry has been cancelled!";
					}
					else{
							 try
		 {
		 	$postedmQuery = $mysql->prepare("UPDATE tblticket SET Status =? WHERE Tid=? AND ticketNo=?");
		 	$postedmQuery->bindParam(1,$_POST['status']);
		 	$postedmQuery->bindParam(2,$_POST['id']);
		 	$postedmQuery->bindParam(3,$_POST['ticket_number']);
		 	$postedmQuery->execute();

		 			try{
		 					//insert to tblserved 
		 				$insertQry = $mysql->prepare("insert into tblserved values(NULL,:tid,:ticketNO,:EmpID,:vid,:stat,:today)");
		 				$insertQry->bindParam(':tid',$_POST['id']);
		 				$insertQry->bindParam(':ticketNO',$_POST['ticket_number']);
		 				$insertQry->bindParam(':EmpID',$_POST['driver']);
		 				$insertQry->bindParam(':vid',$_POST['vehicle']);
		 				$insertQry->bindParam(':stat',$_POST['status']);
		 				$insertQry->bindParam(':today',$Today);
		 				$insertQry->execute();
		 				echo'ticket posted!';
		 			}catch(Exception $p){
		 				echo"error posting ticket: ".$p->getMessage();
		 			}
		 		
		 }
		catch(Exception $n)
		{
			echo"ERROR posted button! ".$n->getMessage();
		}

					}

		}catch(Exception $c){
			echo"error posting".$c->getMessage();
		}

		
	}



	//CANCEL
	if($_POST['status'] == 'Cancelled')
	{
		 try
		 {
		 	$scheckQry=$mysql->prepare("select Tid,Status from tblticket where Tid = :checkTid and Status='Cancelled'");
			$scheckQry->bindParam(':checkTid',$_POST['id']);
			$scheckQry->execute();
			if($scheckQry->rowCount()>0)
			{
				echo"Ticket is has already cancelled!";
			}
			else
			{
				$cancelmQuery = $mysql->prepare("UPDATE tblticket SET Status =? WHERE Tid=? AND ticketNo=?");
			 	$cancelmQuery->bindParam(1,$_POST['status']);
			 	$cancelmQuery->bindParam(2,$_POST['id']);
				$cancelmQuery->bindParam(3,$_POST['ticket_number']);
				$cancelmQuery->execute();

			 	$deletestmtQry = $mysql->prepare("DELETE FROM tblserved WHERE Tid = :ids");
			 	$deletestmtQry->execute([':ids'=>$_POST['id']]);
			 	echo"ticket has been cancelled";
			}
		 }
		catch(Exception $n)
		{
			echo"Query failed! ".$n->getMessage();
		}
	}
	

}

//************************************************END OF CONFIRM AND CANCEL ACTION*************************************************************
if($action == 'editticket'){

	
	try
	{
	$updateQuery=$mysql->prepare("UPDATE tblticket SET upassenger=?,divisioN=?,udestination=?,udate=?,utime=?,EmployeeID=?,vehicleID=?,Remarks=?,Purpose=?,Approvedby=?,ustamp=? WHERE ticketNo=? AND Tid=?");
	$editedFullname = strtoupper($_POST['editFullname']);
	$updateQuery->bindParam(1,$editedFullname);
	$updateQuery->bindParam(2,$_POST['editDivision']);
	$updateQuery->bindParam(3,$_POST['editdestination']);
	$updateQuery->bindParam(4,$_POST['editDate']);
	$updateQuery->bindParam(5,$_POST['edittime']);
	$updateQuery->bindParam(6,$_POST['editdriver']);
	$updateQuery->bindParam(7,$_POST['editvehicle']);
	$updateQuery->bindParam(8,$_POST['editremarks']);
	$updateQuery->bindParam(9,$_POST['editpurpose']);
	$updateQuery->bindParam(10,$_POST['editpproveBy']);
	$updateQuery->bindParam(11,$_POST['editustamp']);
	$updateQuery->bindParam(12,$_POST['ticketIDS']);	
	$updateQuery->bindParam(13,$_POST['TID']);
	$updateQuery->execute();
	echo"Updated!";

	}
	catch(Exception $b)
	{
		echo"Update error: ".$b->getMessage();
	}

	


}

 if($action == 'Delete'){

	$deleteQuery=$mysql->prepare("DELETE FROM tblticket WHERE Tid=:id");
	$deleteQuery->execute([':id' => $_POST['id']]);
	echo"data has been deleted!";
}
?>


<?php
if($action =='ajaxSearch'){
?>

	<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                        <th>TicketNo</th>
                                        <th>Passenger</th>
                                        <th>Destination</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>DriverName</th>
                                        <th>Vehicle</th>
                                        <th>PlateNo</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>


<?php
	try
	{ 
		$filterQry= $mysql->prepare("select ticket.Tid as Tid,ticket.ticketNo as ticketNo, ticket.upassenger as passenGer,ticket.EmployeeID as EmployeeID,ticket.vehicleID as vehicleID,ticket.ustamp as ustamp,ticket.vehicleID as VID,ticket.udestination as dEstination,ticket.utime as timE,ticket.Remarks as remarkS,ticket.Status as statuS,CONCAT(driver.DlastName,' ',driver.DfirstName)as DriverName, vehicle.Vname as VehicleName,vehicle.VplateNo as PlatenO from tblticket as ticket inner join tblemployee as driver on ticket.EmployeeID = driver.EmployeeID inner join tblvehicle as vehicle on ticket.vehicleID = vehicle.vehicleID WHERE ticket.Status in('Confirmed','Pending','Cancelled') AND ticket.ticketNo like concat('%',:tickettxt,'%') AND ticket.upassenger like concat('%',:passengertxt,'%') AND ticket.EmployeeID like concat('%',:drivertxt,'%') AND ticket.vehicleID like concat('%',:vidtxt,'%') AND ticket.ustamp between :dateFromtxt and :dateTotxt" );
		$filterQry->bindParam(':tickettxt',$_POST['SearchTicketNo']);
		$filterQry->bindParam(':passengertxt',$_POST['searchPassenger']);
		$filterQry->bindParam(':drivertxt',$_POST['SearchDriver']);
		$filterQry->bindParam(':vidtxt',$_POST['SearchVehicle']);
		$filterQry->bindParam(':dateFromtxt',$_POST['dateFrom']);
		$filterQry->bindParam(':dateTotxt',$_POST['dateTo']);
		$filterQry->execute();
		if($filterQry->rowCount() >0):
			while($filter=$filterQry->fetch(PDO::FETCH_OBJ))
				{
					echo'<tr>';	
					echo'<td>'. $filter->ticketNo.'</td>';
					echo'<td>'. $filter->passenGer.'</td>';
					echo'<td>'. $filter->dEstination.'</td>';
					echo'<td>'. $filter->ustamp.'</td>';
					echo'<td>'. $filter->timE.'</td>';
					echo'<td>'. $filter->DriverName.'</td>';
					echo'<td>'. $filter->VehicleName.'</td>';
					echo'<td>'. $filter->PlatenO.'</td>';
					echo'<td>'. $filter->remarkS.'</td>';
					//echo'<td>'. $filter->statuS.'</td>';
					StatusColor($filter->statuS);
					echo'<td>';
?>
                                        
<!-- Single button -->
<div class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Action <span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="#">Action</a></li>

		<li><a href="#" onClick='action_btn("<?php echo $filter->Tid; ?>","<?php echo $filter->ticketNo; ?>","Confirmed","<?php echo $filter->EmployeeID; ?>","<?php echo $filter->vehicleID; ?>","<?php echo $filter->dEstination;?>","<?php echo$filter->passenGer;?>");'>Confirm</a></li>


		<li><a href="#" onClick='action_btn("<?php echo $filter->Tid; ?>","<?php echo $filter->ticketNo; ?>","Cancelled");'>Cancel</a></li>


		<li><a href="#" onClick='action_btn("<?php echo $filter->Tid; ?>","<?php echo $filter->ticketNo; ?>","Posted","<?php echo $filter->EmployeeID; ?>","<?php echo $filter->vehicleID; ?>","<?php echo $filter->dEstination;?>","<?php echo$filter->passenGer;?>");'>Post</a></li>


		<li><a href="edit_ticket.php?id=<?php echo base64_encode($filter->Tid); ?>">Edit</a></li>
		<li><a href="#" onClick="PrintData('../api/ticket_print.php','<?php echo base64_encode($filter->Tid); ?>')">Print</a></li>
		<li><a href="#" onClick='remove("<?php echo $filter->Tid;?>","../api/ticket.ajax.php","home.php");'>Delete</a></li>
	</ul>
</div>
</td>
<?php   


					
				}
		else: echo"No data found...";
		endif;		
	}
	catch(Exception $s)
	{
		echo"Error : ".$s->getMessage();
	}
	echo'</tbody>
	</table>';
} 

?>
