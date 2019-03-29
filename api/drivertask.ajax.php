<?php
session_start();
include('../pages/session.php');
require_once('config.php');
$action = isset($_POST['action']) ? $_POST['action']:'';
// autocomplete
if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'DriverName'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT * FROM  tblemployee where DfirstName like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['DfirstName'].' '.$row['DlastName'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 
    

}//end of autocomplete action


if($action == 'AjaxSearch')
{
?>

<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                   <tr>
                                            <th>TicketNo</th>
                                            <th>Passenger</th>
                                            <th>Destination</th>
                                            <th>Driver</th>
                                            <th>Vehicle</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Remarks</th>
                                         
                                           
                                        </tr>
                                </thead>
                                <tbody>


<?php

	try{
		$stmttask=$mysql->prepare("SELECT distinct ticket.ticketNo as ticketNo, ticket.upassenger as upassenger, ticket.udestination as udestination, ticket.udate as udate, ticket.utime as utime,ticket.Status as Status,ticket.Remarks as Remarks,ticket.EmployeeID as EmployeeID, ticket.vehicleID as vehicleID,ticket.Purpose as Purpose, ticket.Approvedby as Approvedby, CONCAT(driver.DfirstName,' ',driver.DlastName)as DriverName, vehicle.Vname as VehicleName, vehicle.VplateNo as PlateNo FROM tblticket as ticket LEFT JOIN tblemployee as driver ON ticket.EmployeeID = driver.EmployeeID LEFT JOIN tblvehicle as vehicle ON ticket.vehicleID = vehicle.vehicleID WHERE ticket.Status IN ('Pending','Confirmed') AND ticket.udate=:nowToday and ticket.EmployeeID =:driverID");
	$stmttask->execute([':nowToday'=>$Today,':driverID'=>$_POST['Drivertxt']]);
	//$stmttask->execute([':driverID'=>$_POST['Drivertxt']]);

	if($stmttask->rowCount()>0){
		while($vrow=$stmttask->fetch(PDO::FETCH_OBJ)){
		?>
									<tr>														
										<td><?php echo $vrow->ticketNo;?></td>
                                        <td><?php echo $vrow->upassenger;?></td>
                                        <td><?php echo $vrow->udestination;?></td>
                                        <td><?php echo $vrow->DriverName;?></td>
                                        <td><?php echo $vrow->VehicleName;?></td>
                                        <td><?php echo $vrow->udate;?></td>
                                        <td><?php echo $vrow->utime;?></td>                                        
                                         <!-- <td><?php //echo $vrow->Status;?></td> -->
										<td><?php echo$vrow->Remarks;?></td>
									</tr>				
		<?php
	}
	}else{
		echo'<tr><td>No Resutls found..</td></tr>';
	}
	}catch(Exception $t){
		echo"error Searching: ".$t->getMessage();
	}
	echo'</tbody></table>';
}	
?>