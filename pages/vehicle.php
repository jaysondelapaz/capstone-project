<?php
require_once('../api/config.php');
require_once('header.php');
?>

<div class="row"></div>
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Vehicle Profile
                        </div>
                        <div class="panel-body">
                             <form id="Form-VehicleFilter">       
                                <input type="hidden" value="AjaxSearch" name="action" id="action"/>
                               <div class="col-lg-4">
                                    <div class="form-group">
                                        <label style="margin-left:7em;">Modelname</label>
                                        <input type="text" class="form-control" name="SearchModel" id="SearchModel"  />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label style="margin-left:7em;">EngineNo.</label>
                                        <input type="text" class="form-control" name="SearchEngine" id="SearchEngine"  />
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="formt-group">
                                        <label style="margin-left:5em;">PlateNo.</label>
                                        <input type="text" class="form-control" name="SearchPlateno" id="SearchPlateno"/>
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
                            Vehicle Profile
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> <!--TICKET LOADER CONTAINER-->
        
                       		<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                       <!--  <th>#</th> -->
                                        <th>Model</th>
                                        <th>EngineNo</th>
                                        <th>ChassisNo</th>
                                        <th>Color</th>
                                        <th>PlateNumber</th>                          
                                      	 <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php
try{
	$stmtvehicle=$mysql->prepare("SELECT * FROM tblvehicle");
	$stmtvehicle->execute();
	if($stmtvehicle->rowCount()>0):
	while($vrow = $stmtvehicle->fetch(PDO::FETCH_OBJ))
		{
?>
	
									<tr>
										
										<td><?php echo $vrow->Vname;?></td>
                                        <td><?php echo $vrow->VengineNo;?></td>
                                        <td><?php echo $vrow->VchassisNo;?></td>
										<td><?php echo $vrow->Vcolor;?></td>
										<td><?php echo $vrow->VplateNo;?></td>
								
										<td>
												<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Action <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li><a href="#">Action</a></li>
										    <li><a href="edit_vehicle.php?id=<?php echo base64_encode($vrow->vehicleID); ?>">Edit</a></li>
										    <li><a href="#" onClick='remove("<?php echo $vrow->vehicleID;?>","../api/vehicle.ajax.php","vehicle.php");'>Delete</a></li>
											
										  </ul>
										</div>
										</td>
									</tr>

<?php	}		
	
	else: echo'<tr>No Data</tr>';
	endif;		
		
}catch(Exception $e){

}

?>


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
$("#Form-VehicleFilter").on('submit',(function(e) {
e.preventDefault();
$.ajax({
url: "../api/vehicle.ajax.php",
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
AutoComplete($("#SearchModel"),3,'../api/vehicle.ajax.php','ModelName');
AutoComplete($("#SearchEngine"),3,'../api/vehicle.ajax.php','EngineNumber');
AutoComplete($("#SearchPlateno"),2,'../api/vehicle.ajax.php','PlateNos');
</script>