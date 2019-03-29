<?php require_once('header.php'); require_once('../api/config.php'); require_once('../api/function.php'); ?>
<div class="row"></div>
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            User Profile
                        </div>
                        <div class="panel-body">
                             <form id="Form-userFilter"> 
                             <input type="hidden" name="action" id="action" value="AjaxSearch"/>      
                            
                               
                                <div class="col-lg-4 col-lg-offset-4" style="margin-bottom: 1em;">
                                      
                                        <label>Username </label>
                                        <input type="text" class="form-control" name="SearchLastname" id="SearchLastname"  />
                                  
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
                            User list
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> 
        
                       		<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                    
                                    	<th>Firstname </th>
                                        <th>Lastname </th>
                                    	<th>Middlename </th>
                                        <th>Username </th>
                                        <th>Password</th>
                                        <th>Userrole</th>
                                      	<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php
try{
	$stmt=$mysql->prepare("SELECT user.uid uid,user.uname as userName,user.upasswd as upassword,employee.DlastName as DlastName, employee.DmiddleName as DmiddleName, employee.DfirstName as DfirstName, employee.Designation as designations FROM tbluser as user inner join tblemployee as employee on user.EmployeeID = employee.EmployeeID");
	$stmt->execute();
	while($dt = $stmt->fetch(PDO::FETCH_OBJ))
		{
?>
	
									<tr>
										<td><?php echo $dt->DfirstName;?></td>
										<td><?php echo $dt->DlastName;?></td>
										<td><?php echo $dt->DmiddleName;?></td>
                                        <td><?php echo $dt->userName;?></td>
                                        <td><?php echo'******';?></td>
                        
                                         <?php Designation($dt->designations) ?>
                                        <?php
                                            
                                        ?>
                                       
										<td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="edit_user.php?id=<?php echo base64_encode($dt->uid); ?>">Edit</a></li>
                                            <li><a href="#" onClick='remove("<?php echo $dt->uid;?>","../api/user.ajax.php","user.php");'>Delete</a></li>
                                            
                                          </ul>
                                        </div>
                                        </td>
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
<?php require_once('footer.php'); ?>
<script>
    
$(document).ready(function (e) {
          $("#Form-userFilter").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/user.ajax.php",
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
AutoComplete($("#SearchLastname"),3,'../api/user.ajax.php','DriverLastname');
//AutoComplete($("#SearchFirstname"),4,'../api/driver.ajax.php','DriverFirstname');
</script>
