 <?php
require_once('../api/config.php');
require_once('header.php');
?>
<style type="text/css">
label{
    margin:auto;
}
</style>			
<div class="row"></div>
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Driver Profile
                        </div>
                        <div class="panel-body">
                             <form id="Form-DriverFilter"> 
                             <input type="hidden" name="action" id="action" value="AjaxSearch"/>      
                             <div class="col-lg-2"></div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- <label>Date From:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php //echo $Today; ?>" /> -->
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- <label>Date To:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php //echo $Today; ?>" /> -->
                                    </div>
                                </div>

                                <div class="col-lg-2"></div>
								<!--END OF DATA FILTER DIV-->	

                               
                                <div class="col-lg-6">
                                    <div class="col-lg-5"></div>
                                    <div class="form-group col-lg-7">
                                        <label>Lastname </label>
                                        <input type="text" class="form-control" name="SearchLastname" id="SearchLastname"  />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group col-lg-7">
                                        <label >Firstname </label>
                                        <input type="text" class="form-control" name="SearchFirstname" id="SearchFirstname"  />
                                    </div>
                                    <div class="col-lg-4"></div>
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
                            Driver Profile
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> <!--TICKET LOADER CONTAINER-->
        
                       		<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                        <th>DriverID</th>
                                        <th>Lastname</th>
                                        <th>Firstname</th>
                                        <th>Middlename</th>
                                        <th>Birthday</th>
                                      	<th>Address</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php
try{
	$stmt=$mysql->prepare("SELECT * FROM tblemployee WHERE Designation='0'");
	$stmt->execute();
	while($dt = $stmt->fetch(PDO::FETCH_OBJ))
		{
?>
	
									<tr>
										<td><?php echo'00'.$dt->EmployeeID;?></td>
										<td><?php echo $dt->DlastName;?></td>
										<td><?php echo $dt->DfirstName;?></td>
										<td><?php echo $dt->DmiddleName;?></td>
										<td><?php echo $dt->Dbirthday;?></td> 	
										<td><?php echo $dt->Daddress;?></td> 	
										<td><?php echo $dt->Dgender;?></td>
										
									</tr>

<?php			
			
		}
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

<?php
require_once('footer.php');
?>

<script> 
$(document).ready(function (e) {
          $("#Form-DriverFilter").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/driver.ajax.php",
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
AutoComplete($("#SearchLastname"),3,'../api/driver.ajax.php','DriverLastname');
AutoComplete($("#SearchFirstname"),4,'../api/driver.ajax.php','DriverFirstname');
</script>