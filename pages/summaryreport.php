<?php
require_once('../api/config.php');
require_once('header.php');
require_once('../api/function.php');
?>
<div class="row"></div>
<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Summary Report and history
            </div>
            <div class="panel-body">
                <form id="Form-search">
                    <input type="hidden" name="action" id="action" value="ajaxSearch"/>
                     <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                        
                        <div class="form-group ">
                        <div class="col-gl-4"></div>                           
                            <label>Date From:</label>
                            <input type="date" class="form-control " name="dateFrom" id="dateFrom" value="<?php echo $Today; ?>" />
                           
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
                            <input type="text" class="form-control" name="SearchPassenger" id="SearchPassenger"  />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Driver:</label>
                            
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
                            <label>Vehicle:</label>
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
                    <div class="col-lg-4"><center> <button type="submit" class="btn btn-primary btn-lg-block">Search</button></center></div>
                    <div class="col-lg-4"></div>
                </form>
                </div> <!-- END OF PANEL BODY -->
                <!-- <div class="panel-footer">
                    Panel Footer
                </div> -->
            </div>
        </div>
        
        </div> <!-- END OF ROW FILTER -->
        
        <div class="row" style="margin-top:1em;">
            <div class="col-lg-12 results">

        <?php
        try{
            $stmtHistoryQry = $mysql->prepare("SELECT served.serveID as serveID,served.ticketNo as ticketNo,served.Status as Status,ticket.udestination as udestination,ticket.upassenger as upassenger,ticket.udate as udate,CONCAT(driver.DlastName,' ',driver.DfirstName)as DriverName,vehicle.Vname as Vname FROM tblserved as served INNER JOIN tblticket as ticket ON served.Tid = ticket.Tid INNER JOIN tblemployee as driver ON served.EmployeeID = driver.EmployeeID INNER JOIN tblvehicle as vehicle on served.vehicleID = vehicle.vehicleID WHERE served.ustamp=:today ORDER BY served.ustamp DESC ");
        $stmtHistoryQry->execute([':today'=>$Today]);
        if($stmtHistoryQry->rowCount()>0):
        ?>
       
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Results...
                    </div>
                    <!-- /.panel-heading -->
                     <div style="padding:0.5em"><button type="button" class="btn btn-primary" onClick="PrintReportSummary('../api/summaryreport_print2.php')">Print</button></div>
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
                                while($hrow = $stmtHistoryQry->fetch(PDO::FETCH_OBJ))
                                    {
                            ?>
                            
                            <tr>
                                <td><?php echo $hrow->ticketNo;?></td>
                                <td><?php echo $hrow->upassenger;?></td>
                                <td><?php echo $hrow->udate;?></td>
                                <td><?php echo $hrow->DriverName;?></td>
                                <td><?php echo $hrow->Vname;?></td>
                                <td><?php echo $hrow->udestination;?></td>
                                
                                <?php StatusColor($hrow->Status);?>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                             
                                            <li><a href="#" onClick="PrintData('../api/summaryreport_print.php','<?php echo base64_encode($hrow->ticketNo); ?>')">Print</a></li>
                                            
                                            <?php /*
                                            <li><a href="#" onClick='remove("<?php echo $hrow->serveID;?>","../api/summaryreport.ajax.php","summaryreport.php");'>Delete</a></li>
                                            */?>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php   }
                            
                            else://echo'<tr><td><center>No data found!</center></td></tr>';
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
          $("#Form-search").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/summaryreport.ajax.php",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              success: function(data)
                { 
                     $(".results").html(data);

                     $('#tableData').DataTable({
                        'paging': true,
                        'pageLength': 10,
                    
                    }); 
                }        
             });
          }));
        });


AutoComplete($("#SearchTicketNo"),6,'../api/summaryreport.ajax.php','TicketNO');
AutoComplete($("#SearchPassenger"),4,'../api/summaryreport.ajax.php','PassengeR');

function PrintReportSummary(page){
var dateFrom=$("#dateFrom").val();
var dateTo=$("#dateTo").val();
var ticketNumber = $("#SearchTicketNo").val();
var passengerName=$("#SearchPassenger").val();
var driverID= $("#SearchDriver").val();   
var vehicleid = $("#SearchVehicle").val();
var printPage =page+'?datefrom=' + dateFrom+'&dateto=' +dateTo+'&ticketNumber=' +ticketNumber +'&passengerName='+passengerName+'&DriverID='+driverID+'&VehicleID='+vehicleid;
  window.open(printPage,'_blank');

}

</script>    