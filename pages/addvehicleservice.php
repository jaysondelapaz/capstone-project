<?php
require_once('../api/config.php');
require_once('header.php');
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
                            Create Vehicle Service and Maintenance
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-vehicleservice">
                                        <input type="hidden" value="CreateService" id="action" name="action"/>
                                        <div class="form-group">
                                            <label for="Vehicle">Vehicle</label>
                                            <select name="Vehicle" id="Vehicle" class="form-control">
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

                                        <div class="form-group">
                                            <label for="Naturework">Nature of Works done</label>
                                           <textarea name="NatureWork" id="NatureWork" style="width:33em;" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="Amount">Amount</label>
                                            <input type="number" placeholder="0.00" class="form-control" name="Amount" id="Amount">
                                        </div>

                                        <div class="form-group">
                                          <?php
                                            $po = $mysql->prepare("SELECT PONumber FROM tblvehicleservice ORDER BY PONumber DESC LIMIT 1");
                                            $po->execute();
                                            if($po->rowCount() > 0):

                                             while($d=$po->fetch(PDO::FETCH_OBJ))
                                               {
                                                  $poNumber =$d->PONumber;
                                                  $poNumber++;
                                               }
                                            else:  
                                               $poNumber = date('Y');
                                            endif; 
                                            
                                          ?>
                                            <label for="PO">PO / JO #</label>
                                            <input type="text"  class="form-control" name="PoNumber" id="PoNumber" placeholder="<?php echo $poNumber;?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Company">Contracted Company</label>
                                            <input type="text"  class="form-control" name="Company" id="Company">
                                        </div>

                                        <div class="form-group">
                                             <label for="date">Date</label>
                                            <input type="date" name="Datetxt" id="Datetxt" class="form-control" required>
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


<?php require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-vehicleservice").on('submit',(function(e) { 
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

                     swal({ title: data,icon: "success"});
                     $("#NatureWork").val("");
                     $("#Amount").val("");
                     $("#PoNumber").val("");
                     $("#Company").val("");
                     $("#Datetxt").val("");
                    
                }        
             });
          }));
        });
</script>