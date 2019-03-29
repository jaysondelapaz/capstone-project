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
			$AutoCompleteQry=$mysql->prepare("SELECT ticketNo FROM  tblserved where ticketNo like '%$term%'");
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

if($action == 'Delete'){

	$rmQry=$mysql->prepare("delete from tblticket where Tid=:id");
	$rmQry->execute([':Tid' => $_POST['id']]);

	$deleteQuery=$mysql->prepare("DELETE FROM tblserved WHERE serveID=:id");
	$deleteQuery->execute([':id' => $_POST['id']]);
	echo"data has been deleted!";
}

if($action =='ajaxSearch'){
?>
 <div class="panel panel-default">
                    <div class="panel-heading">
                        Results...
                    </div>
                     <div style="padding:0.5em"><button type="button" class="btn btn-primary" onClick="PrintReportSummary('../api/summaryreport_print2.php')">Print</button></div>
                    <!-- /.panel-heading -->
                    <div class="panel-body"> <!--TICKET LOADER CONTAINER-->
	<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                        <th>TicketNo</th>
                                        <th>Passenger</th>
                                        <th>Date</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Destination</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>
<?php
try{
	$ajaxSearchQry=$mysql->prepare("SELECT served.serveID as serveID,served.ticketNo as ticketNo,served.Status as Status,ticket.udestination as udestination,ticket.upassenger as upassenger,ticket.udate as udate,CONCAT(driver.DfirstName,' ',driver.DlastName)as DriverName,vehicle.Vname as Vname FROM tblserved as served INNER JOIN tblticket as ticket ON served.Tid = ticket.Tid INNER JOIN tblemployee as driver ON served.EmployeeID = driver.EmployeeID INNER JOIN tblvehicle as vehicle on served.vehicleID = vehicle.vehicleID WHERE served.ustamp BETWEEN :dateFromtxt AND :dateTotxt AND served.ticketNo LIKE CONCAT('%',:ticketnotxt,'%') AND ticket.upassenger LIKE CONCAT('%',:passengertxt,'%') AND served.EmployeeID LIKE CONCAT('%',:didtxt,'%') AND served.vehicleID LIKE CONCAT('%',:vidtxt,'%')");
		$ajaxSearchQry->bindParam(':dateFromtxt',$_POST['dateFrom']);
		$ajaxSearchQry->bindParam(':dateTotxt',$_POST['dateTo']);
		$ajaxSearchQry->bindParam(':ticketnotxt',$_POST['SearchTicketNo']);
		$ajaxSearchQry->bindParam(':passengertxt',$_POST['SearchPassenger']);
		$ajaxSearchQry->bindParam(':didtxt',$_POST['SearchDriver']);
		$ajaxSearchQry->bindParam(':vidtxt',$_POST['SearchVehicle']);
		$ajaxSearchQry->execute();
		if($ajaxSearchQry->rowCount()>0)
		{
			while($ajaxrow=$ajaxSearchQry->fetch(PDO::FETCH_OBJ))
			{
?>
								<tr>
									<td><?php echo $ajaxrow->ticketNo; ?></td>
									<td><?php echo $ajaxrow->upassenger; ?></td>
									<td><?php echo $ajaxrow->udate; ?></td>
									<td><?php echo $ajaxrow->DriverName; ?></td>
									<td><?php echo $ajaxrow->Vname; ?></td>
									<td><?php echo $ajaxrow->udestination; ?></td>
										<?php StatusColor($ajaxrow->Status);?>
									<td>
										<div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                    
                                            <li><a href="#" onClick="PrintData('../api/summary_print.php','<?php echo base64_encode($ajaxrow->servedID); ?>')">Print</a></li>
                                            <li><a href="#" onClick='remove("<?php echo $ajaxrow->serveID;?>","../api/summaryreport.ajax.php","summaryreport.php");'>Delete</a></li>
                                        </ul>
                                    </div>
									</td>
								</tr>
<?php
			}//end of while
		}
		else
		{
				echo'<tr><td>No data found!</td></tr>';
		}

}catch(Exception $e){
	echo"ERROR : ".$e->getMessage();
}
?>                                
                               			
                                	</tbody>
                                	</table>      
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

<?php
}
?>
