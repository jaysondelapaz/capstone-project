<?php require_once('header.php');
 require_once('../api/config.php');
 require_once('../api/function.php');
 ?>
<style type="text/css">
label{
    margin:auto;
}
</style>
      
            <div class="row">
            </div>
            <!-- /.row -->
            <div class="row" style="margin-top:1em;">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ticket fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php 
                                            try{
                                                $TicketQryp=$mysql->prepare("SELECT * FROM tblticket WHERE Status='Pending'");
                                                $TicketQryp->execute();
                                                if($TicketQryp->rowCount()>0):
                                                    $count = $TicketQryp->rowCount();
                                                    echo $count;
                                                else:echo 0;
                                                endif;    
                                            }catch(Exception $p){
                                                echo"ERROR:".$p->getMessage();
                                            }
                                        ?>
                                    </div>
                                    <div>Pending Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php 
                                            try{
                                                $taskDispatchQry=$mysql->prepare("SELECT * FROM tblticket where udate=:dateNow and Status='Pending'");
                                                $taskDispatchQry->bindParam(':dateNow',$Today);
                                                $taskDispatchQry->execute();
                                                if($taskDispatchQry->rowCount()>0):
                                                    $count = $taskDispatchQry->rowCount();
                                                    echo $count;
                                                else:echo 0;
                                                endif;    
                                            }catch(Exception $u){
                                                echo"ERROR:".$u->getMessage();
                                            }
                                        ?>
                                    </div>
                                    <div>Tasks!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php 
                                            try{
                                                $TicketQry=$mysql->prepare("SELECT * FROM tblticket WHERE ustamp=:today");
                                                $TicketQry->execute([':today'=>$Today]);
                                                if($TicketQry->rowCount()>0):
                                                    $count = $TicketQry->rowCount();
                                                    echo $count;
                                                else:echo 0;
                                                endif;    
                                            }catch(Exception $d){
                                                echo"ERROR:".$d->getMessage();
                                            }
                                        ?>
                                    
                                    </div>
                                    <div>New Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php 
                                            try{
                                                $TicketQry=$mysql->prepare("SELECT * FROM tblticket WHERE Status='Cancelled'");
                                                $TicketQry->execute();
                                                if($TicketQry->rowCount()>0):
                                                    $count = $TicketQry->rowCount();
                                                    echo $count;
                                                else:echo 0;
                                                endif;    
                                            }catch(Exception $l){
                                                echo"ERROR:".$l->getMessage();
                                            }
                                        ?>
                                    </div>
                                    <div>Cancelled Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Ticketing Service
                        </div>
                        <div class="panel-body">
                             <form id="Form-search">   
                             <input type="hidden" name="action" id="action" value="ajaxSearch"/>    
                             <div class="col-lg-2"></div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Date From:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php echo $Today; ?>" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Date To:</label>
                                        <input type="date" class="form-control" name="dateTo" id="dateTo" value="<?php echo $Today; ?>" />
                                    </div>
                                </div>

                                <div class="col-lg-2"></div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Ticket Number</label>
                                        <input type="text" class="form-control" name="SearchTicketNo" id="SearchTicketNo"  />
                                    </div>
                                </div>

                                <div class="col-lg-3"> 
                                    <div class="form-group">
                                        <label>Passenger</label>
                                        <input type="text" class="form-control" name="searchPassenger" id="searchPassenger"  />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="Driver">Driver</label>
                                        <select class="form-control" name="SearchDriver" id="SearchDriver">
                                            <option value="" selected>Select Driver</option>
                                            <?php
                                                    $getDriverQuery = $mysql->prepare("SELECT * FROM tblemployee WHERE Designation='0'");
                                                    $getDriverQuery->execute();
                                                    while($driver=$getDriverQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            
                                                            echo'<option value="'.$driver->EmployeeID.'" >'.$driver->DfirstName." ".$driver->DlastName."</option>";
                                                           
                                                        }
                                                ?>  
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Vehicle</label>
                                        <select class="form-control" name="SearchVehicle" id="SearchVehicle">
                                            <option value="" selected>Select Vehicle</option>
                                            <?php
                                                    $getVehicleQuery = $mysql->prepare("SELECT * FROM tblvehicle");
                                                    $getVehicleQuery->execute();
                                                    while($vehicle=$getVehicleQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            
                                                                 echo'<option value="'.$vehicle->vehicleID.'" >'.$vehicle->Vname."</option>";
                                                           
                                                        }
                                                ?>  
                                        </select>
                                    </div>
                                </div>
                                 
                                <div class="col-lg-4"></div>   
                                <div class="col-lg-4"><center> <button type="submit" id="btn-search" class="btn btn-primary btn-lg-block">Search</button></center></div>
                                <div class="col-lg-4"></div>
                            </form>
                        </div> <!-- END OF PANEL BODY -->
                        <!-- <div class="panel-footer">
                            Panel Footer
                        </div> -->
                    </div>
    </div>
    
</div> <!-- END OF ROW FILTER -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Schedule Tickets
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> <!--TICKET LOADER CONTAINER-->

                            <!--  <div style="padding:0.5em"><button type="button" class="btn btn-primary" onClick="PrintAllticket('../api/ticket_print2.php')">Print</button></div> -->

                             <!-- <table width="100%" class="table table-striped table-bordered table-hover" id="tableData"> -->
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
                                        <!-- <th>Purpose</th> -->
                                        <!-- <th>ApprovedBy</th> -->
                                        <th>Status</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>

        
