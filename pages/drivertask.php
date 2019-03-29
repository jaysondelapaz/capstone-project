<?php
require_once('../api/config.php');
require_once('../api/function.php');
require_once('header.php');
?>

<div class="row"></div>
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Driver Task
                        </div>
                        <div class="panel-body">
                             <form id="Form-taskFilter">       
                                <input type="hidden" value="AjaxSearch" name="action" id="action"/>
                               <div class="col-lg-4 col-lg-offset-4">
                                    <div class="form-group">
                                        <label style="margin-left:7em;">Driver</label>
                                        <select name="Drivertxt" id="Drivertxt" class="form-control">
                                            <option value="" selected>Select Driver</option>
                                                 <?php
                                                    //today driver


                                                    $getDriverQuery = $mysql->prepare("SELECT EmployeeID,DfirstName,DlastName from tblemployee where Designation='0'");
                                                    $getDriverQuery->execute();
                                                    while($driver=$getDriverQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            
                                                            echo'<option value="'.$driver->EmployeeID.'" >'.$driver->DfirstName." ".$driver->DlastName."</option>";
                                                           
                                                        }
                                                ?>  
                                               
                                            </select>
                                    </div>
                                </div>

                                 
                                <div class="col-lg-12"><center> <button type="submit" class="btn btn-primary btn-lg-block">Search</button></center></div>
                               
                            </form>
                        </div> <!-- END OF PANEL BODY -->
                        <!-- <div class="panel-footer">
                            Panel Footer
                        </div> -->
                    </div>
    </div>
    
</div> <!-- END OF ROW FILTER -->

			<div class="row" style="margin-top:1em;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Subject to deliver
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> <!--TICKET LOADER CONTAINER-->
        
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
                                           <!--  <th>Status</th> -->
                                          
                                        </tr>
                                    </thead>
                                <tbody>

<?php
try{
	$stmttask=$mysql->prepare("SELECT ticket.ticketNo as ticketNo, ticket.upassenger as upassenger, ticket.udestination as udestination, ticket.udate as udate, ticket.utime as utime,ticket.Status as Status,ticket.Remarks as Remarks,ticket.EmployeeID as EmployeeID, ticket.vehicleID as vehicleID,ticket.Purpose as Purpose, ticket.Approvedby as Approvedby, CONCAT(driver.DfirstName,' ',driver.DlastName)as DriverName, vehicle.Vname as VehicleName, vehicle.VplateNo as PlateNo FROM tblticket as ticket LEFT JOIN tblemployee as driver ON ticket.EmployeeID = driver.EmployeeID LEFT JOIN tblvehicle as vehicle ON ticket.vehicleID = vehicle.vehicleID WHERE ticket.Status IN ('Pending','Confirmed') AND ticket.udate=:nowToday");
	$stmttask->execute([':nowToday'=>$Today]);
    $countPassenger = $stmttask->rowCount();
	if($stmtvehicle->rowCount()>0):
	while($vrow = $stmttask->fetch(PDO::FETCH_OBJ))
		{
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
										
								
										<!-- <td>
												<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Action <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li><a href="#">Action</a></li>
										    <li><a href="edit_vehicle.php?id=<?php //echo base64_encode($vrow->vehicleID); ?>">Edit</a></li>
										    <li><a href="#" onClick='remove("<?php //echo $vrow->vehicleID;?>","../api/vehicle.ajax.php","vehicle.php");'>Delete</a></li>
											
										  </ul>
										</div>
										</td> -->
									</tr>

<?php	}		
	
	else: echo'<tr>No Data</tr>';
	endif;		
		
}catch(Exception $e){

}

?>

                                    <tfoot>
                                         <tr><td colspan="9">Total of <?php echo $countPassenger; ?> passenger's</td></tr>                       
                                    </tfoot>
								</tbody>
							</table>
     
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


<?php require_once('footer.php');?>
<script>
$(document).ready(function (e) {
$("#Form-taskFilter").on('submit',(function(e) {
e.preventDefault();
$.ajax({
url: "../api/drivertask.ajax.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data)
{
$(".results").html(data);
}
});
}));
});

</script>