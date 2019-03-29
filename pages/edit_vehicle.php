<?php 
require_once('header.php');
require_once('../api/config.php');
$vID = base64_decode($_GET['id']);

try{

    $statementQry = $mysql->prepare("SELECT * FROM tblvehicle WHERE vehicleID='".$vID."'");
    $statementQry->execute();
    if($statementQry->rowCount()>0):
        while($ado=$statementQry->fetch(PDO::FETCH_ASSOC))
            {
               $vehicle_ID= $ado['vehicleID'];
               $vehicleName = $ado['Vname'];
               $engine = $ado['VengineNo'];
               $chassis= $ado['VchassisNo'];
               $vehicleplateno = $ado['VplateNo'];
               $vehicleColor = $ado['Vcolor'];
               
            }
    else:
        echo"No Data";
    endif;    
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
                            Edit Vehicle Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-Editvehicle">
                                        <input type="hidden" value="updateVehicle" id="action" name="action"/>
                                        <input type="hidden" name="v_id" id="v_id" value="<?php echo base64_encode($vehicle_ID);?>">
                                        <div class="form-group">
                                            <label for="Modelname">Modelname</label>
                                            <input class="form-control" name="EditModelnametxt" id="EditModelnametxt" value="<?php echo $vehicleName; ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label for="Engine">Engine No. / Model</label>
                                            <input class="form-control" name="EditEnginetxt" id="EditEnginetxt" value="<?php echo$engine; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Chassis">Chassis No.</label>
                                            <input class="form-control" name="EditChassistxt" id="EditChassistxt" value="<?php echo$chassis;?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Color">Color</label>
                                            <input class="form-control" name="EditColortxt" id="EditColortxt" value="<?php echo $vehicleColor; ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label for="PlateNo">PlateNumber</label>
                                            <input class="form-control" name="EditPlateNotxt" id="EditPlateNotxt" value="<?php echo $vehicleplateno; ?>" />
                                        </div>

                                  
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">update</button>
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
          $("#Form-Editvehicle").on('submit',(function(e) { 
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
                     swal({
                        title: "Success",
                        text: data,
                        icon: "success"
                    }).then(function() {
                        window.location = "vehicle.php";
                    });
                     
                }        
             });
          }));
        });




</script>

