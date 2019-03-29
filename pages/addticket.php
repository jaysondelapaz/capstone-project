<?php require_once('header.php'); require_once('../api/config.php'); ?>
            
            <div class="row">
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Ticket Reservation</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" style="margin-top:1em;">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Passenger Ticket
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form role="form" id="Form-ticket">

                                    <div class="col-lg-4">

                                        <div class="form-group">
                                            
                                            <label for="Fullname">Fullname</label>
                                            <input type="text" class="form-control"  style="text-transform: uppercase;" name="Fullname" id="Fullname" required>
                                            <div class="contents" style="margin-top: 1em;"></div>
                                             <button type="button" id="add" class="add">+</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">                       
                                        
                                        <div class="form-group">
                                            <label for="division">Division</label>
                                            <input class="form-control" name="Division" id="Division" placeholder="Division" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="destinion">Destination</label>
                                            <input class="form-control" name="destination" id="destination" placeholder="Destination" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" name="Date" id="Datetxt" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <input type="time" class="form-control" name="time" id="time"  required>
                                             <p class="help-block">hh:mm AM/PM</p>
                                            <!-- <select name="tm">
                                                <option value="">01</option>
                                                 <option value="">02</option>
                                            </select>

                                             <select name="tm">
                                                <option value="">01</option>
                                                 <option value="">02</option>
                                            </select>

                                             <select name="ap">
                                                <option value="">AM</option>
                                                 <option value="">PM</option>
                                            </select>
                                            <span>h/m/sec</span> -->
                                        </div>

                                         <div class="form-group">
                                            <label for="Approve">Approve By:</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="ApproveBy" value="" id="ApproveBy" required />
                                        </div> 
                                        
                                        
                                    </div>
                                
            

                                <div class="col-lg-4">
                                       <div class="form-group">
                                             <label>Driver</label>
                                            <select name="Driver" id="Driver" class="form-control">
                                                 <?php
                                                    //today driver


                                                    $getDriverQuery = $mysql->prepare("SELECT EmployeeID,DfirstName,DlastName FROM tblemployee WHERE EmployeeID NOT IN (SELECT distinct EmployeeID FROM tblticket WHERE udate='$Today'  AND Status <> 'Posted') AND Designation='0' ");
                                                    $getDriverQuery->execute();
                                                    while($driver=$getDriverQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            
                                                            echo'<option value="'.$driver->EmployeeID.'" >'.$driver->DfirstName." ".$driver->DlastName."</option>";
                                                           
                                                        }
                                                ?>  
                                               
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label>Vehicle</label>
                                            <select name="Vehicle" id="Vehicle" class="form-control">
                                                <?php
                                                    $getVehicleQuery = $mysql->prepare("select vehicleID,Vname,VplateNo from tblvehicle where vehicleID not in (select distinct vehicleID from tblticket WHERE udate='$Today' and Status <> 'Posted')");
                                                    $getVehicleQuery->execute();
                                                    while($vehicle=$getVehicleQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            
                                                                 echo'<option value="'.$vehicle->vehicleID.'" >'.$vehicle->Vname."</option>";
                                                           
                                                        }
                                                ?>  
                                                
                                                
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <select name="Remarks" id="Remarks" class="form-control">
                                                <option value="Conduction Only">Conduction Only</option>
                                                <option value="Conduction To and From">Conduction To and From</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Purpose">Purpose of Travel</label>
                                            <textarea name="Purpose" id="Purpose" style="width:22em;" required></textarea>
                                        </div>

                                            
                                    </div>

                                <div class="row">
                                   
                                               
                                                <div class="col-lg-4" >
                                                    
                                                    <center><button type="button" id="btn-save" class="btn btn-lg btn-primary btn-block" style="">save</button></center>
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

<?php require_once('footer.php'); ?>

<script>
    $(document).ready(function () {
        $("#btn-save").on('click',function() { 

                var name= new Array();
                    $('input[name^="Fullname"]').each(function() {
                    name.push($(this).val());
                });
                    var passName = JSON.stringify(name);
                    console.log(passName);

            
                $.ajax({
                  url: '../api/ticket.ajax.php',
                  type: 'POST',
                  data: {
                        action:"createticket",     
                        Fullname:passName,
                        Division:$("#Division").val(),
                        destination:$("#destination").val(),
                        Date:$("#Datetxt").val(),
                        time:$("#time").val(),
                        Driver:$("#Driver").val(),
                        Vehicle:$("#Vehicle").val(),
                        Remarks:$("#Remarks").val(),
                        Purpose:$("#Purpose").val(),
                        ApproveBy:$("#ApproveBy").val()

                  },
                  success: function(data){ 
                           swal({
                                title: "Success",
                                text: data,
                                icon: "success"
                            }).then(function() {
                                window.location = "addticket.php";
                            });
                        }
                 }); //end of ajax
          });
    });




$(document).ready(function() {

    $(".add").click(function() {
         Appendtxt();
    });

    function Appendtxt()
    {
        $('<div class="form-group"><input class="form-control"  style="text-transform:uppercase;" name="Fullname" value=""><span class="rem" ><a href="javascript:void(0);" >Remove</span></div>').appendTo(".contents");
    }

    function RemoVe()
    {
        $('.contents').on('click', '.rem', function() {
            $(this).parent("div").remove();
        });
    }RemoVe();
});




</script>

