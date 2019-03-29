
<?php 
  
    require_once('../api/config.php');
    require_once('header.php');
    
    $TID = base64_decode($_GET['id']);

    $EditQuery = $mysql->prepare("SELECT * FROM tblticket WHERE Tid=?");
    $EditQuery->bindParam(1,$TID);
    $EditQuery->execute();
    if($EditQuery->rowCount() > 0):
        while($data=$EditQuery->fetch(PDO::FETCH_OBJ))
            {

 ?>            


             <div class="row" >
                <div class="col-lg-12" style="margin-top:1em;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Passenger Ticket
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form role="form" id="Form-ticket">
                                    <input type="hidden" name="TID" id="TID" value="<?php echo $data->Tid; ?>" />
                                        <input type="hidden" value="editticket" id="action" name="action"/>
                                        <input type="hidden" value="<?php echo $data->ticketNo;?>" id="ticketIDS" name="ticketIDS"/>
                                        <input type="hidden" name="editustamp" value="<?php echo $data->ustamp;?>"/>
                                    <div class="col-lg-5">
                                        <input type="hidden" value="editticket" id="action" name="action"/>
                                        <div class="form-group">
                                            <label for="pfullname">Fullname</label>
                                            <input class="form-control"  style="text-transform: uppercase" value="<?php echo $data->upassenger;?>" name="editFullname" id="editFullname">
                                            <p class="help-block"></p>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="division">Division</label>
                                            <input class="form-control" name="editDivision" id="editDivision" style="text-transform: uppercase" value="<?php echo $data->divisioN; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="destinion">Destination</label>
                                            <input class="form-control" name="editdestination" id="editdestination" value="<?php echo $data->udestination;?>">
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" name="editDate" id="editDate" class="form-control" value="<?php echo $data->udate;?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <input type="time" class="form-control" name="edittime" id="edittime" value="<?php echo $data->utime;?>">
                                        </div>
                                       
                                        
                                        
                                    </div>
                                
                                <div class="col-lg-1"></div>

                                <div class="col-lg-5">
                                       <div class="form-group">
                                            <label>Driver</label>
                                            <select name="editdriver" id="editdriver" class="form-control">
                                                 <?php
                                                    $getDriverQuery = $mysql->prepare("SELECT * FROM tblemployee WHERE Designation='0'");
                                                    $getDriverQuery->execute();
                                                    while($driver=$getDriverQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            if($driver->EmployeeID == $data->EmployeeID)
                                                            {
                                                            echo'<option value="'.$driver->EmployeeID.'" selected>'.$driver->DfirstName." ".$driver->DlastName."</option>";
                                                            }
                                                            else
                                                            {
                                                                echo'<option value="'.$driver->EmployeeID.'">'.$driver->DfirstName." ".$driver->DlastName."</option>";
                                                            }
                                                        }
                                                ?>  
                                               
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Vehicle</label>
                                            <select name="editvehicle" id="editvehicle" class="form-control" >
                                                <?php
                                                    $getVehicleQuery = $mysql->prepare("SELECT * FROM tblvehicle");
                                                    $getVehicleQuery->execute();
                                                    while($vehicle=$getVehicleQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            if($vehicle->vehicleID == $data->vehicleID)
                                                            {
                                                                 echo'<option value="'.$vehicle->vehicleID.'" selected>'.$vehicle->Vname."</option>";
                                                            }
                                                            else
                                                            {
                                                                echo'<option value="'.$vehicle->vehicleID.'">'.$vehicle->Vname."</option>";
                                                            }
                                                        }
                                                ?>  
                                                
                                                
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <select name="editremarks" id="editremarks" class="form-control">
                                                <?php
                                                    $RemarksQuery = $mysql->prepare("SELECT DISTINCT Remarks FROM tblticket WHERE Remarks=?");
                                                    $RemarksQuery->bindParam(1,$data->Remarks);
                                                    $RemarksQuery->execute();
                                                    while($rowRemarks=$RemarksQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                           if($rowRemarks->Remarks == $data->Remarks):
                                                            echo'<option value="'.$rowRemarks->Remarks.'" selected>'.$rowRemarks->Remarks."</option>";
                                                            endif;

                                                        }
                                                        
                                                ?>  
                                                    <option value="Conduction Only">Conduction Only</option>
                                                    <option value="Conduction To and From">Conduction To and From</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Purpose">Purpose of Travel</label>
                                            <textarea name="editpurpose" id="editpurpose" style="width:400px;" ><?php echo $data->Purpose;?></textarea>
                                        </div>

                                         <div class="form-group">
                                            <label for="Approve">Approve By:</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="editpproveBy" value="<?php echo $data->Approvedby;?>" id="editpproveBy" />
                                        </div>     
                                    </div>

                                <div class="row" >
                                                <div class="col-md-4" style="float:left;margin-left:2em;">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
                                                </div>
                                         </div>
                                    </form> 
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?php
     
            }//end of while loop
    endif; //end of rowcount
?>


<?php require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-ticket").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/ticket.ajax.php",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              success: function(data)
                { 
                 swal({
                        title: "Success",
                        text: data,
                        icon: "success"
                    }).then(function() {
                        window.location = "home.php";
                    });
                 

                }
                                 
                
                       
             });
          }));
        });




</script>

