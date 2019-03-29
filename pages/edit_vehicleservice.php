<?php 
require_once('header.php');
require_once('../api/config.php');
$vID = base64_decode($_GET['id']);

try{

    $stmt=$mysql->prepare("SELECT service.VserviceID as serviceID, service.vehicleID as vehicleid,service.Vdescription as particulaR,service.Vamount as Amount,service.Vservicedate as servicedate,service.PONumber as PONumber,service.Scompany as Company,service.Vstamp as stamp FROM tblvehicleservice as service WHERE service.VserviceID=$vID");
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_OBJ)) {
        $Serviceid = $row->serviceID;
        $vId = $row->vehicleid;
        $Particular = $row->particulaR;
        $Amount = $row->Amount;
        $serviceDate = $row->servicedate;
        $PONumber = $row->PONumber;
        $Company = $row->Company;
        $stamp = $row->stamp;
        
    }
}catch(Exception $i){
    echo"QUERY FAILED: ". $i->getMessage();
}
 ?>

 <div class="row">
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Ticket Reservation</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" style="margin-top:1em;">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Vehicle Service and Maintenance
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-editvehicleservice">
                                        <input type="hidden" value="EditService" id="action" name="action"/>
                                        <input type="hidden" name="editstamp" id="editstamp" value="<?php echo $stamp; ?>" />
                                        <input type="hidden" value="<?php echo base64_encode($Serviceid);?>" name="sid" id="sid"/>
                                        <div class="form-group">
                                            <label for="Vehicle">Vehicle</label>
                                            <select name="VehicleID" id="VehicleID" class="form-control">
                                                 <?php
                                                    $getVehicleQuery = $mysql->prepare("SELECT * FROM tblvehicle");
                                                    $getVehicleQuery->execute();
                                                    while($vehicle=$getVehicleQuery->fetch(PDO::FETCH_OBJ))
                                                        {
                                                            if($vehicle->vehicleID == $vId)
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
                                            <label for="Particular">Particular/Description</label>
                                           <textarea name="Particular" id="Particular" style="width:34em;" ><?php echo $Particular;?> </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="Amount">Amount</label>
                                            <input type="" class="form-control" name="Amount" id="Amount" value="<?php echo $Amount; ?>" /> 
                                        </div>

                                        <div class="form-group">
                                            <label for="Invoice">PO/JO #</label>
                                            <input type="text"  class="form-control" name="POnumber" id="POnumber" value="<?php echo $PONumber; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Company">Contracted Company</label>
                                            <input type="text"  class="form-control" value="<?php echo $Company;?>" name="Company" id="Company">
                                        </div>

                                        <div class="form-group">
                                             <label for="date">Date</label>
                                            <input type="date" name="Datetxt" id="Datetxt" value="<?php echo $serviceDate;?>" class="form-control" >
                                        </div>


                                        <button type="submit" class="btn btn-lg btn-primary btn-block">save</button>
                                    </form>
                                </div>

                                
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
<?php  require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-editvehicleservice").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/servicevehicle.ajax.php",
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
                        window.location = "vehiclemaintenance.php";
                    });
                     
                }        
             });
          }));
        });




</script>