<?php
    try{
        $loadQuery = $mysql->prepare("SELECT ticket.Tid as Tid,ticket.ticketNo as ticketNo, ticket.upassenger as upassenger, ticket.udestination as udestination, ticket.udate as udate, ticket.utime as utime,ticket.Status as Status,ticket.Remarks as Remarks,ticket.EmployeeID as EmployeeID, ticket.vehicleID as vehicleID,ticket.Purpose as Purpose, ticket.Approvedby as Approvedby, CONCAT(driver.DlastName,' ',driver.DfirstName)as DriverName, vehicle.Vname as VehicleName, vehicle.VplateNo as PlateNo FROM tblticket as ticket LEFT JOIN tblemployee as driver ON ticket.EmployeeID = driver.EmployeeID LEFT JOIN tblvehicle as vehicle ON ticket.vehicleID = vehicle.vehicleID WHERE ticket.Status IN ('Pending','Confirmed','Cancelled') ORDER BY ticket.ustamp DESC ");
        $loadQuery->execute();
        if($loadQuery->rowCount()> 0):
?>
            
           
<?php           
            while($row=$loadQuery->fetch(PDO::FETCH_OBJ))
                {
                    echo'<tr>';
                            echo'<td>'.$row->ticketNo.'</td>';
                            echo'<td>'.$row->upassenger.'</td>';
                            echo'<td>'.$row->udestination.'</td>';
                            echo'<td>'.$row->udate.'</td>';
                            echo'<td>'.$row->utime.'</td>';     
                            echo'<td>'.$row->DriverName.'</td>';    
                            echo'<td>'.$row->VehicleName.'</td>';   
                            echo'<td>'.$row->PlateNo.'</td>';
                            echo'<td>'.$row->Remarks.'</td>';
                            //echo'<td>'.$row->Purpose.'</td>';
                            // echo'<td>'.$row->Appovedby.'</td>';  
                            //echo'<td style="color:green;">'.$row->Status.'</td>';   
                            StatusColor($row->Status);
                            echo'<td>';
?>
                                <!-- Single button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                  
                                        <li><a href="#" onClick='action_btn("<?php echo $row->Tid; ?>","<?php echo $row->ticketNo; ?>","Confirmed","<?php echo $row->Tid; ?>","<?php echo $row->vehicleID; ?>","<?php echo $row->udestination;?>","<?php echo$row->upassenger;?>");'>Confirm</a></li>

                                        <li><a href="#" onClick='action_btn("<?php echo $row->Tid; ?>","<?php echo $row->ticketNo; ?>","Cancelled");'>Cancel</a></li>

                                        <li><a href="#" onClick='action_btn("<?php echo $row->Tid; ?>","<?php echo $row->ticketNo; ?>","Posted","<?php echo $row->EmployeeID; ?>","<?php echo $row->vehicleID; ?>","<?php echo $row->udestination;?>","<?php echo$row->upassenger;?>");'>Post</a></li>

                                        <li><a href="edit_ticket.php?id=<?php echo base64_encode($row->Tid); ?>">Edit</a></li>

                                        <li><a href="#" onClick="PrintData('../api/ticket_print.php','<?php echo base64_encode($row->Tid); ?>')">Print</a></li>

                                        <li><a href="#" onClick='remove("<?php echo $row->Tid;?>","../api/ticket.ajax.php","home.php");'>Delete</a></li>
                                    </ul>
                                </div>
                                </td>
<?php   

                    echo'</tr>';
                }
        else: echo"NO DATA"; endif; 

    }catch(Exception $e)
    {
        echo"Load error: ". $e->getMessage();
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

//CONFIRM / CANCEL also dispatching
function action_btn(id,ticket_number,status,driver,vehicle,destination,passnger)
{
   
        //alert(status);
        $.ajax({
            url:'../api/ticket.ajax.php',
            method:'POST',
            data:{action:'SetAction',id:id,ticket_number:ticket_number,status:status,driver:driver,vehicle:vehicle,dstination:destination,passnger:passnger},
            success: function(response){
               swal({
                        title: "",
                        text: response,
                        icon: "success"
                    }).then(function() {
                        window.location = "home.php";
                    });
                 
            }
        });
   
 
  
}



        $(document).ready(function (e) {
          $("#Form-search").on('submit',(function(e) { 
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
                     $(".results").html(data);
                }        
             });
          }));
        });


AutoComplete($("#SearchTicketNo"),6,'../api/ticket.ajax.php','TicketNO');
AutoComplete($("#searchPassenger"),4,'../api/ticket.ajax.php','PassengeR');

// function PrintAllticket(page){
// var dateFrom=$("#dateFrom").val();
// var dateTo=$("#dateTo").val();
// var ticketNumber = $("#SearchTicketNo").val();
// var passengerName=$("#searchPassenger").val();
// var driverID= $("#SearchDriver").val();   
// var vehicleid = $("#SearchVehicle").val();
// var printPage =page+'?datefrom=' + dateFrom+'&dateto=' +dateTo+'&ticketNumber=' +ticketNumber +'&passengerName='+passengerName+'&DriverID='+driverID+'&VehicleID='+vehicleid;
//   window.open(printPage,'_blank');

// }



</script>